<?php include("header.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
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

            &:hover {
                box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
            }


        }

        .social-icons-lg a {
            font-size: 24px;
            color: #E63A7A;
            margin: 0 10px;
        }

        .social-icons-lg a:hover {
            color: #007bff;
        }

        @media screen and (max-width: 768px) {
            .form-section {
                width: 100%;
                padding: 0px;

            }

            .form-section button {
                width: 100%;
                padding: 10px;
                margin-top: 20px;
                margin-bottom: 5px;
                background: linear-gradient(135deg, #3987cc, #E63A7A);
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }

            /* Adjust buttons to be full width and smaller margin */
            .login-form button,
            .login-with-google-btn {
                width: 100%;
                padding: 10px;
                font-size: 24px;
                margin-left: 10px 10px;
            }



            /* Resize social icons for mobile */
            .social-icons-lg a {
                font-size: 20px;

            }

            /* Adjust text and heading sizes */
            .welcome-text h2 {
                font-size: 24px;
                display: none;
            }

            .welcome-text p {

                display: none;
            }

            .login-form h2 {
                font-size: 18px;
            }

            .welcome-section img {
                display: none;
            }

            .welcome-section {
                background: transparent !important;
            }

            .container {
                display: block;
            }

            .login-with-google-btn {
                font-size: 18px;
                padding-left: 40px;
            }

            .container {
                padding: 20px;
                border: none;
                border-style: none;
                box-shadow: none;
            }

            .login-form h2 {
                margin-top: 0px;
                font-size: 30px;

            }

            .input-group input {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>


    <div class="container mt-5">
        <div class="welcome-section ">
            <img src="assest/Login page image.webp" alt="Welcome Image">
            <div class="welcome-text">
                <h2 class="wel-h">Let’s Pick Up</h2>
                <p class="wel-h">Where You Left Off</p>
            </div>
        </div>
        <div class="form-section">
            <form class="login-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="<?php $_POST ?>">
                <h2 class="text-center">Members Login</h2>
                <div class="input-group mt-5">
                    <input type="email" placeholder="Email Address" required>
                </div>
                <div class="input-group ">
                    <input type="password" placeholder="Password" required>
                </div>
                <button type="submit" onclick="window.location.href='complete-profile.php';">Continue</button>
                <div class="text-center mt-4">
                    <p>or</p>
                    <!-- Google Sign-In Button -->
                    <a href="#" class="login-with-google-btn ">
                        Sign in with Google
                    </a>
                    <p class="mt-5">Let Others Know About Soulmate!</p>
                </div>
                <!-- Social Icons Section -->
                <div class="social-icons-lg text-center mt-3">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div
                    </form>
        </div>
    </div>


</body>

</html>



<?php include("footer.php") ?> 