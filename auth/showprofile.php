<?php
include 'layouts/session.php';
include 'layouts/config.php';
include 'layouts/main.php';
include 'layouts/functions.php';

// Initialize variables
$profile = [];

// Check if the user is logged in and a valid profile ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = (int)$_GET['id']; // Get the user ID from the URL

    $query =
        "SELECT 
            profiles.*,
            users.username, 
            users.email,
            countries.country_name AS profile_country_name, 
            cities.city_name AS profile_city_name, 
            states.state_name AS profile_state_name,
            user_cast.cast_name AS profile_caste,
            religion.religion_name,
            qualifications.qualification_name AS profile_qualification_name,
            requirements.preferred_age_from,
            requirements.preferred_age_to,
            requirements.preferred_marital_status,
            
            -- Preferred values from requirements table
            preferred_country.country_name AS preferred_country_name,
            preferred_state.state_name AS preferred_state_name,
            preferred_city.city_name AS preferred_city_name,
            preferred_qualification.qualification_name AS preferred_qualification_name,
            
            preferred_caste.cast_name AS preferred_caste_name,
            requirements.looking_for
        FROM 
            profiles
        JOIN users ON profiles.user_id = users.id
        LEFT JOIN countries ON profiles.country_id = countries.id
        LEFT JOIN cities ON profiles.city_id = cities.id
        LEFT JOIN states ON profiles.state_id = states.id
        LEFT JOIN religion ON profiles.religion_id = religion.id
        LEFT JOIN qualifications ON profiles.qualification_id = qualifications.id
        LEFT JOIN user_cast ON profiles.cast_id = user_cast.id
        LEFT JOIN requirements ON profiles.user_id = requirements.user_id
        -- Join the requirements table to get the preferred country, state, city, and qualification
        LEFT JOIN countries AS preferred_country ON requirements.preferred_country_id = preferred_country.id
        LEFT JOIN states AS preferred_state ON requirements.preferred_state_id = preferred_state.id
        LEFT JOIN cities AS preferred_city ON requirements.preferred_city_id = preferred_city.id
        LEFT JOIN user_cast AS preferred_caste ON requirements.preferred_cast_id = preferred_caste.id
        LEFT JOIN qualifications AS preferred_qualification ON requirements.preferred_education_level_id = preferred_qualification.id
        WHERE profiles.user_id = ?;
    ";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a profile was found
        if ($result && $result->num_rows > 0) {
            $profile = $result->fetch_assoc();
        } else {
            // No profile found
            $_SESSION['message'][] = ["type" => "error", "content" => "No Profile found for this user. "];
            header("Location: index.php");
            exit();
        }
        $stmt->close();
    } else {
        die("Error preparing the query: " . $conn->error);
    }
} else {
    // Redirect to login if the user is not logged in
    $_SESSION['message'][] = ["type" => "error", "content" => "An unexpected error occurred: " . $e->getMessage()];
    header("Location: login.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Show Profile Panel</title>
    <style>
        .customclr {
            color: #4CA8F0 !important;
        }

        .btn-pro {
            background-color: #E9E9E9;
        }

        .btn-pro:hover {
            background-color: #E9E9E9;

        }

        .custom-avatar {
            width: 350px;
            height: 400px;
        }

        @media screen and (max-width: 768px) {}
    </style>
</head>

<body class="bg-light">
    <?php include 'userlayout/header.php'; ?>

    <!-- Start Page Content here -->
    <div class="container">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- User Overview Card -->
                    <div class="row d-flex">
                        <div class="col-xl-4 col-lg-5 col-sm-5 flex-fill">
                            <div class="card text-center border-0">
                                <div class="card-body">
                                    <?php if (!empty($profile['profile_picture_1'])): ?>
                                        <img src="<?php echo htmlspecialchars($profile['profile_picture_1']); ?>"
                                            alt="Profile Picture"
                                            width="300px"
                                            height="300px"
                                            class="rounded-circle object-fit-cover">
                                    <?php else: ?>
                                        <p>No profile picture available.</p>
                                    <?php endif; ?>
                                    <h4 class="mt-3 mb-1"> <?php echo htmlspecialchars($profile['first_name'] ?? 'N/A') . ' ' . htmlspecialchars($profile['last_name'] ?? ''); ?></h4>
                                    <p class="text-muted">Qualification: <?php echo htmlspecialchars($profile['profile_qualification_name'] ?? 'N/A'); ?></p>
                                    <p class="text-muted">Gender: <?php echo htmlspecialchars($profile['gender'] ?? 'N/A'); ?></p>
                                    <p class="text-muted">Location: <?php echo htmlspecialchars(($profile['profile_city_name'] ?? 'Unknown') . ', ' . ($profile['profile_country_name'] ?? 'Unknown')); ?></p>
                                    <p class="text-muted">Age: <?php echo !empty($profile['date_of_birth']) ? (new DateTime())->diff(new DateTime($profile['date_of_birth']))->y . ' years' : 'N/A'; ?></p>
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div> <!-- end col-->

                        <!-- User Details and Requirements -->
                        <div class="col-xl-8 col-lg-7 col-sm-12 flex-fill">
                            <div class="card">
                                <div class="card-body">
                                    <h4>User Details</h4>
                                    <hr>
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted">Religion:</td>
                                                <td><?php echo htmlspecialchars($profile['religion_name'] ?? 'No Answer'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Marital Status:</td>
                                                <td><?php echo htmlspecialchars($profile['marital_status'] ?? 'No Answer'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Height:</td>
                                                <td><?php echo htmlspecialchars($profile['height'] ?? 'No Answer') . " cm"; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Weight:</td>
                                                <td><?php echo htmlspecialchars($profile['weight'] ?? 'No Answer') . " kg"; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h4 class="mt-4">What <?php echo htmlspecialchars($profile['first_name'] ?? 'User') . " " . htmlspecialchars($profile['last_name'] ?? ''); ?> is Looking For</h4>
                                    <hr>
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted">Looking For:</td>
                                                <td><?php echo htmlspecialchars($profile['looking_for'] ?? 'No Answer'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Preferred Age Range:</td>
                                                <td><?php echo htmlspecialchars(($profile['preferred_age_from'] ?? '') . '-' . ($profile['preferred_age_to'] ?? '')); ?> years</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Preferred Education Level:</td>
                                                <td><?php echo htmlspecialchars($profile['preferred_qualification_name'] ?? 'No Answer'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Preferred Location:</td>
                                                <td><?php echo htmlspecialchars(($profile['preferred_city_name'] ?? 'Any') . ', ' . ($profile['preferred_state_name'] ?? 'Any') . ', ' . ($profile['preferred_country_name'] ?? 'Any')); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Preferred Caste:</td>
                                                <td><?php echo htmlspecialchars($profile['preferred_caste_name'] ?? 'No Answer'); ?></td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="text-muted">Smoking Preference:</td>
                                                <td><?php // echo htmlspecialchars($profile['preferred_smoking'] ?? 'No Answer'); 
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Drinking Preference:</td>
                                                <td><?php // echo htmlspecialchars($profile['preferred_drinking'] ?? 'No Answer'); 
                                                    ?></td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <!-- New Row for More About Profile -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>More About <?php echo htmlspecialchars($profile['first_name'] ?? 'User') . " " . htmlspecialchars($profile['last_name'] ?? ''); ?></h4>
                                    <hr>
                                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($profile['bio'] ?? 'No bio available'); ?></p>
                                    <p><strong>Mother Tongue:</strong> <?php echo htmlspecialchars($profile['mother_tongue'] ?? 'No available'); ?></p>
                                    <p><strong>Caste:</strong> <?php echo htmlspecialchars($profile['profile_caste'] ?? 'No available'); ?></p>

                                    <h5>Education:</h5>
                                    <ul>
                                        <li><strong>Highest Qualification:</strong> <?php echo htmlspecialchars($profile['profile_qualification_name'] ?? 'N/A'); ?></li>
                                        <li><strong>Last University:</strong> <?php echo htmlspecialchars($profile['last_university_name'] ?? 'No information'); ?></li>
                                    </ul>

                                    <h5>My Looks & Habbits:</h5>
                                    <ul>
                                        <li><strong>My look: </strong><?php echo htmlspecialchars($profile['my_appearance'] ?? 'No interests listed'); ?></li>
                                        <li><strong>My Body Type: </strong><?php echo htmlspecialchars($profile['body_type'] ?? 'No interests listed'); ?></li>
                                        <li><strong>My Alcohol Routine: </strong><?php echo htmlspecialchars($profile['drinkAlcohol'] ?? 'No interests listed'); ?></li>
                                        <li><strong>My Smoking Routine: </strong><?php echo htmlspecialchars($profile['smoking'] ?? 'No interests listed'); ?></li>
                                    </ul>

                                    <h5>Occupation:</h5>
                                    <p><?php echo htmlspecialchars($profile['employment_type'] ?? 'Not specified'); ?> at <?php echo htmlspecialchars($profile['employment_address'] ?? ''); ?> and my annual turnover is <?php echo htmlspecialchars($profile['annual_income'] ?? ''); ?></p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end new row -->
                    <h5 class="customclr text-muted mt-5 text-start">Safety Tip - Always meet in a public place for your first date</h5>
                    <p class="text-muted mb-1 text-start">
                        If you choose to have a face-to-face meeting with another member, always meet in a public place with many
                        people around. Organize your own transportation to and from the date and never agree to be picked up at
                        your home. Always tell someone in your family or a friend where you are going and when you will return and
                        stay connected with your cell phone switched on at all times.
                    </p>
                    <button type="button" class="btn btn-pro">For more safety tips click here</button>

                </div>
            </div>
        </div>
    </div>

    <?php include 'userlayout/footer.php'; ?>

    <!-- Bootstrap js file include  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>