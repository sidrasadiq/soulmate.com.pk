<?php
// Include required files
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/main.php';
include 'layouts/functions.php';

// Initialize $profile as an empty array
$profile = [];

// Check if user is logged in by verifying session user_id
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get the user ID from the session

    // Initialize arrays for countries, cities, and states
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

        // Fetch cities
        $queryCities = "SELECT id, city_name FROM cities ORDER BY id ASC;";
        $stmtCities = $conn->prepare($queryCities);
        $stmtCities->execute();
        $resultCities = $stmtCities->get_result();

        while ($row = $resultCities->fetch_assoc()) {
            $cities[] = $row;
        }

        // Fetch states
        $queryStates = "SELECT id, state_name FROM states ORDER BY id ASC;";
        $stmtStates = $conn->prepare($queryStates);
        $stmtStates->execute();
        $resultStates = $stmtStates->get_result();

        while ($row = $resultStates->fetch_assoc()) {
            $states[] = $row;
        }
        // Fetch the is_complete value from the database for the logged-in user
        $query = "SELECT is_complete FROM personality_profile WHERE created_by = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);  // Use $userId instead of $user_id
        $stmt->execute();
        $result = $stmt->get_result();

        $is_complete = 0; // Default value if no profile exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $is_complete = (int)$row['is_complete']; // Ensure proper integer type for comparison
        }

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
        header("location: complete-profile.php");
        exit();
    }
} else {
    echo "User is not logged in.";
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
            <div class="col-md-3 p-md-1 mb-md-3 ">
                <a href="#" class="d-block text-decoration-none ">
                    <img src="uploads/<?php echo rowInfoByColumn($conn, "profiles", "profile_picture", "user_id", $_SESSION["user_id"]); ?>" alt="User" width="132" height="132" class="rounded-circle ">
                </a>
            </div>
            <div class="col-md-4 prof-con mt-md-3 mt-sm-4">

                <h5 class="mt-4">
                    <?php echo rowInfoByColumn($conn, "profiles", "first_name", "user_id", $_SESSION["user_id"]) . " " . rowInfoByColumn($conn, "profiles", "last_name", "user_id", $_SESSION["user_id"]); ?>
                </h5>
                <!-- Conditional display of the button based on is_complete -->
                <?php if ($is_complete === 0): ?>
                    <a href="editPersonalityInfo.php?id=<?php echo urlencode($userId); ?>" class="btn btn-comp-prof ">Next Step: Complete your personality profile</a>
                <?php endif; ?>

                <p class="mt-2">Learn about membership features</p>
                <div class=" emoji">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <i class="bi bi-emoji-smile"></i>
                    <i class="bi bi-chat"></i>
                    <i class="bi bi-eye-slash"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-unlock"></i>

                </div>

            </div>
            <div class="col-md-5 d-flex justify-content-between align-items-center prog-con d-none d-sm-flex">
                <!-- Circular Progress Bars -->
                <div class="progress-circle" data-percentage="75">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                        <path class="circle" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                    </svg>
                    <span class="percentage">75%</span>
                </div>
                <div class="progress-circle" data-percentage="60">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                        <path class="circle" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                    </svg>
                    <span class="percentage">60%</span>
                </div>
                <div class="progress-circle" data-percentage="85">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                        <path class="circle" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                    </svg>
                    <span class="percentage">85%</span>
                </div>
                <div class="progress-circle" data-percentage="40">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                        <path class="circle" d="M18 2.0845a 15.9155 15.9155 0 1 0 0 31.831 a 15.9155 15.9155 0 1 0 0 -31.831" />
                    </svg>
                    <span class="percentage">40%</span>
                </div>
            </div>

        </div>

    </div>
    <?php
    // Search Section Start
    ?>
    <div class="container-fluid">
        <form action="search-result.php" method="POST">
            <div class="card search-card border-0 shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Seeking -->
                        <div class="col-md-2">
                            <label for="seeking" class="fw-bold">Seeking</label>
                            <select class="form-select custom-border" id="seeking" name="seeking">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="any" selected>Any</option>
                            </select>
                        </div>

                        <!-- Age -->
                        <div class="col-md-1">
                            <label for="age" class="fw-bold">Age</label>
                            <select class="form-select custom-border" id="age" name="age">
                                <option value="" selected></option>
                                <?php for ($i = 18; $i <= 70; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Country -->
                        <div class="col-md-2">
                            <label for="country" class="fw-bold">Country</label>
                            <select class="form-select custom-border" id="country" name="country">
                                <option value="any" selected>Any</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country['id']); ?>">
                                        <?php echo htmlspecialchars($country['country_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- State/Province -->
                        <div class="col-md-2">
                            <label for="state" class="fw-bold">State/Province</label>
                            <select class="form-select custom-border" id="state" name="state">
                                <option value="any" selected>Any</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?php echo htmlspecialchars($state['id']); ?>">
                                        <?php echo htmlspecialchars($state['state_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- City -->
                        <div class="col-md-2">
                            <label for="city" class="fw-bold">City</label>
                            <select class="form-select custom-border" id="city" name="city">
                                <option value="any" selected>Any</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?php echo htmlspecialchars($city['id']); ?>">
                                        <?php echo htmlspecialchars($city['city_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Within -->
                        <div class="col-md-2">
                            <label for="within" class="fw-bold">Within</label>
                            <input type="number" class="form-control custom-border" id="within" placeholder="- km" name="within">
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-1">
                            <button type="submit" name="submit" value="submit" class="btn btn-search w-100 shadow">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-4">
        <div class="row">
            <?php
            // Secure the user ID
            $userId = intval($_SESSION['user_id']); // Assuming user ID is stored in session

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
                WHERE users.id != $userId";

            $result = mysqli_query($conn, $query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $profileLink = 'showprofile.php?id=' . htmlspecialchars($row['id']);
                    echo '<div class="col-md-3 mb-4">';
                    echo '<a href="' . $profileLink . '" target="_blank" class="text-decoration-none">';

                    echo '<div class="card h-100 shadow-sm border-0">';

                    $profilePicture = htmlspecialchars($row['profile_picture'] ?: 'placeholder.jpg');
                    echo "<img src='uploads/{$profilePicture}' class='card-img-top' alt='Profile Picture' style='object-fit: cover; height: 300px; width: 100%;'>";

                    echo '<div class="card-body">';

                    echo "<h4 class='card-title'>" . htmlspecialchars($row['username']) . "</h4>";
                    echo '<p class="card-text text-muted">';
                    if (!empty($row['date_of_birth'])) {
                        $age = (new DateTime())->diff(new DateTime($row['date_of_birth']))->y;
                        echo htmlspecialchars("$age . {$row['city_name']}, {$row['state_name']}, {$row['country_name']}");
                    } else {
                        echo 'No data available';
                    }
                    echo '</p>';

                    echo "<h5 class='card-text'>" . htmlspecialchars($row['religion_name']) . "</h5>";
                    echo "<p class='card-text'><small class='text-muted'>Seeking: " .
                        htmlspecialchars("{$row['looking_for']} {$row['prefer_age_from']}-{$row['prefer_age_to']}") . "</small></p>";

                    echo "<p class='card-text'><strong><small class='text-muted'>{$row['bio']}</small></strong></p>";
                    echo '</div>';

                    echo '<div class="card-footer border-0 bg-transparent text-start">';
                    echo '<div>';
                    echo '<i class="bi bi-heart-fill p-2 text-muted fs-3"></i>';
                    echo '<i class="bi bi-chat-fill p-2 text-muted fs-3"></i>';
                    echo '<i class="bi bi-gift-fill p-2 text-muted fs-3"></i>';
                    echo '<i class="bi bi-camera-fill p-2 text-muted fs-3"></i>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>'; // End card
                    echo '</a>';
                    echo '</div>'; // End col-md-3
                }
            } else {
                echo '<p>No profiles found.</p>';
            }
            ?>
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