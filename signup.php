<?php include 'includes/main.php'; ?>
<?php include 'includes/functions.php'; ?>

<head>
    <title>Sign Up - Matrimony</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->
    <?php include 'includes/head-css.php'; ?>
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
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center mt-5 pt-5 mb-5">
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
            <div class="form-section  ">
                <form class="signup-form">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="input-group">
                        <select class="form-select" required>
                            <option value="" disabled selected>I'm a</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <select class="form-select" required>
                            <option value="" disabled selected>I'm looking for</option>
                            <option value="male">Groom (Boy)</option>
                            <option value="female">Bride (Girl)</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <select class="form-select" required>
                            <option value="" disabled selected>Age</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Your Soulmate Password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="defaultCheck1" required>
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
</body>

</html>