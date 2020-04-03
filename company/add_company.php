<?php
require_once '../dbconnection/mysqli.php';

if ($conn->connect_error) {
    http_response_code(400);
    exit();
}

if (empty($_GET['name']) || empty($_GET['chief']) || empty($_GET['address'])) {
    http_response_code(400);
    exit();
}

header('Content-Type: text/plain');
$stmt = $conn->prepare("INSERT INTO company (name,chief,address) VALUES (?,?,?)");
$stmt->bind_param("sss", $_GET['name'], $_GET['chief'], $_GET['address']);
$stmt->execute();
echo $stmt->insert_id;
?>