<?php include("header.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>
<body>
    <main>
        <section class="login-section">
      <div class="container">
        <div class="welcome-section">
            <img src="assest/Login page image.webp" alt="Welcome Image">
            <div class="welcome-text">
                <h2>Let’s Pick Up</h2>
                <p>Where You Left Off</p>
            </div>
        </div>
        <div class="form-section">
            <form class="login-form"  action="<?php $_SERVER['PHP_SELF']; ?>"   method="<?php $_POST ?>">
                <h2>Log In</h2>
                <div class="input-group">
                    <input type="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" required>
                </div>
                <button type="submit">Continue</button> 
                <p>or Connect with Social Media</p>
                <button class="social-btn twitter-btn">Sign in with Twitter</button>
                <button class="social-btn facebook-btn">Sign in with Facebook</button>
            </form>
        </div>
    </div>

</section>

</main>
</body>
</html>



<?php include("footer.php")?>