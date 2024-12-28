<?php
include 'layouts/config.php';
include 'layouts/session.php';
include 'layouts/main.php';
include 'layouts/functions.php';

// Check if user is logged in, if not redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Assuming the database connection is already established as $conn

// Initialize variables for form inputs
$favorite_movie = $favorite_book = $sort_of_music = $hobbies = $dress_sense = $sense_of_humor =
    $describe_personality = $like_to_travel = $partner_diff_culture = $spend_weekend = $perfect_match = "";
$is_complete = 0;

// Fetch existing profile data
$sql = "SELECT * FROM personality_profile WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    // Bind the parameter
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch the existing profile data
            $row = $result->fetch_assoc();

            // Assign data to form variables
            $favorite_movie = $row['favorite_movie'];
            $favorite_book = $row['favorite_book'];
            $sort_of_music = $row['sort_of_music'];
            $hobbies = $row['hobbies'];
            $dress_sense = $row['dress_sense'];
            $sense_of_humor = $row['sense_of_humor'];
            $describe_personality = $row['describe_personality'];
            $like_to_travel = $row['like_to_travel'];
            $partner_diff_culture = $row['partner_diff_culture'];
            $spend_weekend = $row['spend_weekend'];
            $perfect_match = $row['perfect_match'];
            $is_complete = $row['is_complete'];
        }
    } else {
        // Handle error with fetching data
        $_SESSION['message'][] = array("type" => "error", "content" => "Error fetching user profile.");
    }
    // Close the statement
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and validate form inputs
    $favorite_movie = isset($_POST['favorite_movie']) ? htmlspecialchars($_POST['favorite_movie'], ENT_QUOTES, 'UTF-8') : null;
    $favorite_book = isset($_POST['favorite_book']) ? htmlspecialchars($_POST['favorite_book'], ENT_QUOTES, 'UTF-8') : null;
    $sort_of_music = isset($_POST['sort_of_music']) ? htmlspecialchars($_POST['sort_of_music'], ENT_QUOTES, 'UTF-8') : null;
    $hobbies = isset($_POST['hobbies']) ? htmlspecialchars($_POST['hobbies'], ENT_QUOTES, 'UTF-8') : null;
    $dress_sense = isset($_POST['dress_sense']) ? htmlspecialchars($_POST['dress_sense'], ENT_QUOTES, 'UTF-8') : null;
    $sense_of_humor = isset($_POST['sense_of_humor']) ? htmlspecialchars($_POST['sense_of_humor'], ENT_QUOTES, 'UTF-8') : null;
    $describe_personality = isset($_POST['describe_personality']) ? htmlspecialchars($_POST['describe_personality'], ENT_QUOTES, 'UTF-8') : null;
    $like_to_travel = isset($_POST['like_to_travel']) ? htmlspecialchars($_POST['like_to_travel'], ENT_QUOTES, 'UTF-8') : null;
    $partner_diff_culture = isset($_POST['partner_diff_culture']) ? htmlspecialchars($_POST['partner_diff_culture'], ENT_QUOTES, 'UTF-8') : null;
    $spend_weekend = isset($_POST['spend_weekend']) ? htmlspecialchars($_POST['spend_weekend'], ENT_QUOTES, 'UTF-8') : null;
    $perfect_match = isset($_POST['perfect_match']) ? htmlspecialchars($_POST['perfect_match'], ENT_QUOTES, 'UTF-8') : null;

    $is_complete = (
        !empty($favorite_movie) &&
        !empty($favorite_book) &&
        !empty($sort_of_music) &&
        !empty($hobbies) &&
        !empty($dress_sense) &&
        !empty($sense_of_humor) &&
        !empty($describe_personality) &&
        !empty($like_to_travel) &&
        !empty($partner_diff_culture) &&
        !empty($spend_weekend) &&
        !empty($perfect_match)
    ) ? 1 : 0;

    $updated_by = $user_id;

    // Start transaction
    $conn->begin_transaction();

    try {
        // SQL Update query
        $sql = "UPDATE personality_profile 
                SET favorite_movie = ?, favorite_book = ?, sort_of_music = ?, hobbies = ?, 
                    dress_sense = ?, sense_of_humor = ?, describe_personality = ?, 
                    like_to_travel = ?, partner_diff_culture = ?, spend_weekend = ?, 
                    perfect_match = ?, is_complete = ?, updated_by = ? 
                WHERE user_id = ?";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param(
                "sssssssssssiii",
                $favorite_movie,
                $favorite_book,
                $sort_of_music,
                $hobbies,
                $dress_sense,
                $sense_of_humor,
                $describe_personality,
                $like_to_travel,
                $partner_diff_culture,
                $spend_weekend,
                $perfect_match,
                $is_complete,
                $updated_by,
                $user_id
            );

            // Execute the statement
            if ($stmt->execute()) {
                // Commit the transaction
                $conn->commit();
                $_SESSION['message'][] = array("type" => "success", "content" => "Personality profile updated successfully.");
                echo "Personality profile updated successfully.";
            } else {
                // If execution fails, throw an exception
                throw new Exception("Error executing query: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        } else {
            // If preparing the statement fails, throw an exception
            throw new Exception("Error preparing query: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        // Display the error message
        $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
    }
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
<?php include 'userlayout/header.php'; ?>

<body class="bg-light w-100">
    <!-- container start -->
    <div class="container">
        <h3 class=" text-muted mt-5">Edit Personality Profile</h3>
        <div class="max-width-3">
            Let your personality shine. Express yourself in your own words to give other users a better understanding of <br class="d-none d-sm-flex"> who you are.
        </div>
        <div class="col-lg-12 col-md-12, col-10">
            <?php
            displaySessionMessage();
            ?>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
            <!-- favorite movie -->
            <div class="col-lg-12 col-md-12, col-10 ">
                <div class="mb-3 mt-5 text-muted">
                    <label for="favorite_movie" class="form-label">What is your favorite movie?</label>
                    <textarea id="favorite_movie" name="favorite_movie" class="form-control border-secondary-subtle" rows="2"
                        class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($favorite_movie); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- favorite book -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-2 mt-5 text-muted">
                    <label for="favorite_book" class="form-label">What is your favorite book?</label>
                    <textarea id="favorite_book" name="favorite_book" class="form-control border-secondary-subtle" rows="2"
                        class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($favorite_book); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Music preferences -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="sort_of_music" class="form-label">What sort of music do you like?</label>
                    <textarea id="sort_of_music" name="sort_of_music" class="form-control border-secondary-subtle" rows="2"
                        class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($sort_of_music); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Hobbies -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="hobbies" class="form-label">What are your hobbies and interests?</label>
                    <textarea id="hobbies" name="hobbies" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($hobbies); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Dress Sense -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="dress_sense" class="form-label">How would you describe your dress sense?</label>
                    <textarea id="dress_sense" name="dress_sense" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($dress_sense); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Sense of Humor -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="sense_of_humor" class="form-label">How would you describe your sense of humor?</label>
                    <textarea id="sense_of_humor" name="sense_of_humor" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($sense_of_humor); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Personality Description -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="describe_personality" class="form-label">How would you describe your personality?</label>
                    <textarea id="describe_personality" name="describe_personality" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($describe_personality); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="like_to_travel" class="form-label">Do you like to travel?</label>
                    <textarea id="like_to_travel" name="like_to_travel" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($like_to_travel); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Cultural Compatibility -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="partner_diff_culture" class="form-label">Would you be open to a partner from a different culture?</label>
                    <textarea id="partner_diff_culture" name="partner_diff_culture" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($partner_diff_culture); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Weekend Preferences -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="spend_weekend" class="form-label">How do you like to spend your weekends?</label>
                    <textarea id="spend_weekend" name="spend_weekend" class="form-control border-secondary-subtle" rows="2" class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($spend_weekend); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Ideal Match -->
            <div class="col-lg-12 col-md-12, col-10">
                <div class="mb-3 mt-5 text-muted">
                    <label for="perfect_match" class="form-label">What is your idea of a perfect match?</label>
                    <textarea id="perfect_match" name="perfect_match" class="form-control border-secondary-subtle" rows="2"
                        class="form-control border-secondary-subtle "
                        rows="2"
                        style="resize: none; overflow-y: auto;"><?php echo htmlspecialchars($perfect_match); ?></textarea>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please fill this field.</div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-12 col-md-12, col-10 text-center">
                <div class="mb-3 mt-5 text-muted">
                    <button type="submit" name="submit" class="btn btn-primary mt-4 mb-5">Save Your Personlaity Information</button>
                </div>
            </div>
        </form>
    </div>
    <!-- container end -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'userlayout/footer.php'; ?>
</body>

</html>