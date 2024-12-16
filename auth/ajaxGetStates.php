<?php
include 'layouts/config.php';
if (isset($_POST['country_id'])) {
    $countryId = $_POST['country_id'];

    $query = "SELECT id, state_name FROM states WHERE country_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $countryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $states = [];
    while ($row = $result->fetch_assoc()) {
        $states[] = $row;
    }

    echo json_encode($states);
}
