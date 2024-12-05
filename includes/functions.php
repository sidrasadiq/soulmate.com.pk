<?php
// Function to retrieve the base URL
function homeURL()
{
    // Check if the server uses HTTPS or HTTP
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    // Fetch the host name
    $host = $_SERVER['HTTP_HOST'];

    // Construct and return the full URL
    return $protocol . "://" . $host;
}
// Function to get all religions from the database with transaction, try-catch, and SQL injection prevention
function getReligions($conn)
{
    $religions = [];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare SQL query to fetch religions (no direct user input here, but using prepared statements for future safety)
        $stmt = $conn->prepare("SELECT religion_name FROM religion WHERE is_active = ?");

        // Check if the prepare was successful
        if ($stmt === false) {
            throw new Exception("Failed to prepare SQL query: " . $conn->error);
        }

        // Bind parameters to the prepared statement
        $is_active = 1;  // Active religions
        $stmt->bind_param("i", $is_active);  // 'i' denotes the integer type

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Fetch all religions as an associative array
            $religions = $result->fetch_all(MYSQLI_ASSOC);
        }

        // Commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();

        // Log or display the error message
        error_log("Error fetching religions: " . $e->getMessage());

        // Display a generic message for the user
        echo "An error occurred while fetching religions. Please try again later.";
    } finally {
        // Close the prepared statement only if it was created
        if (isset($stmt)) {
            $stmt->close();
        }
    }

    return $religions;
}


// Function to get all countries from the database with transaction, try-catch, and SQL injection prevention
function getCountries($conn)
{
    $countries = [];
    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare SQL query to fetch countries
        $stmt = $conn->prepare("SELECT country_name, country_code FROM countries WHERE is_active = ?");

        // Bind parameters to the prepared statement
        $is_active = 1;  // Active countries
        $stmt->bind_param("i", $is_active);  // 'i' denotes the integer type

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Fetch all countries as an associative array
            $countries = $result->fetch_all(MYSQLI_ASSOC);
        }

        // Commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        // Log or display the error message
        error_log("Error fetching countries: " . $e->getMessage());
        echo "An error occurred while fetching countries. Please try again later.";
    } finally {
        // Close the prepared statement
        $stmt->close();
    }

    return $countries;
}
