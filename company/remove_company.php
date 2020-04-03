<?php
require_once '../dbconnection/mysqli.php';

if ($conn->connect_error) {
    http_response_code(400);
    exit();
}

if (empty($_GET['id'])) {
    http_response_code(400);
    exit();
}

header('Content-Type: text/plain');
$stmt = $conn->prepare("DELETE FROM company WHERE id_company=?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();

?>