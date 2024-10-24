<?php include("header.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Matrimony</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <img src="assest/Singuppageimage.jpg" alt="Welcome Image">
            <div class="welcome-text">
                <h2>Join Us</h2>
                <p>Your Perfect Match is Just a Click Away</p>
            </div>
        </div>
        <div class="form-section">
            <form class="signup-form">
                <h2>Sign Up</h2>
                <!-- Full Name -->
                <div class="input-group">
                    <input type="text" placeholder="Full Name" required>
                </div>
                <!-- Gender -->
                <div class="input-group">
                    <select required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <!-- Date of Birth -->
                <div class="input-group">
                    <input type="date" placeholder="Date of Birth" required>
                </div>
                <!-- Email -->
                <div class="input-group">
                    <input type="email" placeholder="Email Address" required>
                </div>
                <!-- Phone Number -->
                <div class="input-group">
                    <input type="tel" placeholder="Phone Number" required>
                </div>
                <!-- Password -->
                <div class="input-group">
                    <input type="password" placeholder="Password" required>
                </div>
                <!-- Confirm Password -->
                <div class="input-group">
                    <input type="password" placeholder="Confirm Password" required>
                </div>
                <!-- Submit Button -->
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="http://localhost/shadi/login.php">Log In</a></p>
            </form>
        </div>
    </div>
</body>
</html>


<?php include("footer.php")?>