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
