<?php
session_start();
include 'layouts/config.php';
include 'layouts/functions.php';
include 'layouts/main.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['message'][] = ["type" => "danger", "content" => "Email and Password are required."];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Query to fetch user data along with verification status
        $sql = "SELECT u.id, u.username, u.password, u.role_id, u.is_verified, 
                       COALESCE(p.first_name, 'Soulmate') AS first_name, 
                       COALESCE(p.last_name, 'User') AS last_name
                FROM users u 
                LEFT JOIN profiles p ON u.id = p.user_id
                WHERE u.email = ? 
                AND u.is_active = 1;";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $username, $hashed_password, $role_id, $is_verified, $first_name, $last_name);

        if ($stmt->fetch()) {
            // Check if the user is verified
            if ($is_verified != 1) {
                $_SESSION['message'][] = ["type" => "danger", "content" => "Your account is not verified. Please check your email for the verification link."];
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["role_id"] = $role_id;
                $_SESSION["email"] = $email;
                $_SESSION["first_name"] = $first_name ?? "Soulmate";
                $_SESSION["last_name"] = $last_name ?? "User";

                // Send welcome email using PHPMailer
                $emailSent = sendWelcomeEmail($email, $username);

                if ($emailSent === true) {
                    // $_SESSION['message'][] = ["type" => "success", "content" => "Login successful!"];
                } else {
                    $_SESSION['message'][] = ["type" => "warning", "content" => "Login successful, but failed to send welcome email: $emailSent"];
                }

                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'][] = ["type" => "danger", "content" => "Invalid email or password."];
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        } else {
            $_SESSION['message'][] = ["type" => "danger", "content" => "Invalid email or password."];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['message'][] = ["type" => "danger", "content" => "Error: " . $e->getMessage()];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'layouts/title-meta.php'; ?>
    <?php // include 'layouts/head-css.php'; 
    ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Login - Matrimony</title>
    <style>
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

        /* welcome section image */
        .welcome-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.5;
        }

        /* welcome section text */
        .welcome-text {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
        }

        /* welcome section heading */
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

        /* form section Button */
        .form-section #login-button {
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

        /* hover form section */
        .form-section #login-button:hover {
            background: linear-gradient(135deg, #E63A7A, #3987cc);
        }

        /* form fields */
        .input-group {
            margin-bottom: 20px;
        }

        /* social icons */
        .social-icons-lg a {
            font-size: 24px;
            color: #E63A7A;
            margin: 0 10px;
        }

        /* social icons hover */
        .social-icons-lg a:hover {
            color: #007bff;
        }

        /**
        google button sign in    */
        .login-with-google-btn {
            /* transition: background-color .3s, box-shadow .3s; */
            text-decoration: none;
            padding: 12px 16px 12px 42px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
            color: #757575;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 12px 11px;

            /* hover of buttton */
            &:hover {
                box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
            }


        }

        /* responsive for mobile screen */
        @media (max-width: 768px) {

            /* main container */
            .main-container {
                flex-direction: column;
                box-shadow: none;
                width: 100%;
                margin-top: -30px;
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
        .sign-up-button {
            background-color: #3987cc;
            /* Blue color for sign up */
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sign-up-button:hover {
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
            <a href="signup.php" class="btn btn-primary sign-up-button me-3">Sign Up</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid d-flex justify-content-center align-items-center mt-1 pt-5 mb-5">
        <div class="main-container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <img src="assets/images/Login page image.webp" alt="Welcome Image">
                <div class="welcome-text">
                    <h2>Welcome Back!</h2>
                    <p>Login to Continue Your Journey</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h2 class="text-center mb-4">Members Log In</h2>
                    <?php displaySessionMessage(); ?>
                    <div class="input-group mt-5">
                        <input type="email" name="email" class="form-control" placeholder="Your Email Address" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Your Password" required>
                    </div>
                    <button id="login-button" type="submit">Continue</button>

                    <p class="mt-4 text-center">Let Others Know About Soulmate!</p>
                    <div class="social-icons-lg text-center mt-3">
                        <a href="https://www.facebook.com/soulmatemetrimony/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/soulmatemetrimonypakistan/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                    <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
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