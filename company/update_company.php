<?php
require_once '../dbconnection/mysqli.php';

if ($conn->connect_error) {
    http_response_code(400);
    exit();
}

if (empty($_GET['id']) || empty($_GET['name']) || empty($_GET['chief']) || empty($_GET['address'])) {
    http_response_code(400);
    exit();
}

header('Content-Type: text/plain');
$stmt = $conn->prepare("UPDATE company SET name=?,chief=?,address=? WHERE id_company=?");
$stmt->bind_param("sssi", $_GET['name'], $_GET['chief'], $_GET['address'], $_GET['id']);
$stmt->execute();
?>