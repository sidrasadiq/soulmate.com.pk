<?php
include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/functions.php';


$user_id = $_SESSION['user_id'];

try {
    // Check if required profile fields are empty
    $profileCheckQuery = "SELECT profile_picture_1, marital_status, country_id, state_id, city_id, 
                                 religion_id, cast_id, is_house_rented, house_address, my_appearance
                          FROM profiles WHERE user_id = ?";
    $stmtProfileCheck = $conn->prepare($profileCheckQuery);
    $stmtProfileCheck->bind_param("i", $user_id);
    $stmtProfileCheck->execute();
    $result = $stmtProfileCheck->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Profile not found for this user.");
    }

    $profile = $result->fetch_assoc();

    // Check if any required field is empty
    $requiredFields = [
        $profile['profile_picture_1'],
        $profile['marital_status'],
        $profile['country_id'],
        $profile['state_id'],
        $profile['city_id'],
        $profile['religion_id'],
        $profile['cast_id'],
        $profile['is_house_rented'],
    ];

    $isIncomplete = false;
    foreach ($requiredFields as $field) {
        if (empty($field)) {
            $isIncomplete = true;
            break;
        }
    }

    // Redirect to index.php if profile is complete
    if (!$isIncomplete) {
        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
    header("Location: login.php");
    exit();
}

// Initialize arrays for countries and cities
$countries = [];
$cities = [];
$states = [];

try {
    // Start a transaction for data fetching
    $conn->begin_transaction();

    // Fetch countries
    $queryCountries = "SELECT id, country_name FROM countries ORDER BY id ASC;";
    $stmtCountries = $conn->prepare($queryCountries);
    $stmtCountries->execute();
    $resultCountries = $stmtCountries->get_result();
    while ($row = $resultCountries->fetch_assoc()) {
        $countries[] = $row;
    }

    // Fetch states
    $queryStates = "SELECT id, state_name FROM states  ORDER BY id ASC;";
    $stmtStates = $conn->prepare($queryStates);
    $stmtStates->execute();
    $resultStates  = $stmtStates->get_result();
    while ($row = $resultStates->fetch_assoc()) {
        $states[] = $row;
    }
    // Fetch cities
    $queryCities = "SELECT id, city_name FROM cities ORDER BY id ASC;";
    $stmtCities = $conn->prepare($queryCities);
    $stmtCities->execute();
    $resultCities = $stmtCities->get_result();
    while ($row = $resultCities->fetch_assoc()) {
        $cities[] = $row;
    }

    // Fetch Religion
    $queryReligion = "SELECT id, religion_name FROM religion ORDER BY id ASC;";
    $stmtReligion = $conn->prepare($queryReligion);
    $stmtReligion->execute();
    $resultReligion = $stmtReligion->get_result();
    while ($row = $resultReligion->fetch_assoc()) {
        $religion[] = $row;
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


    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
    header("location: complete-profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveProfileData"])) {
    try {
        // Start Transaction
        $conn->begin_transaction();

        // Get the user ID from the session
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User is not logged in.");
        }
        $user_id = $_SESSION['user_id'];

        // Define the upload directory for images
        $uploadDir = 'assets/images/uploads/';
        $profile_pic_1 = null;

        // Handle Image Upload
        // Define the base URL of the uploads directory
        $baseURL = 'assets/images/uploads/'; // Replace 'yourdomain.com' with your actual domain

        // Handle Image Upload
        if (isset($_FILES['profile_pic_1']) && $_FILES['profile_pic_1']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['profile_pic_1']['tmp_name'];
            $originalName = basename($_FILES['profile_pic_1']['name']);
            $imageExtension = pathinfo($originalName, PATHINFO_EXTENSION);

            // Validate file type (allow only images)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($imageExtension), $allowedExtensions)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
            }

            // Fetch the profile ID for the logged-in user
            $profileQuery = "SELECT id FROM profiles WHERE user_id = ?";
            $profileStmt = $conn->prepare($profileQuery);
            $profileStmt->bind_param("i", $user_id);
            $profileStmt->execute();
            $result = $profileStmt->get_result();

            if ($result->num_rows === 0) {
                throw new Exception("Profile not found for the logged-in user.");
            }
            $profile = $result->fetch_assoc();
            $profile_id = $profile['id']; // Get the profile ID

            // Generate a unique filename
            $uniqueNumber = uniqid();
            $newFileName = "profile_pic_1_{$user_id}_{$profile_id}_{$uniqueNumber}." . $imageExtension;

            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new Exception("Failed to create directory for image uploads.");
                }
            }

            // Move the uploaded file to the upload directory
            $destination = $uploadDir . $newFileName;
            if (!move_uploaded_file($tmpName, $destination)) {
                throw new Exception("Failed to upload the profile picture.");
            }

            // Save the full path (URL) to the database
            $profile_pic_1 = $baseURL . $newFileName;

            // Close the profile query statement
            $profileStmt->close();
        }

        // Sanitize and filter input data
        $maritalStatus = isset($_POST['maritalStatus']) ? htmlspecialchars($_POST['maritalStatus'], ENT_QUOTES, 'UTF-8') : null;
        $yourCountry = isset($_POST['yourCountry']) ? intval($_POST['yourCountry']) : 0;
        $yourState = isset($_POST['yourState']) ? intval($_POST['yourState']) : 0;
        $yourCity = isset($_POST['yourCity']) ? intval($_POST['yourCity']) : 0;
        $beliefs = isset($_POST['beliefs']) ? $_POST['beliefs'] : 16;
        $caste = isset($_POST['caste']) ? intval($_POST['caste']) : null;
        $houseStatus = isset($_POST['houseStatus']) ? intval($_POST['houseStatus']) : null;
        $houseAddress = isset($_POST['houseAddress']) ? htmlspecialchars($_POST['houseAddress'], ENT_QUOTES, 'UTF-8') : null;

        // Validate ENUM values against allowed options
        $validDrinkAlcohol = ['do drink', 'occasionally drink', 'do not drink', 'prefer not to say'];
        $drinkAlcohol = (isset($_POST['drinkAlcohol']) && in_array($_POST['drinkAlcohol'], $validDrinkAlcohol))
            ? $_POST['drinkAlcohol'] : 'prefer not to say';

        $validSmoking = ['do smoke', 'occasionally smoke', 'do not smoke', 'prefer not to say'];
        $smoking = (isset($_POST['smoking']) && in_array($_POST['smoking'], $validSmoking))
            ? $_POST['smoking'] : 'prefer not to say';

        $validChildren = ['yes', 'not sure', 'no', 'prefer not to say'];
        $children = (isset($_POST['children']) && in_array($_POST['children'], $validChildren))
            ? $_POST['children'] : 'prefer not to say';

        $validAppearance = ['below average', 'average', 'attractive', 'very attractive', 'prefer not to say'];
        $appearance = (isset($_POST['appearance']) && in_array($_POST['appearance'], $validAppearance))
            ? $_POST['appearance'] : 'prefer not to say';

        $validBodyType = ['petite', 'slim', 'average', 'few extra pounds', 'full figured', 'large and lovely', 'prefer not to say'];
        $bodyType = (isset($_POST['bodyType']) && in_array($_POST['bodyType'], $validBodyType))
            ? $_POST['bodyType'] : 'prefer not to say';

        // Soulmate requirements
        $prefered_age_from = isset($_POST['ageFrom']) ? intval($_POST['ageFrom']) : null;
        $prefered_age_to = isset($_POST['ageTo']) ? intval($_POST['ageTo']) : null;
        $preferred_Country = isset($_POST['preferredCountry']) ? intval($_POST['preferredCountry']) : 0;
        $preferred_State = isset($_POST['preferredState']) ? intval($_POST['preferredState']) : 0;
        $preferred_City = isset($_POST['preferredCity']) ? intval($_POST['preferredCity']) : 0;
        $preferredQualification = isset($_POST['preferredQualification']) ? intval($_POST['preferredQualification']) : null;
        $soulmateCaste = isset($_POST['soulmateCaste']) ? intval($_POST['soulmateCaste']) : null;
        $soulmateMaritalStatus = isset($_POST['soulmateMaritalStatus']) ? htmlspecialchars($_POST['soulmateMaritalStatus'], ENT_QUOTES, 'UTF-8') : 'prefer not to say';

        // Update Profile Data
        $updateProfileQuery = "UPDATE profiles SET 
            profile_picture_1 = ?, marital_status = ?, country_id = ?, state_id = ?, city_id = ?, 
            religion_id = ?, cast_id = ?, is_house_rented = ?, house_address = ?, 
            my_appearance = ?, body_type = ?, drinkAlcohol = ?, smoking = ?, children = ?, updated_at = NOW()
            WHERE user_id = ?";
        $updateProfileStmt = $conn->prepare($updateProfileQuery);
        $updateProfileStmt->bind_param(
            "ssiiiiiissssssi",
            $profile_pic_1,   // profile_picture_1 (string)
            $maritalStatus,   // marital_status (string)
            $yourCountry,     // country_id (integer)
            $yourState,       // state_id (integer)
            $yourCity,        // city_id (integer)
            $beliefs,         // religion_id (integer)
            $caste,           // cast_id (integer)
            $houseStatus,     // is_house_rented (integer)
            $houseAddress,    // house_address (string)
            $appearance,      // my_appearance (string)
            $bodyType,        // body_type (string)
            $drinkAlcohol,    // drink_alcohol (string)
            $smoking,         // smoking (string)
            $children,        // children (string)
            $user_id          // user_id (integer)
        );
        $updateProfileStmt->execute();


        if ($updateProfileStmt->affected_rows === 0) {
            throw new Exception("Profile update failed or no changes made.");
        }

        // Update Soulmate Requirements
        $updateRequirementsQuery = "UPDATE requirements SET 
            preferred_age_from = ?, preferred_age_to = ?, preferred_country_id = ?, 
            preferred_state_id = ?, preferred_city_id = ?, preferred_education_level_id = ?, 
            preferred_cast_id = ?, preferred_marital_status = ?, updated_at = NOW()
            WHERE user_id = ?";
        $updateRequirementsStmt = $conn->prepare($updateRequirementsQuery);
        $updateRequirementsStmt->bind_param(
            "iiiiiiisi",
            $prefered_age_from,
            $prefered_age_to,
            $preferred_Country,
            $preferred_State,
            $preferred_City,
            $preferredQualification,
            $soulmateCaste,
            $soulmateMaritalStatus,
            $user_id
        );
        $updateRequirementsStmt->execute();
        if ($updateRequirementsStmt->affected_rows === 0) {
            throw new Exception("Failed to update soulmate requirements.");
        }

        // Commit Transaction
        $conn->commit();
        // echo "Profile and soulmate requirements updated successfully.";

        $_SESSION['message'][] = array(
            "type" => "success",
            "content" => "Profile and soulmate requirements updated successfully."
        );
        // Redirect to index.php after success
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        // Rollback Transaction on Failure
        if (isset($destination) && file_exists($destination)) {
            unlink($destination); // Delete the uploaded file if transaction fails
        }
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        // Close statements and connection
        if (isset($updateProfileStmt)) $updateProfileStmt->close();
        if (isset($updateRequirementsStmt)) $updateRequirementsStmt->close();
        // $conn->close();
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Complete Profile - Soulamte</title>
    <style>
        /* not show all steps in one step */
        .step {
            display: none;
        }

        /* display individually by click */
        .step.active {
            display: block;
        }

        /* steps of all buttons  */
        .step-buttons {
            margin-top: 50px;
            margin-bottom: 100px;
            padding: 10px;

        }

        /* styling of input field field */
        .step-head {
            color: #E63A7A;
            font-size: 30px;
        }

        /* step digit styling  */
        .step-num {
            color: #E63A7A;
            font-size: 80px;
        }

        /* file upload styling contianer */
        .file-upload-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        /* file upload input */
        .file-upload-input {
            position: relative;
            display: inline-block;
            border: 2px dashed #4CAF50;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            background-color: #fff;
            cursor: pointer;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        /* hover of file upload */
        .file-upload-input:hover {
            border-color: #45a049;
            background-color: #f1f8f5;
        }

        .file-upload-input input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* filed upload icons  */
        .file-upload-icon {
            font-size: 50px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        /* test  */
        .file-upload-text {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .file-upload-subtext {
            font-size: 14px;
            color: #888;
        }

        /* Optional: Style for uploaded file name */
        .file-name {
            margin-top: 20px;
            font-size: 16px;
            font-weight: 500;
            color: #4CAF50;
        }

        /* step of button next  */
        .btn-nxt {
            background-color: #ff69b4;
            /* Pink color */
            color: white;
            /* White text */
            width: 140px;
            /* Larger width */
            border: none;
            /* Remove border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 18px;
            /* Increase font size */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            transition: background-color 0.3s ease;
            /* Smooth color transition */
        }

        /* button previous */
        .btn-pre {
            background-color: #3987cc;
            color: white;

            width: 100px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            /* Increase font size */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            transition: background-color 0.3s ease;
        }

        /* Hover effect */
        .btn-nxt:hover {
            background-color: #3987cc;
            color: white;
            /* Darker pink on hover */
        }

        /* progress bar */
        .progress {
            height: 10px;
            margin-bottom: 20px;
            color: red;

        }

        /* progressbar color */
        .prg {
            background: linear-gradient(135deg, #3987cc, #E63A7A);
            /* Custom red gradient */
        }

        /* resonsive for mobile screen */

        @media screen and (max-width: 768px) {

            /* forn conainer */
            .form-container {
                width: 100%;
            }

            /* button responsive */
            .step-buttons {
                padding: 10px;
                margin-right: 30px;
                /* padding: 0px; */

            }

            /* next button */
            .btn-nxt {
                margin-right: 10px;
                width: 100px;
            }

            /* previous button */
            .btn-pre {
                margin-right: 40px;
            }
        }

        .ajax-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Transparent background */
            z-index: 9999;
            /* Ensure it stays on top */
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            /* Initially hidden */
            opacity: 0;
            transition: visibility 0.3s, opacity 0.3s;
        }

        .ajax-loader.show {
            visibility: visible;
            /* Show the loader */
            opacity: 1;
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

<body>
    <!-- logo -->
    <div class="m-2">
        <img src="assets/images/logo.png">
    </div>
    <!-- main contianer start -->
    <div class="container mt-5">
        <?php displaySessionMessage(); ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="complete-profile" enctype="multipart/form-data">

            <!-- Step 1:  Add Photo -->
            <div class="step active position-relative" id="step1">
                <h1 class="mt-5 text-center step-num st-1">1</h1>
                <h5 class="text-center  step-head">Add Your Best Photo</h5>
                <div class="file-upload-wrapper">

                    <div class="file-upload-input mt-5">
                        <div class="file-upload-icon">📁</div>
                        <div class="file-upload-text">Drag and drop or click to upload</div>
                        <div class="file-upload-subtext">Supports JPEG, PNG, JPG</div>
                        <input type="file" id="fileInput" name="profile_pic_1" accept=".jpeg, .png, jpg" required>
                    </div>

                    <div id="fileName" class="file-name"></div>
                </div>
                <p class="text-center mt-5">How to choose the right photo from the gallery</p>
                <div class="row justify-content-center">

                    <div class="col-md-4">
                        <ul>
                            <li>Recent photo of just you</li>
                            <li>Clearly shows your face</li>
                            <li>Good quality, Bright and clear</li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <ul>
                            <li>No celebrity/ fake uploads</li>
                            <li>No nudity, children, pets, hidden faces</li>
                            <li>No texts/ memes/ ads</li>
                        </ul>
                    </div>
                </div>

                <div class="step-buttons position-absolute translate-middle-x start-50">
                    <button type="button" class="btn btn-lg btn-nxt" id="nextToStep2">Next <i class="bi bi-arrow-right"></i> </button>
                </div>

            </div>

            <!-- Step 2: RelationShip -->
            <div class="step" id="step2">
                <h1 class="mt-5 text-center step-num st-1">2</h1>
                <h3 class="text-center">What is your marital status?</h3>
                <p class="text-center">Your marital status helps refine your profile and match preferences. You can</p>
                <p class="text-center">update this information at any time.</p>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- Marital Status Options -->
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="unmarried" value="single">
                                        <label class="form-check-label" for="single">Unmarried</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="married" value="married">
                                        <label class="form-check-label" for="married">Married</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="widow" value="widowed">
                                        <label class="form-check-label" for="widowed">Widow/Widower</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="divorced" value="divorced">
                                        <label class="form-check-label" for="divorced">Divorced</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="saperated" value="separated">
                                        <label class="form-check-label" for="separated">Saperated</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="other" value="other">
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="maritalStatus" type="radio" id="other" value="'prefer not to say">
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep1">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep3">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Nationality  -->
            <div class="step" id="step3">
                <h1 class="mt-5 text-center step-num st-1">3</h1>
                <h3 class="text-center">What is your nationality?</h3>
                <p class="text-center">Let us know your nationality to better understand your preferences.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-12 mb-sm-0">
                            <div class="card text-center border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!--  -->
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="country"></label>
                                                <select class="form-select" name="yourCountry" id="yourCountry" required>
                                                    <option selected>Select Country</option>
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?php echo $country['id']; ?>">
                                                            <?php echo $country['country_name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="state"></label>
                                                <select class="form-select" name="yourState" id="yourState" required>
                                                    <option selected>Select State</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="city"></label>
                                                <select class="form-select" name="yourCity" id="yourCity" required>
                                                    <option selected>Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep2">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep4">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 4: describes your beliefs-->
            <div class="step" id="step4">
                <h1 class="mt-5 text-center step-num st-1">4</h1>
                <h3 class="text-center">Which of the following best describes your beliefs?</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <?php if (!empty($religion)): ?>
                                        <?php foreach ($religion as $rel): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="beliefs" value="<?php echo htmlspecialchars($rel['id']); ?>" id="<?php echo htmlspecialchars($rel['id']); ?>">
                                                <label class="form-check-label" for="religion">
                                                    <?php echo htmlspecialchars($rel['religion_name']); ?>
                                                </label>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No religions found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep3">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep5">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 5: Your Caste -->
            <div class="step" id="step5">
                <h1 class="mt-5 text-center step-num st-1">5</h1>
                <h3 class="text-center">What is your caste?</h3>
                <p class="text-center">Let us know your caste to better understand your cultural background.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-6">
                            <div class="card text-center border-0">
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- Caste Dropdown -->
                                    <div class="form-group mb-3">
                                        <label for="caste" class="text-start d-block">Select your caste:</label>
                                        <select class="form-select" name="caste" id="caste" required>
                                            <option selected>Select Caste</option>
                                            <?php foreach ($user_cast as $cast): ?>
                                                <option value="<?php echo $cast['id']; ?>">
                                                    <?php echo $cast['cast_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep4">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep6">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 6: Houseing situation -->
            <div class="step" id="step6">
                <h1 class="mt-5 text-center step-num st-1">6</h1>
                <h3 class="text-center">What is your housing situation?</h3>
                <p class="text-center">Please let us know whether your house is rented or owned, and provide your address.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-6">
                            <div class="card text-center border-0">
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- House Ownership Question -->
                                    <div class="form-group row mb-3 text-start">
                                        <label for="houseStatus" class="d-block">Is your house rented or owned?</label>
                                        <div class="mb-3 col-6 col-md-6">
                                            <input class="form-check-input me-2" type="radio" name="houseStatus" id="owned" value="owned" required>
                                            <label class="form-check-label" for="owned">Owned</label>
                                        </div>
                                        <div class="mb-3 col-6 col-md-6">
                                            <input class="form-check-input me-2" type="radio" name="houseStatus" id="rented" value="rented" required>
                                            <label class="form-check-label" for="rented">Rented</label>
                                        </div>
                                    </div>

                                    <!-- House Address Field -->
                                    <div class="form-group mb-3 text-start">
                                        <label for="houseAddress" class="d-block">House Address:</label>
                                        <textarea class="form-control" id="houseAddress" name="houseAddress" rows="3" placeholder="Enter your house address" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep5">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep7">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 7: Alcohol Drinking of Soulmate -->
            <div class="step" id="step7">
                <h1 class="mt-5 text-center step-num st-1">7</h1>
                <h3 class="text-center">How often do you drink alcohol?</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="drinkAlcohol" value="do drink" id="do drink">
                                        <label class="form-check-label" for="do drink">
                                            Do drink </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="drinkAlcohol" value="occasionally drink" id="occasionally drink">
                                        <label class="form-check-label" for="occasionally drink">
                                            Occasionally drink </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="drinkAlcohol" value="do not drink" id="do not drink">
                                        <label class="form-check-label" for="do not drink">
                                            Don't drink</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="drinkAlcohol" value="prefer not to say" id="prefer not to say">
                                        <label class="form-check-label" for="prefer not to say">
                                            Prefre not to say </label>
                                    </div>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep6">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep8">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>


            <!-- Step 8: Smoking -->
            <div class="step" id="step8">
                <h1 class="mt-5 text-center step-num st-1">8</h1>
                <h3 class="text-center">Do you smoke?</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smoking" value="do smoke" id="do smoke">
                                        <label class="form-check-label" for="do smoke">
                                            Do smoke </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smoking" value="occasionally smoke" id="occasionally smoke">
                                        <label class="form-check-label" for="occasionally smoke">
                                            Occasionally smoke</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smoking" value="do not smoke" id="do not smoke">
                                        <label class="form-check-label" for="do not smoke">
                                            Don't smoke</label>
                                    </div>
                                    <hr>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smoking" value="prefer not to say" id="prefer not to say">
                                        <label class="form-check-label" for="prefer not to say">
                                            Prefre not to say </label>
                                    </div>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep7">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep9">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 9: childeren -->
            <div class="step" id="step9">
                <h1 class="mt-5 text-center step-num st-1">9</h1>
                <h3 class="text-center  ">Do you want (more) children?</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!--  -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="children" value="yes" id="yes">
                                        <label class="form-check-label" for="yes">
                                            Yes </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="children" value="not sure" id="not sure">
                                        <label class="form-check-label" for="not sure">
                                            Not Sure</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="children" value="no" id="no">
                                        <label class="form-check-label" for="no">
                                            No</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="children" value="prefer not to say" id="prefer not to say">
                                        <label class="form-check-label" for="prefer not to say">
                                            No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep8">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep10">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 10: appearance  -->
            <div class="step" id="step10">
                <h1 class="mt-5 text-center step-num st-1">10</h1>
                <h3 class="text-center">Continue the statement. I consider my appearance as:</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!--  -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appearance" value="below average" id="below average">
                                        <label class="form-check-label" for="below average">
                                            Below average </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appearance" value="average" id="average">
                                        <label class="form-check-label" for="average">
                                            Average</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appearance" value="attractive" id="attractive">
                                        <label class="form-check-label" for="attractive">
                                            Attractive</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="appearance" value="very attractive" id="very attractive">
                                        <label class="form-check-label" for="very attractive">
                                            Very attractive</label>
                                    </div>
                                    <hr>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep9">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep11">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 11: body type -->
            <div class="step" id="step11">
                <h1 class="mt-5 text-center step-num st-1">11</h1>
                <h3 class="text-center">How would you describe your body type?</h3>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card  border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!--  -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" value="petite" id="petite">
                                        <label class="form-check-label" for="petite">
                                            Petite </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" id="slim" value="slim">
                                        <label class="form-check-label" for="slim">
                                            Slim</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" id="average" value="average">
                                        <label class="form-check-label" for="average">
                                            Average</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" id="few extra pounds" value="few extra pounds">
                                        <label class="form-check-label" for="few extra pounds">
                                            Few Extra Pounds </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" id="full figured" value="full figured">
                                        <label class="form-check-label" for="full figured">
                                            Full Figured </label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bodyType" id="large and lovely" value="large and lovely">
                                        <label class="form-check-label" for="large and lovely">
                                            Large and Lovely</label>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep10">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep12">Next <i class="bi bi-arrow-right"></i></button>
                    </div>

                </div>
            </div>

            <!-- Partner Requirements -->
            <!-- Step 12: Age Group -->
            <div class="step mt-5" id="step12">
                <h1 class="mt-5 text-center step-num st-1">12</h1>
                <h3 class="text-center">What age group best fits your soulmate preferences?</h3>
                <p class="text-center">Refine your search to find individuals who are within the age range that</p>
                <p class="text-center">you find most compatible.</p>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card text-center border-0">
                                <div class="card-body card-body-st2 mb-5">

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="ageFrom" class="text-start d-block">From:</label>
                                                <select class="form-select" name="ageFrom" id="ageFrom" required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="ageTo" class="text-start d-block">To:</label>
                                                <select class="form-select" name="ageTo" id="ageTo" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep11">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep13">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 13: Partner Location  -->
            <div class="step" id="step13">
                <h1 class="mt-5 text-center step-num st-1">13</h1>
                <h3 class="text-center  ">What is the preferred location for finding your partner?</h3>
                <p class="text-center ">Are you seeking someone nearby for convenience or open to exploring
                </p>
                <p class="text-center ">connections across borders?</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-12 mb-sm-0">
                            <div class="card text-center border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!--  -->
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="country"></label>
                                                <select class="form-select" name="preferredCountry" id="preferredCountry" required>
                                                    <option selected>Select Country</option>
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?php echo $country['id']; ?>">
                                                            <?php echo $country['country_name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="state"></label>
                                                <select class="form-select" name="preferredState" id="preferredState" required>
                                                    <option selected>Select State</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label for="city"></label>
                                                <select class="form-select" name="preferredCity" id="preferredCity" required>
                                                    <option selected>Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-4" id="prevToStep12">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep14">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 14: Minimum Qualifications of Soulamte -->
            <div class="step" id="step14">
                <h1 class="mt-5 text-center step-num st-1">14</h1>
                <h3 class="text-center">What should be the minimum qualification of your soulmate?</h3>
                <p class="text-center">Select the minimum educational qualification that you expect for your partner.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-6">
                            <div class="card text-center border-0">
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- Minimum Qualification Dropdown -->
                                    <div class="form-group mb-3">
                                        <label for="preferredQualification" class="text-start d-block">Select Qualification:</label>
                                        <select class="form-select" name="preferredQualification" id="preferredQualification" required>
                                            <option selected>Select Qualification</option>
                                            <?php foreach ($qualifications as $qualification): ?>
                                                <option value="<?php echo $qualification['id']; ?>">
                                                    <?php echo $qualification['qualification_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep13">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep15">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 15: Caste of Soulmate -->
            <div class="step" id="step15">
                <h1 class="mt-5 text-center step-num st-1">15</h1>
                <h3 class="text-center">What should be the caste of your soulmate?</h3>
                <p class="text-center">Let us know your preference regarding caste for your soulmate.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 col-md-6">
                            <div class="card text-center border-0">
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- Caste Options -->
                                    <div class="form-group">
                                        <label for="soulmateCaste" class="text-start d-block">Select Caste:</label>
                                        <select class="form-select" name="soulmateCaste" id="soulmateCaste" required>
                                            <option selected disabled>Select Caste</option>
                                            <?php foreach ($user_cast as $cast): ?>
                                                <option value="<?php echo $cast['id']; ?>">
                                                    <?php echo $cast['cast_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="0">Any Caste</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep14">Back</button>
                        <button type="button" class="btn btn-lg btn-nxt" id="nextToStep16">Next <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 16: Matrital stutus of soulmate -->
            <div class="step" id="step16">
                <h1 class="mt-5 text-center step-num st-1">16</h1>
                <h3 class="text-center">What should be the marital status of your soulmate?</h3>
                <p class="text-center">Please choose the marital status you prefer for your soulmate.</p>

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 mb-3 mb-sm-0">
                            <div class="card border-0"> <!-- Added border-0 class -->
                                <div class="card-body card-body-st2 mb-5">
                                    <!-- Marital Status Options -->
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="unmarried" value="single">
                                        <label class="form-check-label" for="single">Unmarried</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="married" value="married">
                                        <label class="form-check-label" for="married">Married</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="widow" value="widowed">
                                        <label class="form-check-label" for="widowed">Widow/Widower</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="divorced" value="divorced">
                                        <label class="form-check-label" for="divorced">Divorced</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="saperated" value="separated">
                                        <label class="form-check-label" for="separated">Saperated</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="other" value="other">
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>
                                    <hr>
                                    <div class="form-check">
                                        <input class="form-check-input" name="soulmateMaritalStatus" type="radio" id="other" value="'prefer not to say">
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-buttons position-absolute translate-middle-x start-50">
                        <button type="button" class="btn btn-secondary btn-lg btn-pre me-3" id="prevToStep15">Back</button>
                        <button type="submit" class="btn btn-lg btn-nxt" name="saveProfileData" id="saveProfileData" value="saveProfileData">Submit</button>

                        <!-- <button type="button" class="btn btn-lg btn-nxt" id="nextToStep17">Next <i class="bi bi-arrow-right"></i></button> -->
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="progress">
        <div id="progressBar" class="progress-bar progress-bar-striped prg" role="progressbar" style="width: 10%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div id="ajaxLoader" class="ajax-loader">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show loader before AJAX call
            $(document).ajaxStart(function() {
                $('#ajaxLoader').addClass('show');
            });

            // Hide loader after AJAX call completes
            $(document).ajaxStop(function() {
                $('#ajaxLoader').removeClass('show');
            });
        });
    </script>
    <script>
        // Multi-step form logic
        let currentStep = 1; // Track the current step
        const totalSteps = 16; // Total number of steps

        function updateProgressBar() {
            const progressBar = document.getElementById('progressBar');
            const percentage = (currentStep / totalSteps) * 100; // Calculate percentage based on total steps
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
        }

        // Function to validate the current step and show error message if needed
        function validateStep(stepNumber) {
            let isValid = true; // Flag to indicate if the step is valid

            // Implement validation logic for each step
            switch (stepNumber) {
                case 1: // Step 1: Photo upload
                    if (!document.getElementById('fileInput').value) {
                        alert('Please upload a photo.');
                        isValid = false;
                    }
                    break;
                case 2:
                    const maritalStatusRadios = Array.from(document.querySelectorAll('input[name="maritalStatus"]'));
                    if (!maritalStatusRadios.some(radio => radio.checked)) {
                        alert('Please select your marital status.');
                        isValid = false;
                    }
                    break;
                case 3: // Step 3: Nationality
                    if (document.getElementById('yourCountry').value === 'Select yourCountry') {
                        alert('Please select your yourCountry.');
                        isValid = false;
                    }
                    break;
                case 4:
                    const beliefsRadios = Array.from(document.querySelectorAll('input[name="beliefs"]'));
                    if (!beliefsRadios.some(radio => radio.checked)) {
                        alert('Please select your religion or belief.');
                        isValid = false;
                    }
                    break;
                case 5: // Step 3: Nationality
                    if (document.getElementById('caste').value === 'Select Caste') {
                        alert('Please select your caste.');
                        isValid = false;
                    }

                    break;
                case 6:
                    const houseAddress = document.getElementById('houseAddress');
                    const houseStatus = Array.from(document.querySelectorAll('input[name="houseStatus"]'));

                    if (!houseStatus.some(radio => radio.checked)) {
                        alert('Please select your house status.');
                        isValid = false;
                    }

                    if (!houseAddress) {
                        alert('House address element not found.');
                        isValid = false;
                    } else if (!houseAddress.value) {
                        alert('Please enter your house address.');
                        houseAddress.focus();
                        isValid = false;
                    }
                    break;
                case 7:
                    const drinkAlcohol = Array.from(document.querySelectorAll('input[name="drinkAlcohol"]'));
                    if (!drinkAlcohol.some(radio => radio.checked)) {
                        alert('Please answer the given question.');
                        isValid = false;
                    }
                    break;
                case 8:
                    const smoking = Array.from(document.querySelectorAll('input[name="smoking"]'));
                    if (!smoking.some(radio => radio.checked)) {
                        alert('Please answer the given question.');
                        isValid = false;
                    }
                    break;
                case 9:
                    const children = Array.from(document.querySelectorAll('input[name="children"]'));
                    if (!children.some(radio => radio.checked)) {
                        alert('Please answer the given question.');
                        isValid = false;
                    }
                    break;
                case 10:
                    const appearance = Array.from(document.querySelectorAll('input[name="appearance"]'));
                    if (!appearance.some(radio => radio.checked)) {
                        alert('Please answer the given question.');
                        isValid = false;
                    }
                    break;
                case 11:
                    const bodyType = Array.from(document.querySelectorAll('input[name="bodyType"]'));
                    if (!bodyType.some(radio => radio.checked)) {
                        alert('Please answer the given question.');
                        isValid = false;
                    }
                    break;
                case 12:
                    if (document.getElementById('ageFrom').value === 'Select ageFrom') {
                        alert('Please select your ageFrom.');
                        isValid = false;
                    }
                    if (document.getElementById('ageTo').value === 'Select ageTo') {
                        alert('Please select your ageTo.');
                        isValid = false;
                    }
                    break;
                case 13:
                    const countrySelect = document.getElementById('preferredCountry');
                    const stateSelect = document.getElementById('preferredState');
                    const citySelect = document.getElementById('preferredCity');

                    if (countrySelect && stateSelect && citySelect) {
                        if (countrySelect.selectedIndex === 0) {
                            alert('Please select the country of your soulmate.');
                            isValid = false;
                        } else if (stateSelect.selectedIndex === 0) {
                            alert('Please select the state of your soulmate.');
                            isValid = false;
                        } else if (citySelect.selectedIndex === 0) {
                            alert('Please select the city of your soulmate.');
                            isValid = false;
                        }
                    } else {
                        alert('Error: Elements not found.');
                        isValid = false;
                    }
                    break;
                case 14:
                    if (document.getElementById('preferredQualification').value === 'Select Qualification') {
                        alert('Please select the qualification of your soulmate.');
                        isValid = false;
                    }
                    break;
                case 15:
                    if (document.getElementById('soulmateCaste').value === 'Select Caste') {
                        alert('Please select the soulmateCaste of your soulmate.');
                        isValid = false;
                    }
                    break;
                    // ... similar checks for other steps
                case 16: // Step 16: Soulmate Marital Status
                    const soulmateMaritalStatusRadios = document.querySelectorAll('input[name="soulmateMaritalStatus"]');
                    if (!soulmateMaritalStatusRadios.some(radio => radio.checked)) {
                        alert('Please select your desired soulmate\'s marital status.');
                        isValid = false;
                    }
                    break;
            }

            return isValid;
        }

        // Event listener for next buttons
        for (let step = 1; step < totalSteps; step++) {
            document.getElementById(`nextToStep${step + 1}`).addEventListener('click', function() {
                if (validateStep(step)) {
                    document.getElementById(`step${step}`).classList.remove('active');
                    document.getElementById(`step${step + 1}`).classList.add('active');
                    currentStep++;
                    updateProgressBar();
                }
            });
        }

        // Event listener for previous buttons
        for (let step = 2; step <= totalSteps; step++) {
            document.getElementById(`prevToStep${step - 1}`).addEventListener('click', function() {
                document.getElementById(`step${step}`).classList.remove('active');
                document.getElementById(`step${step - 1}`).classList.add('active');
                currentStep--;
                updateProgressBar();
            });
        }
    </script>
    <script>
        // Get the file input element
        const fileInput = document.getElementById('fileInput');
        const fileNameDiv = document.getElementById('fileName');

        // Listen for file selection
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the first file
            if (file) {
                fileNameDiv.textContent = file.name; // Display the file name
            } else {
                fileNameDiv.textContent = "No file chosen"; // Default text if no file is selected
            }
        });
    </script>

    <script>
        // Get the 'ageFrom' and 'ageTo' select elements
        const ageFromSelect = document.getElementById("ageFrom");
        const ageToSelect = document.getElementById("ageTo");

        // Function to populate the select elements with age options
        function populateAgeOptions(selectElement, startAge, endAge) {
            for (let age = startAge; age <= endAge; age++) {
                const option = document.createElement("option");
                option.value = age;
                option.textContent = age;
                selectElement.appendChild(option);
            }
        }

        // Populate both selects with ages 18 to 75
        populateAgeOptions(ageFromSelect, 18, 75);
        populateAgeOptions(ageToSelect, 18, 75);
    </script>

    <script>
        $(document).ready(function() {
            // When a country is selected
            $('#preferredCountry').on('change', function() {
                let countryId = $(this).val();

                if (countryId) {
                    setTimeout(() => {
                        $.ajax({
                            url: 'ajaxGetStates.php',
                            type: 'POST',
                            data: {
                                country_id: countryId
                            },
                            dataType: 'json',
                            success: function(states) {
                                let stateDropdown = $('#preferredState');
                                stateDropdown.empty();
                                stateDropdown.append('<option selected>Select State</option>');

                                $.each(states, function(key, state) {
                                    stateDropdown.append(
                                        '<option value="' + state.id + '">' + state.state_name + '</option>'
                                    );
                                });

                                $('#preferredCity').empty(); // Clear cities when country changes
                                $('#preferredCity').append('<option selected>Select City</option>');
                            },
                        });
                    }, 1000);
                } else {
                    $('#preferredState').empty();
                    $('#preferredState').append('<option selected>Select State</option>');

                    $('#preferredCity').empty();
                    $('#preferredCity').append('<option selected>Select City</option>');
                }
            });

            // When a state is selected
            $('#preferredState').on('change', function() {
                let stateId = $(this).val();

                if (stateId) {
                    setTimeout(() => {
                        $.ajax({
                            url: 'ajaxGetCities.php',
                            type: 'POST',
                            data: {
                                state_id: stateId
                            },
                            dataType: 'json',
                            success: function(cities) {
                                let cityDropdown = $('#preferredCity');
                                cityDropdown.empty();
                                cityDropdown.append('<option selected>Select City</option>');

                                $.each(cities, function(key, city) {
                                    cityDropdown.append(
                                        '<option value="' + city.id + '">' + city.city_name + '</option>'
                                    );
                                });
                            },
                        });
                    }, 1000);
                } else {
                    $('#preferredCity').empty();
                    $('#preferredCity').append('<option selected>Select City</option>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When a country is selected
            $('#yourCountry').on('change', function() {
                let countryId = $(this).val();

                if (countryId) {
                    setTimeout(() => {
                        $.ajax({
                            url: 'ajaxGetStates.php',
                            type: 'POST',
                            data: {
                                country_id: countryId
                            },
                            dataType: 'json',
                            success: function(states) {
                                let stateDropdown = $('#yourState');
                                stateDropdown.empty();
                                stateDropdown.append('<option selected>Select State</option>');

                                $.each(states, function(key, state) {
                                    stateDropdown.append(
                                        '<option value="' + state.id + '">' + state.state_name + '</option>'
                                    );
                                });

                                $('#yourCity').empty(); // Clear cities when country changes
                                $('#yourCity').append('<option selected>Select City</option>');
                            },
                        });
                    }, 1000);
                } else {
                    $('#yourState').empty();
                    $('#yourState').append('<option selected>Select State</option>');

                    $('#yourCity').empty();
                    $('#yourCity').append('<option selected>Select City</option>');
                }
            });

            // When a state is selected
            $('#yourState').on('change', function() {
                let stateId = $(this).val();

                if (stateId) {
                    setTimeout(() => {
                        $.ajax({
                            url: 'ajaxGetCities.php',
                            type: 'POST',
                            data: {
                                state_id: stateId
                            },
                            dataType: 'json',
                            success: function(cities) {
                                let cityDropdown = $('#yourCity');
                                cityDropdown.empty();
                                cityDropdown.append('<option selected>Select City</option>');

                                $.each(cities, function(key, city) {
                                    cityDropdown.append(
                                        '<option value="' + city.id + '">' + city.city_name + '</option>'
                                    );
                                });
                            },
                        });
                    }, 1000);
                } else {
                    $('#yourCity').empty();
                    $('#yourCity').append('<option selected>Select City</option>');
                }
            });
        });
    </script>

</body>

</html>