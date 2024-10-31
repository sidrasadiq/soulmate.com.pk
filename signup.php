<?php include("header.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Matrimony</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-check-label {
            color: #333;
    
        }

        .form-check-input {
            width: 20px;
            /* Increase the width of the checkbox */
            height: 20px;
            /* Increase the height of the checkbox */
        }

        @media (max-width: 768px) {
            .welcome-section {
                display: none;
                /* Hide welcome section on mobile */
            }

            .form-section {
                width: 100%;

            }

            .cont-reg {
                display: inline;
            }
        }
    </style>
</head>

<body>
    <div class="container cont-reg">
        <div class="welcome-section">
            <img src="assest/Singuppageimage.jpg" alt="Welcome Image">
            <div class="welcome-text">
                <h2>Join Us</h2>
                <p>Your Perfect Match is Just a Click Away</p>
            </div>
        </div>
        <div class="form-section">
            <form class="signup-form">
                <!-- <h2>Sign Up</h2> -->
                <!-- Full Name -->
                <div class="input-group">
                    <input type="text" placeholder="Full Name" required>
                </div>
                <!-- Gender -->
                <div class="input-group">
                    <select required>
                        <option value="" disabled selected>I'm a</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="input-group">
                    <select required>
                        <option value="" disabled selected> I'm looking for</option>
                        <option value="male">Groom(Boy)</option>
                        <option value="female">Bride(Girl)</option>
                    </select>
                </div>

                <div class="input-group">
                    <select required>
                        <option value="" disabled selected> Age</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                    </select>
                </div>


                <!-- Email -->
                <div class="input-group">
                    <input type="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Your Soulmate Password" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Yes, I confirm that I am over 18 and agree to the Terms of
                        Use and Privacy Statement.
                    </label>
                </div>
                <!-- Submit Button -->
                <button type="submit">Submit</button>
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </form>
        </div>
    </div>
</body>

</html>


<?php include("footer.php") ?>