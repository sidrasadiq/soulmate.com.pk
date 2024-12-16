<?php
include 'layouts/config.php';
if (isset($_POST['state_id'])) {
    $stateId = $_POST['state_id'];

    $query = "SELECT id, city_name FROM cities WHERE state_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stateId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    echo json_encode($cities);
}
