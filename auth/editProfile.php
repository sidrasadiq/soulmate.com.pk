<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/main.php';
include 'layouts/functions.php';
include 'userlayout/header.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    try {
        // Start a transaction for data fetching
        $conn->begin_transaction();

        // Prepare query to fetch profile details
        $query =
            "SELECT p.*,
                c.country_name AS country_name,
                st.state_name AS state_name,
                ct.city_name AS city_name,
                rel.religion_name AS religion_name,
                edu.qualification_name AS qualification_name
            FROM profiles p
                LEFT JOIN countries c ON p.country_id = c.id
                LEFT JOIN states st ON p.state_id = st.id
                LEFT JOIN cities ct ON p.city_id = ct.id
                LEFT JOIN religion rel ON p.religion_id = rel.id
                LEFT JOIN qualifications edu ON p.qualification_id = edu.id
            WHERE user_id = ?";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $conn->error);
        }

        // Bind the user ID and execute the query
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profile = $result->fetch_assoc();
        } else {
            $_SESSION['message'] = ['type' => 'error', 'content' => 'Profile not found'];
            header("Location: showprofile.php");
            exit();
        }

        // Fetch countries
        $queryCountries = "SELECT id, country_name FROM countries ORDER BY id ASC;";
        $stmtCountries = $conn->prepare($queryCountries);
        $stmtCountries->execute();
        $resultCountries = $stmtCountries->get_result();
        $countries = [];
        while ($row = $resultCountries->fetch_assoc()) {
            $countries[] = $row;
        }

        // Fetch states
        $queryStates = "SELECT id, state_name FROM states  ORDER BY id ASC;";
        $stmtStates = $conn->prepare($queryStates);
        $stmtStates->execute();
        $resultStates  = $stmtStates->get_result();
        $states = [];
        while ($row = $resultStates->fetch_assoc()) {
            $states[] = $row;
        }
        // Fetch cities
        $queryCities = "SELECT id, city_name FROM cities ORDER BY id ASC;";
        $stmtCities = $conn->prepare($queryCities);
        $stmtCities->execute();
        $resultCities = $stmtCities->get_result();
        $cities = [];
        while ($row = $resultCities->fetch_assoc()) {
            $cities[] = $row;
        }

        // Fetch Religion
        $queryReligions = "SELECT id, religion_name FROM religion ORDER BY id ASC;";
        $stmtReligions = $conn->prepare($queryReligions);
        $stmtReligions->execute();
        $resultReligions = $stmtReligions->get_result();
        $religions = [];
        while ($row = $resultReligions->fetch_assoc()) {
            $religions[] = $row;
        }

        // Fetch Casts
        $queryCaste = "SELECT id, cast_name FROM user_cast ORDER BY cast_name ASC;";
        $stmtCaste = $conn->prepare($queryCaste);
        $stmtCaste->execute();
        $resultCaste = $stmtCaste->get_result();
        $user_cast = [];
        while ($row = $resultCaste->fetch_assoc()) {
            $user_cast[] = $row;
        }

        // Fetch Qualifications
        $queryQualifications = "SELECT id, qualification_name FROM qualifications ORDER BY id ASC;";
        $stmtQualifications = $conn->prepare($queryQualifications);
        $stmtQualifications->execute();
        $resultQualifications = $stmtQualifications->get_result();
        $qualifications = [];
        while ($row = $resultQualifications->fetch_assoc()) {
            $qualifications[] = $row;
        }

        // Fetch ENUM values for 'my_appearance'
        $queryEnumAppearance =
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'profiles' AND COLUMN_NAME = 'my_appearance';
        ";
        $stmtEnumAppearance = $conn->prepare($queryEnumAppearance);
        $stmtEnumAppearance->execute();
        $resultEnumAppearance = $stmtEnumAppearance->get_result();
        $rowEnumAppearance = $resultEnumAppearance->fetch_assoc();

        // Extract ENUM values from the COLUMN_TYPE field
        $enumValuesAppearance = substr($rowEnumAppearance['COLUMN_TYPE'], 6, -2); // Remove 'enum(' and ')'
        $enumValuesAppearance = explode("','", $enumValuesAppearance); // Split the values into an array

        // Fetch ENUM values for 'body_type'
        $queryEnumBodyType =
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'profiles' AND COLUMN_NAME = 'body_type';
            ";
        $stmtEnumBodyType = $conn->prepare($queryEnumBodyType);
        $stmtEnumBodyType->execute();
        $resultEnumBodyType = $stmtEnumBodyType->get_result();
        $rowEnumBodyType = $resultEnumBodyType->fetch_assoc();

        // Extract ENUM values for 'body_type'
        $enumValuesBodyType = substr($rowEnumBodyType['COLUMN_TYPE'], 6, -2); // Remove 'enum(' and ')'
        $enumValuesBodyType = explode("','", $enumValuesBodyType); // Split the values into an array

        // Fetch ENUM values for 'drinkAlcohol'
        $queryEnumDrinkAlcohol =
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'profiles' AND COLUMN_NAME = 'drinkAlcohol';
            ";
        $stmtEnumDrinkAlcohol = $conn->prepare($queryEnumDrinkAlcohol);
        $stmtEnumDrinkAlcohol->execute();
        $resultEnumDrinkAlcohol = $stmtEnumDrinkAlcohol->get_result();
        $rowEnumDrinkAlcohol = $resultEnumDrinkAlcohol->fetch_assoc();

        // Extract ENUM values for 'drinkAlcohol'
        $enumValuesDrinkAlcohol = substr($rowEnumDrinkAlcohol['COLUMN_TYPE'], 6, -2); // Remove 'enum(' and ')'
        $enumValuesDrinkAlcohol = explode("','", $enumValuesDrinkAlcohol); // Split the values into an array

        // Fetch ENUM values for 'smoking'
        $queryEnumSmoking =
            "SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'profiles' AND COLUMN_NAME = 'smoking';
            ";
        $stmtEnumSmoking = $conn->prepare($queryEnumSmoking);
        $stmtEnumSmoking->execute();
        $resultEnumSmoking = $stmtEnumSmoking->get_result();
        $rowEnumSmoking = $resultEnumSmoking->fetch_assoc();

        // Extract ENUM values for 'smoking'
        $enumValuesSmoking = substr($rowEnumSmoking['COLUMN_TYPE'], 6, -2); // Remove 'enum(' and ')'
        $enumValuesSmoking = explode("','", $enumValuesSmoking); // Split the values into an array

        // Fetch ENUM values for 'living_arrangements'
        $queryEnumLivingArrangements = "
            SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'profiles' AND COLUMN_NAME = 'living_arrangements';
        ";
        $stmtEnumLivingArrangements = $conn->prepare($queryEnumLivingArrangements);
        $stmtEnumLivingArrangements->execute();
        $resultEnumLivingArrangements = $stmtEnumLivingArrangements->get_result();
        $rowEnumLivingArrangements = $resultEnumLivingArrangements->fetch_assoc();

        // Extract ENUM values for 'living_arrangements'
        $enumValuesLivingArrangements = substr($rowEnumLivingArrangements['COLUMN_TYPE'], 6, -2); // Remove 'enum(' and ')'
        $enumValuesLivingArrangements = explode("','", $enumValuesLivingArrangements); // Split the values into an array


        $conn->commit();
        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message'] = ['type' => 'error', 'content' => 'Error: ' . $e->getMessage()];

        header("Location: showprofile.php");
        exit();
    }
} else {
    // If the user is not logged in, redirect to login page
    $_SESSION['message'] = ['type' => 'error', 'content' => 'User not logged in'];
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnUpdatePersonalInfo'])) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Sanitize and validate the form data
        $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in session

        // Sanitize inputs
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $gender = trim($_POST['gender']);
        $date_of_birth = date('Y-m-d', strtotime($_POST['date_of_birth']));
        $mother_tongue = htmlspecialchars(trim($_POST['mother_tongue']));
        $bio = htmlspecialchars(trim($_POST['bio']));
        $contact_number = htmlspecialchars(trim($_POST['contact_number']));
        $whatsapp_contact = htmlspecialchars(trim($_POST['whatsapp_contact']));
        $cnic = htmlspecialchars(trim($_POST['cnic']));
        $country_id = (int) $_POST['country_id'];
        $state_id = (int) $_POST['state_id'];
        $city_id = (int) $_POST['city_id'];
        $religion_id = (int) $_POST['religion_id'];
        $marital_status = $_POST['marital_status'];
        $my_appearance = $_POST['my_appearance'];
        $body_type = $_POST['body_type'];
        $height = (float) $_POST['height'];
        $weight = (float) $_POST['weight'];
        $drinkAlcohol = $_POST['drinkAlcohol'];
        $smoking = $_POST['smoking'];

        // Validate required fields
        if (empty($first_name) || empty($last_name) || empty($gender) || empty($date_of_birth) || empty($contact_number)) {
            throw new Exception("Required fields cannot be empty.");
        }

        // Additional validation for fields like contact numbers, email, etc.
        if (!preg_match("/^[0-9]{13}$/", $cnic)) {
            throw new Exception("Invalid CNIC format.");
        }

        // if (!preg_match("/^[0-9]{10}$/", $contact_number)) {
        //     throw new Exception("Invalid contact number format.");
        // }

        // if (!empty($whatsapp_contact) && !preg_match("/^[0-9]{10}$/", $whatsapp_contact)) {
        //     throw new Exception("Invalid WhatsApp contact format.");
        // }

        // Prepare the SQL query to update the profile
        $query =
            "UPDATE profiles SET
                first_name = ?, last_name = ?, gender = ?, date_of_birth = ?, mother_tongue = ?, bio = ?, 
                contact_number = ?, whatsapp_contact = ?, cnic = ?, country_id = ?, state_id = ?, city_id = ?, 
                religion_id = ?, marital_status = ?, my_appearance = ?, body_type = ?, height = ?, weight = ?, 
                drinkAlcohol = ?, smoking = ?
            WHERE user_id = ?;
        ";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        // Bind the parameters to the prepared statement
        $stmt->bind_param(
            "sssssssssiiiisssddssi",
            $first_name,
            $last_name,
            $gender,
            $date_of_birth,
            $mother_tongue,
            $bio,
            $contact_number,
            $whatsapp_contact,
            $cnic,
            $country_id,
            $state_id,
            $city_id,
            $religion_id,
            $marital_status,
            $my_appearance,
            $body_type,
            $height,
            $weight,
            $drinkAlcohol,
            $smoking,
            $user_id
        );

        // Execute the query
        if (!$stmt->execute()) {
            error_log("SQL Error: " . $stmt->error);
            throw new Exception("Error executing query.");
        }

        // Commit the transaction
        $conn->commit();

        // Set success message
        $_SESSION['message'][] = ["type" => "success", "content" => "Profile Updated Successfully!"];

        // Redirect to the profile page
        header("Location: editProfile.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollback();

        // Set error message in session
        $_SESSION['message'][] = ["type" => "danger", "content" => "Error updating profile: "  . $e->getMessage()];

        // Redirect back to the form or show an error
        header("Location: editprofile.php");
        exit();
    } finally {
        // Close the statement
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnUpdateEduInfo'])) {
    try {
        // Retrieve form data
        $qualification_id = $_POST['qualification_id'] ?? null;
        $last_university_name = $_POST['last_university_name'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in the session

        // Input validation
        if (empty($qualification_id) || empty($last_university_name) || empty($user_id)) {
            $_SESSION['message'][] = ["type" => "error", "content" => "All fields are required."];
            header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
            exit;
        }

        // Begin transaction
        $conn->begin_transaction();

        // Update query with prepared statement
        $query = "UPDATE profiles SET qualification_id = ?, last_university_name = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        // Bind parameters to prevent SQL injection
        $stmt->bind_param("isi", $qualification_id, $last_university_name, $user_id);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Failed to update profile: " . $stmt->error);
        }

        // Commit transaction
        $conn->commit();

        // Close the statement
        $stmt->close();

        // Success message
        $_SESSION['message'][] = ["type" => "success", "content" => "Educational Record updated successfully!"];
    } catch (Exception $e) {

        $conn->rollback();

        // Error message
        $_SESSION['message'][] = ["type" => "error", "content" => "An error occurred: " . $e->getMessage()];
    }

    // Redirect to the same page to display messages
    header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnUpdateEmploymentInfo'])) {
    try {
        // Retrieve form data
        $is_employed = $_POST['is_employed'] ?? null;
        $employment_type = $_POST['employment_type'] ?? null;
        $employment_address = $_POST['employment_address'] ?? null;
        $designation = $_POST['designation'] ?? null;
        $company_name = $_POST['company_name'] ?? null;
        $salary = $_POST['salary'] ?? null;
        $annual_income = $_POST['annual_income'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in the session

        // Input validation
        if (empty($is_employed) || empty($user_id)) {
            $_SESSION['message'][] = ["type" => "error", "content" => "Employment status is required."];
            header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
            exit;
        }

        // Begin transaction
        $conn->begin_transaction();

        // Update query with prepared statement
        $query = "UPDATE profiles 
                  SET is_employed = ?, employment_type = ?, employment_address = ?, designation = ?, company_name = ?, salary = ?, annual_income = ? 
                  WHERE user_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        // Bind parameters to prevent SQL injection
        $stmt->bind_param(
            "ssssssdi",
            $is_employed,
            $employment_type,
            $employment_address,
            $designation,
            $company_name,
            $salary,
            $annual_income,
            $user_id
        );

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Failed to update profile: " . $stmt->error);
        }

        // Commit transaction
        $conn->commit();

        // Close the statement
        $stmt->close();

        // Success message
        $_SESSION['message'][] = ["type" => "success", "content" => "Employment information updated successfully!"];
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();

        // Error message
        $_SESSION['message'][] = ["type" => "error", "content" => "An error occurred: " . $e->getMessage()];
    }

    // Redirect to the same page to display messages
    header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
    exit;
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

        /* Base styles for all custom alerts */
        .custom-alert {
            color: #fff;
            /* White text for better contrast */
            border: none;
            /* Remove default border */
            padding: 1rem;
            font-size: 1rem;
            border-radius: 0.5rem;
            /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        /* Gradient for success alert (pink to blue) */
        .custom-alert.alert-success {
            background: linear-gradient(90deg, #ff7eb3, #8ec5fc);
            /* Pink to blue gradient */
        }

        /* Optionally customize other alert types */
        .custom-alert.alert-danger {
            background: linear-gradient(90deg, #ff7f7f, #ffafaf);
            /* Red gradient */
        }

        .custom-alert.alert-warning {
            background: linear-gradient(90deg, #fff4a3, #ffeaa1);
            /* Yellow gradient */
        }

        .custom-alert.alert-info {
            background: linear-gradient(90deg, #a3e8ff, #91cfff);
            /* Light blue gradient */
        }

        /* Ensure text alignment for readability */
        .custom-alert {
            text-align: center;
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
                                <?php displaySessionMessage(); ?>
                                <form id="personalInformationForm" name="personalInformationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation">
                                    <div class="row">
                                        <!-- First Name -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="firstName" class="form-label text-muted">First Name:</label>
                                            <input type="text" id="firstName" name="first_name" class="form-control"
                                                value="<?php echo $profile['first_name']; ?>" required>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="lastName" class="form-label text-muted">Last Name:</label>
                                            <input type="text" id="lastName" name="last_name" class="form-control"
                                                value="<?php echo $profile['last_name']; ?>" required>
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="gender" class="form-label text-muted">Gender:</label>
                                            <select id="gender" name="gender" class="form-select" required>
                                                <option value="">Select Gender</option>
                                                <option value="male" <?php echo $profile['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="female" <?php echo $profile['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                                <option value="other" <?php echo $profile['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                            </select>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="dob" class="form-label text-muted">Date of Birth:</label>
                                            <input type="date" id="dob" name="date_of_birth" class="form-control"
                                                value="<?php echo $profile['date_of_birth']; ?>" required>
                                        </div>

                                        <!-- Mother Tounge -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="mother_tongue" class="form-label text-muted">What is your monter tongue language.</label>
                                            <input type="text" id="mother_tongue" name="mother_tongue" class="form-control"
                                                value="<?php echo $profile['mother_tongue']; ?>" required>
                                        </div>

                                        <!-- Bio -->
                                        <div class="col-lg-12 mb-3">
                                            <label for="bio" class="form-label text-muted">Bio:</label>
                                            <textarea id="bio" name="bio" rows="3" class="form-control" required><?php echo $profile['bio']; ?></textarea>
                                        </div>

                                        <!-- Contact Number -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="contactNumber" class="form-label text-muted">Contact Number:</label>
                                            <input type="text" id="contactNumber" name="contact_number" class="form-control"
                                                value="<?php echo $profile['contact_number']; ?>">
                                        </div>

                                        <!-- WhatsApp Contact -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="whatsappContact" class="form-label text-muted">WhatsApp Contact:</label>
                                            <input type="text" id="whatsappContact" name="whatsapp_contact" class="form-control"
                                                value="<?php echo $profile['whatsapp_contact']; ?>">
                                        </div>

                                        <!-- CNIC -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="cnic" class="form-label text-muted">CNIC:</label>
                                            <input type="text" id="cnic" name="cnic" class="form-control"
                                                value="<?php echo $profile['cnic']; ?>">
                                        </div>

                                        <!-- Country -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="country" class="form-label text-muted">Country:</label>
                                            <select id="country" name="country_id" class="form-select" required>
                                                <option value="">Select Country</option>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?php echo $country['id']; ?>"
                                                        <?php echo $profile['country_id'] == $country['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $country['country_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- State -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="state" class="form-label text-muted">State:</label>
                                            <select id="state" name="state_id" class="form-select" required>
                                                <option value="">Select State</option>
                                                <?php foreach ($states as $state): ?>
                                                    <option value="<?php echo $state['id']; ?>"
                                                        <?php echo $profile['state_id'] == $state['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $state['state_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- City -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="city" class="form-label text-muted">City:</label>
                                            <select id="city" name="city_id" class="form-select" required>
                                                <option value="">Select City</option>
                                                <?php foreach ($cities as $city): ?>
                                                    <option value="<?php echo $city['id']; ?>"
                                                        <?php echo $profile['city_id'] == $city['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $city['city_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Religion -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="religion" class="form-label text-muted">Religion:</label>
                                            <select id="religion" name="religion_id" class="form-select" required>
                                                <option value="">Select Religion</option>
                                                <?php foreach ($religions as $religion): ?>
                                                    <option value="<?php echo $religion['id']; ?>"
                                                        <?php echo $profile['religion_id'] == $religion['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $religion['religion_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Marital Status -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="maritalStatus" class="form-label text-muted">Marital Status:</label>
                                            <select id="maritalStatus" name="marital_status" class="form-select" required>
                                                <option value="single" <?php echo $profile['marital_status'] == 'single' ? 'selected' : ''; ?>>Single</option>
                                                <option value="married" <?php echo $profile['marital_status'] == 'married' ? 'selected' : ''; ?>>Married</option>
                                            </select>
                                        </div>

                                        <!-- Appearance -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="my_appearance" class="form-label text-muted">My Appearance:</label>
                                            <select id="my_appearance" name="my_appearance" class="form-select" required>
                                                <?php
                                                // Loop through the ENUM values and create an <option> for each
                                                foreach ($enumValuesAppearance as $value) {
                                                    // Check if the current value matches the profile value
                                                    $selected = ($profile['my_appearance'] == $value) ? 'selected' : '';
                                                    echo "<option value=\"$value\" $selected>$value</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Display 'body_type' dropdown -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="body_type" class="form-label text-muted">Body Type:</label>
                                            <select id="body_type" name="body_type" class="form-select" required>
                                                <?php
                                                // Loop through the ENUM values for 'body_type' and create an <option> for each
                                                foreach ($enumValuesBodyType as $value) {
                                                    $selected = ($profile['body_type'] == $value) ? 'selected' : '';
                                                    echo "<option value=\"$value\" $selected>$value</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-4 mb-3">
                                            <label for="height" class="form-label text-muted">Height (cm):</label>
                                            <input type="number" id="height" name="height" class="form-control"
                                                value="<?php echo $profile['height']; ?>" step="0.01" min="0" required>
                                        </div>

                                        <div class="col-lg-4 mb-3">
                                            <label for="weight" class="form-label text-muted">Weight (kg):</label>
                                            <input type="number" id="weight" name="weight" class="form-control"
                                                value="<?php echo $profile['weight']; ?>">
                                        </div>

                                        <!-- Display 'drinkAlcohol' dropdown -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="drinkAlcohol" class="form-label text-muted">Do you drink Alcohol?</label>
                                            <select id="drinkAlcohol" name="drinkAlcohol" class="form-select" required>
                                                <?php
                                                // Loop through the ENUM values for 'drinkAlcohol' and create an <option> for each
                                                foreach ($enumValuesDrinkAlcohol as $value) {
                                                    $selected = ($profile['drinkAlcohol'] == $value) ? 'selected' : '';
                                                    echo "<option value=\"$value\" $selected>$value</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Display 'smoking' dropdown -->
                                        <div class="col-lg-4 mb-3">
                                            <label for="smoking" class="form-label text-muted">Do you smoke?</label>
                                            <select id="smoking" name="smoking" class="form-select" required>
                                                <?php
                                                // Loop through the ENUM values for 'smoking' and create an <option> for each
                                                foreach ($enumValuesSmoking as $value) {
                                                    $selected = ($profile['smoking'] == $value) ? 'selected' : '';
                                                    echo "<option value=\"$value\" $selected>$value</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Submit -->
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

        <div class="row ">
            <div class="col-12">
                <br>
                <h4 class="headCustom ">Your Educational Detail</h4>
                <hr>
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <p class="text-muted fs-14"> </p>
                        <div class="row">
                            <div>
                                <?php displaySessionMessage(); ?>
                                <form id="educationalInformationForm" name="educationalInformationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation">
                                    <div class="row">

                                        <!-- qualification -->
                                        <div class="col-lg-6 mb-3">
                                            <label for="qualification" class="form-label text-muted">Qualification:</label>
                                            <select id="qualification" name="qualification_id" class="form-select" required>
                                                <option value="">Select qualification</option>
                                                <?php foreach ($qualifications as $qualification): ?>
                                                    <option value="<?php echo $qualification['id']; ?>"
                                                        <?php echo $profile['qualification_id'] == $qualification['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $qualification['qualification_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Last University Name -->
                                        <div class="col-lg-6 mb-3">
                                            <label for="last_university_name" class="form-label text-muted">Last University Name:</label>
                                            <input type="text" id="last_university_name" name="last_university_name" class="form-control"
                                                value="<?php echo $profile['last_university_name']; ?>" required>
                                        </div>
                                        <!-- Submit -->
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" name="btnUpdateEduInfo" id="btnUpdateEduInfo" class="btn btn-primary">Save Educational Information</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12">
                <br>
                <h4 class="headCustom ">Your Employment and Financial Info</h4>
                <hr>
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <p class="text-muted fs-14"> </p>
                        <div class="row">
                            <div>
                                <?php displaySessionMessage(); ?>
                                <form id="employmentInfo" name="employmentInfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation">
                                    <div class="row">
                                        <!-- Is Employed -->
                                        <div class="col-lg-6 mb-3">
                                            <label for="is_employed" class="form-label text-muted">Is Employed:</label>
                                            <select id="is_employed" name="is_employed" class="form-select" onchange="toggleEmploymentFields()" required>
                                                <option value="">Select</option>
                                                <option value="1" <?php echo (strval($profile['is_employed']) === '1') ? 'selected' : ''; ?>>Yes</option>
                                                <option value="0" <?php echo (strval($profile['is_employed']) === '0') ? 'selected' : ''; ?>>No</option>
                                            </select>
                                        </div>


                                        <!-- Employment Type -->
                                        <div class="col-lg-6 mb-3 employment-type-field">
                                            <label for="employment_type" class="form-label text-muted">Employment Type:</label>
                                            <select id="employment_type" name="employment_type" class="form-select" onchange="toggleEmploymentTypeFields()">
                                                <option value="">Select</option>
                                                <option value="Government" <?php echo $profile['employment_type'] === 'Government' ? 'selected' : ''; ?>>Government</option>
                                                <option value="Private" <?php echo $profile['employment_type'] === 'Private' ? 'selected' : ''; ?>>Private</option>
                                                <option value="Self-Business" <?php echo $profile['employment_type'] === 'Self-Business' ? 'selected' : ''; ?>>Self-Business</option>
                                                <option value="Landlord" <?php echo $profile['employment_type'] === 'Landlord' ? 'selected' : ''; ?>>Landlord</option>
                                            </select>
                                        </div>

                                        <!-- Employment Address / Work Address -->
                                        <div class="col-lg-6 mb-3 address-field">
                                            <label for="employment_address" class="form-label text-muted">Work Address:</label>
                                            <input type="text" id="employment_address" name="employment_address" class="form-control" value="<?php echo $profile['employment_address']; ?>">
                                        </div>

                                        <!-- Designation -->
                                        <div class="col-lg-6 mb-3 gov-private-field">
                                            <label for="designation" class="form-label text-muted">Designation:</label>
                                            <input type="text" id="designation" name="designation" class="form-control" value="<?php echo $profile['designation']; ?>">
                                        </div>

                                        <!-- Company Name -->
                                        <div class="col-lg-6 mb-3 gov-private-field">
                                            <label for="company_name" class="form-label text-muted">Company Name:</label>
                                            <input type="text" id="company_name" name="company_name" class="form-control" value="<?php echo $profile['company_name']; ?>">
                                        </div>

                                        <!-- Salary -->
                                        <div class="col-lg-6 mb-3 gov-private-field">
                                            <label for="salary" class="form-label text-muted">Salary:</label>
                                            <input type="number" id="salary" name="salary" class="form-control" value="<?php echo $profile['salary']; ?>">
                                        </div>

                                        <!-- Annual Income -->
                                        <div class="col-lg-6 mb-3 annual-income">
                                            <label for="annual_income" class="form-label text-muted">Annual Income:</label>
                                            <input type="number" id="annual_income" name="annual_income" class="form-control" value="<?php echo $profile['annual_income']; ?>">
                                        </div>

                                        <!-- Submit -->
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" name="btnUpdateEmploymentInfo" id="btnUpdateEmploymentInfo" class="btn btn-primary">Save Employment Information</button>
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


    <?php include 'userlayout/footer.php'; ?>

    <!-- Add Bootstrap JavaScript bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggleEmploymentFields() {
            const isEmployed = document.getElementById("is_employed").value;
            const employmentTypeField = document.querySelector(".employment-type-field");
            const govPrivateFields = document.querySelectorAll(".gov-private-field");
            const addressField = document.querySelector(".address-field");
            const annualIncome = document.querySelector(".annual-income");

            // Show/hide employment type field based on is_employed value
            if (isEmployed === "1") {
                employmentTypeField.style.display = "block";
            } else {
                employmentTypeField.style.display = "none";
                govPrivateFields.forEach(field => field.style.display = "none");
                addressField.style.display = "none";
                annualIncome.style.display = "none";
            }
        }

        function toggleEmploymentTypeFields() {
            const employmentType = document.getElementById("employment_type").value;
            const govPrivateFields = document.querySelectorAll(".gov-private-field");
            const addressField = document.querySelector(".address-field");
            const annualIncome = document.querySelector(".annual-income");

            if (employmentType === "Government" || employmentType === "Private") {
                govPrivateFields.forEach(field => field.style.display = "block");
                addressField.style.display = "block";
                annualIncome.style.display = "block";
            } else if (employmentType === "Self-Business" || employmentType === "Landlord") {
                govPrivateFields.forEach(field => field.style.display = "none");
                addressField.style.display = "block";
                annualIncome.style.display = "block";
            } else {
                govPrivateFields.forEach(field => field.style.display = "none");
                addressField.style.display = "none";
                annualIncome.style.display = "none";
            }
        }

        // Initial toggle based on current value
        document.addEventListener("DOMContentLoaded", () => {
            toggleEmploymentFields();
            toggleEmploymentTypeFields();
        });
    </script>
</body>

</html>