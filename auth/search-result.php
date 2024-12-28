<?php
include 'layouts/config.php';
include 'layouts/session.php';
include 'layouts/main.php';
include 'layouts/functions.php';
include 'userlayout/header.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btnSearchProfile'])) {
    // Sanitize and validate form inputs
    $seeking = isset($_POST['seeking']) && $_POST['seeking'] !== 'any' ? htmlspecialchars($_POST['seeking'], ENT_QUOTES, 'UTF-8') : null;
    $age_from = isset($_POST['age_from']) && !empty($_POST['age_from']) ? (int)$_POST['age_from'] : null;
    $age_to = isset($_POST['age_to']) && !empty($_POST['age_to']) ? (int)$_POST['age_to'] : null;
    $country = isset($_POST['country']) && $_POST['country'] !== 'any' ? (int)$_POST['country'] : null;
    $state = isset($_POST['state']) && $_POST['state'] !== 'any' ? (int)$_POST['state'] : null;
    $city = isset($_POST['city']) && $_POST['city'] !== 'any' ? (int)$_POST['city'] : null;
    $religion = isset($_POST['religion']) && $_POST['religion'] !== 'any' ? htmlspecialchars($_POST['religion'], ENT_QUOTES, 'UTF-8') : null;

    // Build the SQL query dynamically based on filters
    $sql =
        "SELECT 
            profiles.*, 
            countries.country_name, 
            states.state_name, 
            cities.city_name,
            users.username 
        FROM profiles
        JOIN users ON profiles.user_id = users.id
        LEFT JOIN countries ON profiles.country_id = countries.id
        LEFT JOIN states ON profiles.state_id = states.id
        LEFT JOIN cities ON profiles.city_id = cities.id
        WHERE users.id != ? 
        AND users.role_id = 2
        AND users.is_verified = 1
        AND profiles.is_profile_complete = 1";

    // Initialize parameters and types
    $params = [];
    $types = "i";

    // Always exclude the current user
    $params[] = $_SESSION['user_id'];

    // Add conditions dynamically based on filters
    if (!empty($seeking)) {
        $sql .= " AND profiles.gender = ?";
        $params[] = $seeking;
        $types .= "s";
    }
    if (!empty($age_from)) {
        $sql .= " AND profiles.date_of_birth <= DATE_SUB(CURDATE(), INTERVAL ? YEAR)";
        $params[] = $age_from;
        $types .= "i";
    }
    if (!empty($age_to)) {
        $sql .= " AND profiles.date_of_birth >= DATE_SUB(CURDATE(), INTERVAL ? YEAR)";
        $params[] = $age_to;
        $types .= "i";
    }
    if (!empty($country)) {
        $sql .= " AND profiles.country_id = ?";
        $params[] = $country;
        $types .= "i";
    }
    if (!empty($state)) {
        $sql .= " AND profiles.state_id = ?";
        $params[] = $state;
        $types .= "i";
    }
    if (!empty($city)) {
        $sql .= " AND profiles.city_id = ?";
        $params[] = $city;
        $types .= "i";
    }
    if (!empty($religion)) {
        $sql .= " AND profiles.religion_id = ?";
        $params[] = $religion;
        $types .= "s";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing query: " . $conn->error);
    }

    // Bind parameters dynamically
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $profiles = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
} else {
    // If the form is not submitted, redirect back to the index page
    header("Location: index.php");
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
        .card {
            height: 500px !important;
            /* Fixed height for uniformity */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Ensures proper spacing between elements */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Adds a subtle shadow for better visuals */
        }

        .card-img-top {
            height: 200px;
            /* Fixed height for the image */
            object-fit: cover;
            /* Ensures the image fits the designated space */
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

<body>

    <div class="container mt-4">
        <div class="row">
            <?php if (!empty($profiles) && count($profiles) > 0): ?>
                <?php foreach ($profiles as $profile): ?>
                    <?php
                    $profileLink = 'showprofile.php?id=' . htmlspecialchars($profile['user_id']);
                    $profilePicture = htmlspecialchars($profile['profile_picture_1'] ?: 'assets/images/300x300.svg');
                    $age = !empty($profile['date_of_birth']) ? (new DateTime())->diff(new DateTime($profile['date_of_birth']))->y : 'N/A';
                    ?>
                    <div class="col-md-3 mb-4">
                        <a href="<?= $profileLink ?>" target="_blank" class="text-decoration-none">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="asdfasdfads<?= htmlspecialchars($profile['profile_picture_1']); ?>" class="card-img-top" alt="Profile Picture" style="object-fit: cover; height: 300px; width: 100%;">
                                <div class="card-body">
                                    <h4 class="card-title"><?= htmlspecialchars($profile['username']) ?></h4>
                                    <p class="card-text text-muted">
                                        <?= htmlspecialchars("{$age} years, {$profile['city_name']}, {$profile['state_name']}, {$profile['country_name']}") ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">
                                            <?= htmlspecialchars($profile['bio'] ?: 'No bio available.') ?>
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
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No profiles found matching the selected criteria.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php include 'userlayout/footer.php'; ?>
    <!-- Add Bootstrap JavaScript bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>