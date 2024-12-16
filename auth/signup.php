<?php
session_start();

include 'layouts/config.php';
include 'layouts/functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {

    // Input validation and sanitization
    $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST['lastName']), FILTER_SANITIZE_STRING);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $usergender = filter_var($_POST['usergender'], FILTER_SANITIZE_STRING);
    $userlooking = filter_var($_POST['userlooking'], FILTER_SANITIZE_STRING); // Moved to requirements
    $userdate = filter_var($_POST['userdate'], FILTER_SANITIZE_STRING);
    $useremail = filter_var(trim($_POST['useremail']), FILTER_VALIDATE_EMAIL);
    $userpass = password_hash(trim($_POST['userpass']), PASSWORD_DEFAULT); // Secure password hashing
    $createdAt = date("Y-m-d H:i:s");
    $updatedAt = date("Y-m-d H:i:s");
    $role_id = 2; // Default role_id for new users
    $verification_token = bin2hex(random_bytes(16));
    $otp = rand(100000, 999999); // Generate a 6-digit OTP

    // Check if user has confirmed terms
    if (!isset($_POST['usercheck'])) {
        $_SESSION['message'][] = array("type" => "error", "content" => "You must agree to the terms to sign up.");
        header("location: signup.php");
        exit();
    }

    // Calculate the user's age based on the date of birth
    $birthDate = new DateTime($userdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 18) {
        $_SESSION['message'][] = array("type" => "error", "content" => "You must be at least 18 years old to sign up.");
        header("location: signup.php");
        exit();
    }

    try {
        // Start the transaction
        $conn->begin_transaction();

        // Check if the email already exists
        $sql_check = "SELECT id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $useremail);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['message'][] = array("type" => "error", "content" => "This email is already registered.");
            header("location: signup.php");
            exit();
        }

        // Insert user into the `users` table
        $sql_user = "INSERT INTO users (username, email, password, role_id, is_verified, verification_token, otp, created_at, updated_at) VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("ssssisss", $username, $useremail, $userpass, $role_id, $verification_token, $otp, $createdAt, $updatedAt);
        $stmt_user->execute();

        $user_id = $conn->insert_id; // Get the inserted user ID
        $_SESSION['user_id'] = $user_id; // Store user ID in session

        // Insert into the `profiles` table
        $sql_profile = "INSERT INTO profiles (first_name, last_name, user_id, gender, date_of_birth, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_profile = $conn->prepare($sql_profile);
        $stmt_profile->bind_param("ssissss", $firstName, $lastName, $user_id, $usergender, $userdate, $createdAt, $updatedAt);
        $stmt_profile->execute();

        $profile_id = $conn->insert_id; // Get the inserted profile ID

        // Insert into the `requirements` table
        $sql_requirements = "INSERT INTO requirements (user_id, profile_id, looking_for, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $stmt_requirements = $conn->prepare($sql_requirements);
        $stmt_requirements->bind_param("iisss", $user_id, $profile_id, $userlooking, $createdAt, $updatedAt);
        $stmt_requirements->execute();

        // Commit the transaction
        $conn->commit();

        // Send OTP email
        $emailSent = sendOtpEmail($useremail, $username, $otp);
        if ($emailSent !== true) {
            $_SESSION['message'][] = array("type" => "error", "content" => "Error sending OTP email: $emailSent");
        } else {
            $_SESSION['message'][] = array(
                "type" => "success",
                "content" => "Signup successful! An OTP has been sent to your email. Please verify your account."
            );

            // Set session data for user
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $role_id;
            $_SESSION['email'] = $useremail;
            $_SESSION["first_name"] = $firstName ?? "Soulmate";
            $_SESSION["last_name"] = $lastName ?? "User";

            header("Location: verify-otp.php");
            exit();
        }
    } catch (Exception $e) {
        // Rollback transaction on failure
        $conn->rollback();
        $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
        error_log("Error: " . $e->getMessage()); // Log the error
        header("location: signup.php");
        exit();
    } finally {
        $conn->close();
    }
}
?>

<?php include 'layouts/main.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'layouts/title-meta.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>Sign Up - Matrimony</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* main container */
        .main-container {
            max-width: 1000px;
            width: 80%;
            margin: auto;
            display: flex;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #f3f4f6;
        }

        /* welcome section */
        .welcome-section {
            width: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #8e2de2, #4a00e0);
        }

        /* welcom Section image */
        .welcome-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.5;
        }

        /* welcome text */
        .welcome-text {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
        }

        /* welcome heading */
        .welcome-text h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* welcome section paragraph */
        .welcome-text p {
            font-size: 18px;
        }

        /* form section */
        .form-section {
            width: 50%;
            padding: 40px;
            background-color: #f3f4f6;
        }

        /* form section button */
        .form-section button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(135deg, #3987cc, #E63A7A);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-section button:hover {
            background: linear-gradient(135deg, #E63A7A, #3987cc);
        }

        /* form fields */
        .input-group {
            margin-bottom: 20px;
        }

        /* check button */
        .form-check-label {
            color: #333;
        }

        /* check input */
        .form-check-input {
            width: 18px;
            height: 18px;
        }

        /* responsive for the mobile screen */
        @media (max-width: 768px) {

            /* main container */
            .main-container {
                flex-direction: column;
                box-shadow: none;
                width: 100%;
                margin-top: -70px;
            }

            /* welcome section */

            .welcome-section {
                display: none;
            }

            /* form section */
            .form-section {
                width: 100%;
                padding: 20px;
            }
        }

        /* General navbar styling */
        .navbar {
            /* background-color: #333; */
            /* Adjust background color */
            padding: 10px 20px;
        }

        /* Brand Logo Styling */
        .navbar-brand img.logo {
            max-height: 40px;
            transition: transform 0.3s ease;
        }

        .navbar-brand img.logo:hover {
            transform: scale(1.2);
        }

        /* Sign Up Button Styling */
        .login-button {
            background-color: #3987cc;
            /* Blue color for sign up */
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: #ce478b;
            /* Pink color on hover */
            color: white;
        }


        /* Navbar Toggler Styling */
        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        /* Style for the floating buttons container */
        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            /* Space between buttons */
            z-index: 1000;
            /* Ensure it stays on top */
        }

        /* Style for each button */
        .floating-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, background-color 0.3s;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            background-color: #f5f5f5;
        }

        /* WhatsApp button specific styling */
        .whatsapp-btn {
            background-color: #25d366;
        }

        .whatsapp-btn:hover {
            background-color: #1ebe57;
        }

        /* Call button specific styling */
        .call-btn {
            background-color: #007bff;
        }

        .call-btn:hover {
            background-color: #0056b3;
        }

        /* Icon inside button */
        .floating-btn img {
            width: 50%;
            height: auto;
        }



        .footer {
            background-color: #ffd6ef;
            padding: 40px 0;
        }

        .footer h5 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #000;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer .social-icons i {
            font-size: 18px;
            margin-right: 15px;
            color: #333;
        }

        .footer .social-icons i:hover {
            color: #007bff;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #000000;
            margin-top: 20px;
            font-size: 14px;
            color: #1167b3;
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
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="assets/images/logo.png" alt="Logo" class="logo">
            </a>
            <a href="login.php" class="btn btn-primary login-button me-3">Login</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid d-flex justify-content-center align-items-center mt-1 pt-5 mb-5">
        <div class="main-container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <img src="assets/images/Singuppageimage.jpg" alt="Welcome Image">
                <div class="welcome-text">
                    <h2>Join Us</h2>
                    <p>Your Perfect Match is Just a Click Away</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">

                <form class="signup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <?php displaySessionMessage(); ?>
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="First Name" name="firstName" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Last Name" name="lastName" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                    </div>
                    <div class="input-group">
                        <select class="form-select" name="usergender" required>
                            <option value="" disabled selected>I'm a</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <select class="form-select" name="userlooking" required>
                            <option value="" disabled selected>I'm looking for</option>
                            <option value="male">Groom (Boy)</option>
                            <option value="female">Bride (Girl)</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="date" class="form-control" name="userdate" required>
                    </div>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email Address" name="useremail" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password for your account" name="userpass" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="defaultCheck1" name="usercheck" required>
                        <label class="form-check-label" for="defaultCheck1">
                            Yes, I confirm that I am over 18 and agree to the Terms of Use and Privacy Statement.
                        </label>
                    </div>
                    <button type="submit" class="btn">Submit</button>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Log In</a></p>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <!-- Floating Buttons -->
        <div class="floating-buttons">
            <!-- WhatsApp Button -->
            <a href="https://wa.me/923032666675" target="_blank" class="floating-btn whatsapp-btn" title="Chat on WhatsApp">
                <img src="../assets/icons/whatsapp-icon.png" height="24px" alt="WhatsApp" />
            </a>
            <!-- Call Now Button -->
            <a href="tel:+923032666675" class="floating-btn call-btn" title="Call Now">
                <img src="../assets/icons/phone.png" height="24px" alt="Call Now" />
            </a>
        </div>

        <div class="container">
            <div class="row text-center text-md-start">
                <!-- About Us Section -->
                <div class="col-md-3">
                    <a class="navbar-brand me-auto" href="#"><img src="../assets/images/logo.png"></a>
                    <p>Soulmate is a trusted platform dedicated to helping individuals find their life partners in a secure, respectful environment. </p>
                </div>
                <!-- Let Us Help Section -->
                <div class="col-md-3">
                    <h5>Helpful Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                <!-- Make Money Section -->
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Success Stories</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Help & Support</a></li>
                    </ul>
                </div>
                <!-- Contact Section -->
                <div class="col-md-3">
                    <h5>CONTACT</h5>
                    <ul class="list-unstyled">
                        <li><i class="fa-solid fa-location-dot"></i> Main College Road Town <br> Ship Lahore</li>
                        <li><i class="fa-regular fa-envelope"></i> info@soulmate.com.pk </li>
                        <li><i class="fa-brands fa-whatsapp"></i> +923032666675 </li>
                        <li><i class="fa-solid fa-phone"></i> +923032666675</li>
                    </ul>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>Copyright ©2020 All rights reserved by <a href="https://themillionairesoft.com/" class="text-decoration-none">The Millionaire Soft.</a></p>
                <div class="social-icons">
                    <a href="https://web.facebook.com/soulmatemetrimony"><i class="fa-brands fa-facebook"></i></a>
                    <!-- <a href="#"><i class="fa-brands fa-twitter"></i></a> -->
                    <a href="https://www.instagram.com/soulmatemetrimonypakistan/"><i class="fa-brands fa-instagram"></i></a>
                    <!-- <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a> -->
                </div>
            </div>
        </div>

    </footer>
</body>

</html>