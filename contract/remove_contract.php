<?php
try {
    require_once '../dbconnection/pdo.php';
} catch (PDOException $e) {
    http_response_code(400);
    exit();
}

if (empty($_GET['id'])){
    http_response_code(400);
    exit();
}

try {
    header('Content-Type: text/plain');
    $stmt = $conn->prepare("DELETE FROM contract WHERE id_contract=?");
    $stmt->execute(array($_GET['id']));
} catch (PDOException $e) {
    http_response_code(400);
    exit();
}
?>
