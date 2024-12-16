<?php
session_start();

include 'layouts/config.php';
include 'layouts/functions.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'][] = array("type" => "error", "content" => "Session expired. Please sign up again.");
    header("Location: signup.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp"])) {
    $otp = trim($_POST['otp']);

    try {
        // Check if the OTP matches for the user ID
        $sql = "SELECT id FROM users WHERE id = ? AND otp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $otp);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update verification status and clear OTP
            $update_sql = "UPDATE users SET is_verified = 1, otp = NULL WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $user_id);
            $update_stmt->execute();

            $_SESSION['message'][] = array(
                "type" => "success",
                "content" => "Your account has been successfully verified! Please complete your profile."
            );
            $_SESSION["loggedin"] = true;
            header("Location: complete-profile.php");
            exit();
        } else {
            $_SESSION['message'][] = array("type" => "error", "content" => "Invalid OTP.");
        }
    } catch (Exception $e) {
        $_SESSION['message'][] = array("type" => "error", "content" => "Error: " . $e->getMessage());
        error_log("Error: " . $e->getMessage());
    } finally {
        $stmt->close(); // Close the statement
    }

    header("Location: verify-otp.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Verify OTP - Matrimony</title>
    <style>
        .otp-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #f3f4f6;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .otp-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .otp-container button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: linear-gradient(135deg, #3987cc, #E63A7A);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .otp-container button:hover {
            background: linear-gradient(135deg, #E63A7A, #3987cc);
        }

        .otp-container .form-group {
            margin-bottom: 20px;
        }

        .otp-container .form-control {
            height: 50px;
            font-size: 16px;
        }

        .otp-container p {
            text-align: center;
            margin-top: 15px;
            color: #555;
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
    <div class="container">
        <div class="otp-container">
            <?php displaySessionMessage(); ?>
            <h2>Verify OTP</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <input type="number" class="form-control" placeholder="Enter OTP" name="otp" required>
                </div>
                <button type="submit" class="btn">Verify OTP</button>
            </form>
            <p>Didn't receive the OTP? <a href="resend-otp.php">Resend OTP</a></p>
        </div>
    </div>
</body>

</html>