<?php
include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/main.php';
include 'layouts/functions.php';

// Check if user is logged in by verifying session user_id
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit;
}

$userId = $_SESSION['user_id']; // Get the user ID from the session

// Initialize arrays for countries, cities, and states
$countries = [];
$cities = [];
$states = [];

try {
    // Start a transaction
    $conn->begin_transaction();

    // Fetch profile data and join necessary tables for countries, states, cities, and personality profile info
    $query = "
        SELECT
            p.first_name, p.last_name, p.gender, p.date_of_birth, p.bio, 
            p.profile_picture_1, p.profile_picture_2, p.profile_picture_3, 
            p.profile_picture_4, p.profile_picture_5, p.contact_number, 
            p.whatsapp_contact, p.cnic, p.country_id, p.state_id, p.city_id, 
            p.nationality_id, p.religion_id, p.marital_status, p.children, 
            p.height, p.weight, p.my_appearance, p.body_type, p.dietary_preferences, 
            p.drinkAlcohol, p.smoking, p.mother_tongue, p.living_arrangements, 
            p.qualification_id, p.last_university_name, p.is_employed, 
            p.employment_type, p.designation, p.salary, p.employment_address, 
            p.company_name, p.annual_income, 
            c.country_name, s.state_name, ci.city_name, 
            np.is_complete
        FROM profiles p
        LEFT JOIN countries c ON p.country_id = c.id
        LEFT JOIN states s ON p.state_id = s.id
        LEFT JOIN cities ci ON p.city_id = ci.id
        LEFT JOIN personality_profile np ON np.created_by = p.created_by
        WHERE p.user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId); // Bind the user ID to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc(); // Get the profile data

    if (!$profile) {
        throw new Exception("No profile found for the user.");
    }

    // Determine if profile pictures are complete
    $profilePicturesComplete = !empty($profile['profile_picture_1']) && !empty($profile['profile_picture_2']) && !empty($profile['profile_picture_3']) && !empty($profile['profile_picture_4']) && !empty($profile['profile_picture_5']);

    // Determine if basic personal information is complete
    $basicPersonalInfoComplete = !(
        empty($profile['first_name']) ||
        empty($profile['last_name']) ||
        empty($profile['gender']) ||
        empty($profile['date_of_birth']) ||
        empty($profile['bio']) ||
        empty($profile['contact_number']) ||
        empty($profile['whatsapp_contact']) ||
        empty($profile['cnic']) ||
        empty($profile['country_id']) ||
        empty($profile['state_id']) ||
        empty($profile['city_id']) ||
        empty($profile['religion_id']) ||
        empty($profile['marital_status']) ||
        empty($profile['children']) ||
        empty($profile['height']) ||
        empty($profile['weight']) ||
        empty($profile['my_appearance']) ||
        empty($profile['body_type']) ||
        empty($profile['drinkAlcohol']) ||
        empty($profile['smoking']) ||
        empty($profile['mother_tongue'])
    );

    // Determine if educational profile is complete
    $educationalProfileComplete = !(empty($profile['qualification_id']) || empty($profile['last_university_name']));
    // Determine if employment profile is complete
    $employmentProfileComplete = true;

    // Check if the user is employed
    if ($profile['is_employed'] == '1') {
        // Check if employment_type is either Government or Private
        if ($profile['employment_type'] == 'Government' || $profile['employment_type'] == 'Private') {
            // These fields are required if employed and in Government/Private sector
            $employmentProfileComplete = !(
                empty($profile['employment_type']) ||
                empty($profile['designation']) ||
                empty($profile['company_name']) ||
                empty($profile['salary']) ||
                empty($profile['employment_address']) ||
                empty($profile['annual_income'])
            );
        }
        // Check if employment_type is Self-Business or Landlord
        else if ($profile['employment_type'] == 'Self-Business' || $profile['employment_type'] == 'Landlord') {
            // These fields are required for Self-Business and Landlord employment types
            $employmentProfileComplete = !(
                empty($profile['employment_address']) ||
                empty($profile['annual_income'])
            );
        }
    } else {
        // If not employed, only employment_address and annual_income should be checked
        $employmentProfileComplete = !(
            empty($profile['employment_address']) ||
            empty($profile['annual_income'])
        );
    }


    // Check if personality profile is complete
    $is_pp_complete = $profile['is_pp_complete'] ?? 0; // Default to 0 if no data

    // Fetch all countries, states, and cities in one go for dropdown
    $queryCountries = "SELECT id, country_name FROM countries ORDER BY country_name ASC";
    $queryStates = "SELECT id, state_name FROM states ORDER BY state_name ASC";
    $queryCities = "SELECT id, city_name FROM cities ORDER BY city_name ASC";

    // Fetch countries
    $stmtCountries = $conn->prepare($queryCountries);
    $stmtCountries->execute();
    $resultCountries = $stmtCountries->get_result();
    $countries = [];
    while ($row = $resultCountries->fetch_assoc()) {
        $countries[] = $row;
    }

    // Fetch states
    $stmtStates = $conn->prepare($queryStates);
    $stmtStates->execute();
    $resultStates = $stmtStates->get_result();
    $states = [];
    while ($row = $resultStates->fetch_assoc()) {
        $states[] = $row;
    }

    // Fetch cities
    $stmtCities = $conn->prepare($queryCities);
    $stmtCities->execute();
    $resultCities = $stmtCities->get_result();
    $cities = [];
    while ($row = $resultCities->fetch_assoc()) {
        $cities[] = $row;
    }

    // Commit the transaction
    $conn->commit();
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
    header("location: complete-profile.php");
    exit();
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>User Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cardby {
            height: 350px !important;
            /* Ensures uniform card height */
            padding: 20px;
            /* Light background for better contrast */
        }

        .card-body {
            flex-grow: 1;
            /* Allows the body to fill the remaining space */
            padding: 15px;
            text-align: start;
            /* Aligns text to the left */
        }

        .card-title {
            font-size: 1.35rem;
            font-weight: bold;
            color: #343a40;
        }

        .card-text {
            color: #6c757d;
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

<body class="bg-light ">
    <?php include 'userlayout/header.php'; ?>

    <div class="container-fluid p-xl-5 pt-xl-5 pt-5 pb-5 main">
        <div class="row">
            <?php displaySessionMessage(); ?>

            <!-- Profile Image -->
            <div class="col-md-3 p-md-1 mb-md-3">
                <a href="#" class="d-block text-decoration-none">
                    <?php
                    // Fetch profile image URL
                    $profileImage = rowInfoByColumn($conn, "profiles", "profile_picture_1", "user_id", $_SESSION["user_id"]);
                    $defaultImage = "assets/images/300x300.svg"; // Default image path
                    $imagePath = !empty($profileImage) ? $profileImage : $defaultImage;
                    ?>
                    <img src="<?php echo htmlspecialchars($imagePath); ?>"
                        alt="User Profile Picture"
                        width="132" height="132" class="rounded-circle">
                </a>
            </div>

            <!-- Profile Information -->
            <div class="col-md-4 prof-con mt-md-3 mt-sm-4">
                <h5 class="mt-4">
                    <?php
                    $firstName = rowInfoByColumn($conn, "profiles", "first_name", "user_id", $_SESSION["user_id"]);
                    $lastName = rowInfoByColumn($conn, "profiles", "last_name", "user_id", $_SESSION["user_id"]);
                    echo htmlspecialchars($firstName . " " . $lastName);
                    ?>
                </h5>

                <!-- Conditional Button Display -->
                <?php
                // Display the appropriate button or message based on profile completeness
                if (!$profilePicturesComplete) {
                    echo '<a href="uploadImages.php" class="btn btn-comp-prof"> Next Step: Upload Your Profile Pictures</a>';
                } elseif (!$basicPersonalInfoComplete) {
                    echo '<a href="editProfile.php" class="btn btn-comp-prof"> Next Step: Complete Your Basic Personal Profile</a>';
                } elseif (!$educationalProfileComplete) {
                    echo '<a href="editProfile.php" class="btn btn-comp-prof"> Next Step: Complete Your Educational Profile</a>';
                } elseif (!$employmentProfileComplete) {
                    echo '<a href="editProfile.php" class="btn btn-comp-prof"> Next Step: Complete Your Employment Profile</a>';
                } elseif ($is_pp_complete === 0) {
                    echo '<a href="editPersonalityInfo.php?id=' . urlencode($userId) . '" class="btn btn-comp-prof"> Next Step: Complete Your Personality Profile</a>';
                } else {
                    echo '<a href="premiumMembership.php" class="btn btn-comp-prof"> Finally: Get Premium Membership</a>';
                }
                ?>

                <p class="mt-2">Learn about membership features</p>

                <!-- Emoji Section -->
                <div class="emoji">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <i class="bi bi-emoji-smile"></i>
                    <i class="bi bi-chat"></i>
                    <i class="bi bi-eye-slash"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-unlock"></i>
                </div>
            </div>

            <!-- Progress Circles -->
            <div class="col-md-5 d-flex justify-content-between align-items-center prog-con d-none d-sm-flex">
                <?php
                // Progress Circle Percentages
                $progressData = [75, 60, 85, 40];
                foreach ($progressData as $percentage):
                ?>
                    <div class="progress-circle" data-percentage="<?php echo $percentage; ?>">
                        <svg viewBox="0 0 36 36" class="circular-chart">
                            <path class="circle-bg"
                                d="M18 2.0845
                             a 15.9155 15.9155 0 1 0 0 31.831
                             a 15.9155 15.9155 0 1 0 0 -31.831" />
                            <path class="circle"
                                stroke-dasharray="<?php echo $percentage; ?>, 100"
                                d="M18 2.0845
                             a 15.9155 15.9155 0 1 0 0 31.831
                             a 15.9155 15.9155 0 1 0 0 -31.831" />
                        </svg>
                        <span class="percentage"><?php echo $percentage; ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php
    // Search Section Start
    ?>
    <?php

    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Fetch countries, states, and cities dynamically
    function fetchOptions($conn, $table, $columnId, $columnName)
    {
        $options = [];
        try {
            $query = "SELECT $columnId, $columnName FROM $table";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $options[] = ['id' => $row[$columnId], 'name' => $row[$columnName]];
            }
        } catch (Exception $e) {
            error_log("Error fetching options: " . $e->getMessage());
        }
        return $options;
    }

    // Fetch user preferences from the 'requirements' table
    function fetchUserPreferences($conn, $userId)
    {
        $preferences = [];
        try {
            $query = "SELECT * FROM requirements WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $preferences = $result->fetch_assoc();
            }
        } catch (Exception $e) {
            error_log("Error fetching user preferences: " . $e->getMessage());
        }
        return $preferences;
    }

    // Fetch data
    $countries = fetchOptions($conn, "countries", "id", "country_name");
    $states = fetchOptions($conn, "states", "id", "state_name");
    $cities = fetchOptions($conn, "cities", "id", "city_name");

    // Fetch user preferences
    $userPreferences = fetchUserPreferences($conn, $userId);
    ?>

    <!-- Search Form -->
    <div class="container-fluid">
        <form action="search-result.php" method="POST">
            <div class="card search-card border-0 shadow">
                <div class="card-body">
                    <div class="row gx-2 gy-1 align-items-center">
                        <!-- Seeking -->
                        <div class="col-md-2">
                            <label for="seeking" class="fw-bold">Seeking</label>
                            <select class="form-select custom-border" id="seeking" name="seeking">
                                <option value="male" <?php echo ($userPreferences['looking_for'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($userPreferences['looking_for'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                <option value="any" <?php echo ($userPreferences['looking_for'] == 'other') ? 'selected' : ''; ?>>Any</option>
                            </select>
                        </div>

                        <!-- Age From -->
                        <div class="col-md-1">
                            <label for="age_from" class="fw-bold">Age From</label>
                            <select class="form-select custom-border" id="age_from" name="age_from">
                                <option value="" selected></option>
                                <?php for ($i = 18; $i <= 75; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($userPreferences['preferred_age_from'] == $i) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Age To -->
                        <div class="col-md-1">
                            <label for="age_to" class="fw-bold">Age To</label>
                            <select class="form-select custom-border" id="age_to" name="age_to">
                                <option value="" selected></option>
                                <?php for ($i = 18; $i <= 75; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($userPreferences['preferred_age_to'] == $i) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Country -->
                        <div class="col-md-2">
                            <label for="country" class="fw-bold">Country</label>
                            <select class="form-select custom-border" id="country" name="country">
                                <option value="any">Any Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country['id']; ?>" <?php echo ($userPreferences['preferred_country_id'] == $country['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($country['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- State -->
                        <div class="col-md-2">
                            <label for="state" class="fw-bold">State</label>
                            <select class="form-select custom-border" id="state" name="state">
                                <option value="any">Any State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?php echo $state['id']; ?>" <?php echo ($userPreferences['preferred_state_id'] == $state['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($state['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- City -->
                        <div class="col-md-2">
                            <label for="city" class="fw-bold">City</label>
                            <select class="form-select custom-border" id="city" name="city">
                                <option value="any">Any City</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?php echo $city['id']; ?>" <?php echo ($userPreferences['preferred_city_id'] == $city['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($city['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="btnSearchProfile" value="btnSearchProfile" class="btn btn-search w-100 shadow">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    // Secure session user ID
    $userId = intval($_SESSION['user_id']);

    // Fetch the current user's gender
    $userQuery = "SELECT profiles.gender FROM profiles 
              JOIN users ON profiles.user_id = users.id 
              WHERE users.id = ?";
    $stmtUser = $conn->prepare($userQuery);
    $stmtUser->bind_param("i", $userId);
    $stmtUser->execute();
    $userResult = $stmtUser->get_result();
    $currentUserGender = $userResult->fetch_assoc()['gender'];
    $oppositeGender = ($currentUserGender === 'male') ? 'female' : 'male';

    // Fetch user requirements
    $requirementsQuery = "SELECT 
                        preferred_age_from, 
                        preferred_age_to, 
                        preferred_marital_status, 
                        preferred_education_level_id, 
                        preferred_country_id, 
                        preferred_state_id, 
                        preferred_city_id, 
                        preferred_cast_id 
                      FROM requirements WHERE user_id = ?";
    $stmtReq = $conn->prepare($requirementsQuery);
    $stmtReq->bind_param("i", $userId);
    $stmtReq->execute();
    $requirementsResult = $stmtReq->get_result();
    $requirements = $requirementsResult->fetch_assoc();

    // Main query to fetch profiles
    $query =
        "SELECT 
            profiles.*, 
            countries.country_name, 
            cities.city_name, 
            states.state_name, 
            users.username,
            users.email
        FROM profiles
        JOIN users ON profiles.user_id = users.id
        LEFT JOIN countries ON profiles.country_id = countries.id
        LEFT JOIN cities ON profiles.city_id = cities.id
        LEFT JOIN states ON profiles.state_id = states.id
        WHERE users.id != ?
        AND users.role_id = 2
        AND users.is_verified = 1
        AND profiles.is_profile_complete = 1
        AND profiles.gender = ?
        AND profiles.marital_status = ?
        AND profiles.date_of_birth BETWEEN DATE_SUB(CURDATE(), INTERVAL ? YEAR)
                                        AND DATE_SUB(CURDATE(), INTERVAL ? YEAR)
        AND (profiles.qualification_id = ? OR profiles.qualification_id IS NULL)
        AND profiles.country_id = ?
        AND profiles.state_id = ?
        AND profiles.city_id = ?
        AND profiles.cast_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "issiiiiiii",
        $userId,
        $oppositeGender,
        $requirements['preferred_marital_status'],
        $requirements['preferred_age_to'],   // Oldest age second
        $requirements['preferred_age_from'], // Youngest age first
        $requirements['preferred_education_level_id'],
        $requirements['preferred_country_id'],
        $requirements['preferred_state_id'],
        $requirements['preferred_city_id'],
        $requirements['preferred_cast_id']
    );


    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="container mt-4">
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $profileLink = 'showprofile.php?id=' . htmlspecialchars($row['id']);
                    $profilePicture = htmlspecialchars($row['profile_picture_1'] ?: 'placeholder.jpg');
                    $age = !empty($row['date_of_birth']) ? (new DateTime())->diff(new DateTime($row['date_of_birth']))->y : 'N/A';
                    ?>
                    <div class="col-md-3 mb-4">
                        <a href="<?= $profileLink ?>" target="_blank" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="<?= $profilePicture ?>" class="card-img-top" alt="Profile Picture" style="object-fit: cover; height: 300px; width: 100%;">
                                <div class="card-body">
                                    <h4 class="card-title"><?= htmlspecialchars($row['username']) ?></h4>
                                    <p class="card-text text-muted">
                                        <?= htmlspecialchars("{$age} years, {$row['city_name']}, {$row['state_name']}, {$row['country_name']}") ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">
                                            <?= htmlspecialchars($row['bio'] ?: 'No bio available.') ?>
                                        </small></p>
                                </div>
                                <div class="card-footer border-0 bg-transparent text-start">
                                    <div>
                                        <i class="bi bi-heart-fill p-2 text-muted fs-3"></i>
                                        <i class="bi bi-chat-fill p-2 text-muted fs-3"></i>
                                        <i class="bi bi-gift-fill p-2 text-muted fs-3"></i>
                                        <i class="bi bi-camera-fill p-2 text-muted fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No profiles found.</p>
            <?php endif; ?>
        </div>
    </div>


    <?php include 'userlayout/footer.php'; ?>

    <script>
        document.querySelectorAll('.progress-circle').forEach(el => {
            const percentage = el.getAttribute('data-percentage');
            const circle = el.querySelector('.circle');
            const radius = 15.9155;
            const circumference = 2 * Math.PI * radius;
            const offset = circumference - (percentage / 100) * circumference;

            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = offset;

            el.querySelector('.percentage').textContent = `${percentage}%`;
        });
    </script>

    <!-- Add Bootstrap JavaScript bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>