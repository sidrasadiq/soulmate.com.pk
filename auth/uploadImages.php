<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/main.php';
include 'layouts/functions.php';
include 'userlayout/header.php';

// User ID (replace with actual logic to retrieve the user ID from session)
$user_id = $_SESSION['user_id']; // Example user ID for testing

// Initialize session messages array
if (!isset($_SESSION['message'])) {
    $_SESSION['message'] = [];
}

// Define upload directory
$uploadDir = 'assets/images/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Retrieve profile ID based on user ID
$profile_id = null;
$stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_id);
    $stmt->fetch();
    $stmt->close();
}

if (!$profile_id) {
    $_SESSION['message'][] = ["type" => "error", "content" => "Profile not found for user ID $user_id."];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_FILES as $fieldName => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $tmpName = $file['tmp_name'];
                $originalName = basename($file['name']);
                $imageExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                // Validate file type
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageExtension, $allowedExtensions)) {
                    $_SESSION['message'][] = ["type" => "error", "content" => "Invalid file type for $fieldName. Only JPG, JPEG, PNG, and GIF are allowed."];
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }

                // Generate unique filename
                $uniqueNumber = uniqid();
                $newFileName = "{$fieldName}_{$user_id}_{$profile_id}_{$uniqueNumber}.$imageExtension";
                $destination = $uploadDir . $newFileName;

                // Move uploaded file
                if (!move_uploaded_file($tmpName, $destination)) {
                    $_SESSION['message'][] = ["type" => "error", "content" => "Failed to upload $fieldName."];
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }

                // Save full path in the database
                $filePath = $destination; // Save full path
                $stmt = $conn->prepare("UPDATE profiles SET {$fieldName} = ? WHERE id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $filePath, $profile_id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $_SESSION['message'][] = ["type" => "error", "content" => "Database error for $fieldName."];
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }

                // Success message
                $_SESSION['message'][] = ["type" => "success", "content" => "File uploaded successfully: $newFileName"];
            } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                $_SESSION['message'][] = ["type" => "error", "content" => "An error occurred while uploading $fieldName."];
            }
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        $_SESSION['message'][] = ["type" => "error", "content" => "An unexpected error occurred: " . $e->getMessage()];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch existing images from the database
$profilePictures = [];
$stmt = $conn->prepare("SELECT profile_picture_1, profile_picture_2, profile_picture_3, profile_picture_4, profile_picture_5 FROM profiles WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $profilePictures = $result->fetch_assoc();
    }
    $stmt->close();
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
        <br>
        <h4 class="headCustom ">Your Profile Pictures</h4>
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

                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row g-4">
                                        <!-- Profile Picture 1 -->
                                        <div class="col-md-4 col-lg-3 text-center">
                                            <div class="mb-3">
                                                <img id="preview_1"
                                                    class="image-preview rounded-circle object-fit-cover"
                                                    src="<?php echo isset($profilePictures['profile_picture_1']) ?  $profilePictures['profile_picture_1'] : 'assets/images/300x300.svg'; ?>"
                                                    height="250"
                                                    width="250"
                                                    alt="Preview">
                                            </div>
                                            <div class="mb-2">
                                                <input class="form-control"
                                                    type="file"
                                                    name="profile_picture_1"
                                                    id="profile_picture_1"
                                                    onchange="previewImage(this, 1)">
                                            </div>
                                            <!-- <div>
                                                <span class="bg-warning p-1 rounded text-white">Under Review</span>
                                            </div> -->
                                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>

                                        </div>
                                        <!-- Profile Picture 2 -->
                                        <div class="col-md-4 col-lg-3 text-center">
                                            <div class="mb-3">
                                                <img id="preview_2"
                                                    class="image-preview rounded-circle object-fit-cover"
                                                    src="<?php echo isset($profilePictures['profile_picture_2']) ?  $profilePictures['profile_picture_2'] : 'assets/images/300x300.svg'; ?>"
                                                    height="250"
                                                    width="250"
                                                    alt="Preview">
                                            </div>
                                            <div class="mb-2">
                                                <input class="form-control"
                                                    type="file"
                                                    name="profile_picture_2"
                                                    id="profile_picture_2"
                                                    onchange="previewImage(this, 2)">
                                            </div>
                                            <!-- <div>
                                                <span class="bg-warning p-1 rounded text-white">Under Review</span>
                                            </div> -->
                                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>

                                        </div>

                                        <!-- Profile Picture 3 -->
                                        <div class="col-md-4 col-lg-3 text-center">
                                            <div class="mb-3">
                                                <img id="preview_3"
                                                    class="image-preview rounded-circle object-fit-cover"
                                                    src="<?php echo isset($profilePictures['profile_picture_3']) ?  $profilePictures['profile_picture_3'] : 'assets/images/300x300.svg'; ?>"
                                                    height="250"
                                                    width="250"
                                                    alt="Preview">
                                            </div>
                                            <div class="mb-2">
                                                <input class="form-control"
                                                    type="file"
                                                    name="profile_picture_3"
                                                    id="profile_picture_3"
                                                    onchange="previewImage(this, 3)">
                                            </div>
                                            <!-- <div>
                                                <span class="bg-warning p-1 rounded text-white">Under Review</span>
                                            </div> -->
                                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>

                                        </div>
                                        <!-- Profile Picture 4 -->
                                        <div class="col-md-4 col-lg-3 text-center">
                                            <div class="mb-3">
                                                <img id="preview_4"
                                                    class="image-preview rounded-circle object-fit-cover"
                                                    src="<?php echo isset($profilePictures['profile_picture_4']) ?  $profilePictures['profile_picture_4'] : 'assets/images/300x300.svg'; ?>"
                                                    height="250"
                                                    width="250"
                                                    alt="Preview">
                                            </div>
                                            <div class="mb-2">
                                                <input class="form-control"
                                                    type="file"
                                                    name="profile_picture_4"
                                                    id="profile_picture_4"
                                                    onchange="previewImage(this, 4)">
                                            </div>
                                            <!-- <div>
                                                <span class="bg-warning p-1 rounded text-white">Under Review</span>
                                            </div> -->
                                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>

                                        </div>

                                        <!-- Profile Picture 5 -->
                                        <div class="col-md-4 col-lg-3 text-center">
                                            <div class="mb-3">
                                                <img id="preview_5"
                                                    class="image-preview rounded-circle object-fit-cover"
                                                    src="<?php echo isset($profilePictures['profile_picture_5']) ?  $profilePictures['profile_picture_5'] : 'assets/images/300x300.svg'; ?>"
                                                    height="250"
                                                    width="250"
                                                    alt="Preview">
                                            </div>
                                            <div class="mb-2">
                                                <input class="form-control"
                                                    type="file"
                                                    name="profile_picture_5"
                                                    id="profile_picture_5"
                                                    onchange="previewImage(this, 5)">
                                            </div>
                                            <!-- <div>
                                                <span class="bg-warning p-1 rounded text-white">Under Review</span>
                                            </div> -->
                                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>

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
        function previewImage(input, index) {
            const preview = document.getElementById(`preview_${index}`);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = "none";
            }
        }
    </script>
</body>

</html>