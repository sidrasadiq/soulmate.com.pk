<?php
include 'layouts/config.php';
include 'layouts/session.php';
include 'layouts/main.php';
include 'layouts/functions.php';
include 'userlayout/header.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    try {
        // Query to fetch user details with related data from foreign key tables
        $query = "SELECT 
                profiles.*, 
                countries.country_name, 
                cities.city_name,
                states.state_name,
                occupation.occupation_name,
                users.username,
                users.email,
                nationality.nationality_name,
                religion.religion_name,
                qualifications.qualification_name,
                user_cast.cast_name
            FROM 
                profiles
            JOIN users ON profiles.user_id = users.id
            LEFT JOIN countries ON profiles.country_id = countries.id
            LEFT JOIN cities ON profiles.city_id = cities.id
            LEFT JOIN states ON profiles.state_id = states.id
            LEFT JOIN occupation ON profiles.occupation_id = occupation.id
            LEFT JOIN nationality ON profiles.nationality_id = nationality.id
            LEFT JOIN religion ON profiles.religion_id = religion.id
            LEFT JOIN qualifications ON profiles.qualification_id = qualifications.id
            LEFT JOIN user_cast ON profiles.cast_id = user_cast.id
            WHERE profiles.user_id = ?";

        $stmtUser = $conn->prepare($query);
        if (!$stmtUser) {
            throw new Exception("Query preparation failed: " . $conn->error);
        }

        $stmtUser->bind_param('i', $userId);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();

        if ($resultUser->num_rows > 0) {
            $profile = $resultUser->fetch_assoc();
        } else {
            $_SESSION['message'] = ['type' => 'error', 'content' => 'Profile not found'];
            header("Location: showprofile.php");
            exit();
        }

        $stmtUser->close();
    } catch (Exception $e) {
        $_SESSION['message'] = ['type' => 'error', 'content' => 'Error: ' . $e->getMessage()];
        header("Location: showprofile.php");
        exit();
    }
} else {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'User not logged in'];
    header("Location: login.php");
    exit();
}

// Fetch data for dropdowns
$countries = $cities = $states = $nationalities = $religions = $qualifications = $occupations = $casts = [];

try {
    // Fetch dropdown data for related tables
    $dropdownTables = [
        'countries' => 'country_name',
        'cities' => 'city_name',
        'states' => 'state_name',
        'nationality' => 'nationality_name',
        'religion' => 'religion_name',
        'qualifications' => 'qualification_name',
        'occupation' => 'occupation_name',
        'user_cast' => 'cast_name'
    ];

    foreach ($dropdownTables as $table => $column) {
        $query = "SELECT id, $column FROM $table ORDER BY id ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            ${$table}[] = $row; // Dynamically populate the appropriate array
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'Error fetching dropdown data: ' . $e->getMessage()];
    header("Location: editprofile.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btnUpdatePersonalInfo"])) {
    // Sanitize and validate input data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth']));
    $bio = htmlspecialchars(trim($_POST['bio']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $whatsapp_contact = htmlspecialchars(trim($_POST['whatsapp_contact']));
    $cnic = htmlspecialchars(trim($_POST['cnic']));
    // Handle optional field
    $social_links = !empty($_POST['social_links']) ? htmlspecialchars(trim($_POST['social_links'])) : null;

    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploads_dir = 'uploads/profile_pictures'; // Define your uploads directory
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true); // Create directory if it doesn't exist
        }
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $profile_picture = $uploads_dir . '/' . uniqid() . '_' . basename($_FILES['profile_picture']['name']);
        if (!move_uploaded_file($tmp_name, $profile_picture)) {
            $profile_picture = null; // Reset if the upload fails
        }
    }

    // Update data in the database
    $sql = "UPDATE profiles SET 
                first_name = ?, 
                last_name = ?, 
                gender = ?, 
                date_of_birth = ?, 
                bio = ?, 
                profile_picture = COALESCE(?, profile_picture), 
                contact_number = ?, 
                whatsapp_contact = ?, 
                cnic = ?, 
                social_links = ? 
            WHERE user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            'ssssssssssi',
            $first_name,
            $last_name,
            $gender,
            $date_of_birth,
            $bio,
            $profile_picture,
            $contact_number,
            $whatsapp_contact,
            $cnic,
            $social_links,
            $_SESSION['user_id'] // Assuming the user_id is stored in the session
        );

        // Execute and check if successful
        if ($stmt->execute()) {
            echo "Personal info updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Edit Profile | Soulmate </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Highlight the radio button on focus and when checked */
        .highlight-radio:focus,
        .highlight-radio:checked {
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            /* Bootstrap focus box-shadow */
            border-color: #F5367B !important;
            /* Change border color on selection */
        }

        /* Custom color for checked radio buttons */
        .highlight-radio:checked {
            background-color: #F5367B !important;
            /* Highlight color when checked */
            border-color: #F5367B !important;
        }

        .form-check {
            justify-content: space-between;
            padding: 20px 40px;
        }

        .headCustom {
            color: #4CA8F0 !important;
        }

        .container {
            margin-left: 13px;
        }
    </style>

</head>

<body class="bg-light w-100">
    <div class="container">
        <h3 class=" text-muted mt-5">Edit Profile</h3>
        <div class="max-width-3">
            Answering these profile questions will help other users find you in search results and help us to find you <br> more accurate matches.
            <em>Answer all questions below to complete this step.</em>

        </div>
        <br>
        <h4 class="headCustom ">Your Basics</h4>
        <hr>
        <!-- row start -->
        <div class="row ">
            <div class="col-12">

                <div class="card bg-light border-0">
                    <div class="card-body">
                        <p class="text-muted fs-14"> </p>
                        <div class="row">
                            <div>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation" novalidate>
                                    <div class="row">
                                        <!-- First Name Input -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="firstName" class="form-label text-muted">First Name:</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($profile['first_name']); ?>"
                                                    id="firstName"
                                                    name="first_name"
                                                    class="form-control"
                                                    required
                                                    placeholder="Enter Your First Name">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please fill this field.</div>
                                            </div>
                                        </div>
                                        <!-- Last Name Input -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="lastName" class="form-label text-muted">Last Name:</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($profile['last_name']); ?>"
                                                    id="lastName"
                                                    name="last_name"
                                                    class="form-control"
                                                    required
                                                    placeholder="Enter Your Last Name">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please fill this field.</div>
                                            </div>
                                        </div>
                                        <!-- Gender Selection -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label text-muted">Gender:</label>
                                                <select class="form-select" id="gender" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="male" <?php echo $profile['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                    <option value="female" <?php echo $profile['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                                    <option value="other" <?php echo $profile['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please select a gender.</div>
                                            </div>
                                        </div>
                                        <!-- Date of Birth Input -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label text-muted">Date of Birth:</label>
                                                <input type="date"
                                                    value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>"
                                                    id="dob"
                                                    name="date_of_birth"
                                                    class="form-control"
                                                    required>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please fill this field.</div>
                                            </div>
                                        </div>
                                        <!-- Bio Input -->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="bio" class="form-label text-muted">Bio:</label>
                                                <textarea class="form-control"
                                                    id="bio"
                                                    name="bio"
                                                    rows="4"
                                                    placeholder="Write something about yourself..."
                                                    required><?php echo htmlspecialchars($profile['bio']); ?></textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please fill this field.</div>
                                            </div>
                                        </div>
                                        <!-- Profile Picture Upload -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="profilePicture" class="form-label text-muted">Profile Picture:</label>
                                                <input type="file"
                                                    id="profilePicture"
                                                    name="profile_picture"
                                                    class="form-control">
                                                <div class="text-muted small">Upload a clear profile picture (optional).</div>
                                            </div>
                                        </div>
                                        <!-- Contact Number Input -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="contactNumber" class="form-label text-muted">Contact Number:</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($profile['contact_number']); ?>"
                                                    id="contactNumber"
                                                    name="contact_number"
                                                    class="form-control"
                                                    placeholder="Enter your contact number">
                                            </div>
                                        </div>
                                        <!-- WhatsApp Contact Input -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="whatsappContact" class="form-label text-muted">WhatsApp Contact:</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($profile['whatsapp_contact']); ?>"
                                                    id="whatsappContact"
                                                    name="whatsapp_contact"
                                                    class="form-control"
                                                    placeholder="Enter your WhatsApp number">
                                            </div>
                                        </div>
                                        <!-- CNIC Input -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="cnic" class="form-label text-muted">CNIC:</label>
                                                <input type="text"
                                                    value="<?php echo htmlspecialchars($profile['cnic']); ?>"
                                                    id="cnic"
                                                    name="cnic"
                                                    class="form-control"
                                                    placeholder="Enter your CNIC">
                                            </div>
                                        </div>
                                        <!-- Social Links Input -->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="socialLinks" class="form-label text-muted">Social Links:</label>
                                                <textarea class="form-control"
                                                    id="socialLinks"
                                                    name="social_links"
                                                    rows="2"
                                                    placeholder="Enter your social media links (optional)"><?php echo htmlspecialchars($profile['social_links']); ?></textarea>
                                            </div>
                                        </div>
                                        <!-- Submit Button -->
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" name="btnUpdatePersonalInfo" id="btnUpdatePersonalInfo" class="btn btn-primary">Save Personal Info</button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div><!-- row end -->
    </di>
    <?php include 'userlayout/footer.php'; ?>

    <!-- Add Bootstrap JavaScript bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profilePicPreview');
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    </html>
</body>