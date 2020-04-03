<?php
try {
    require_once '../dbconnection/pdo.php';
} catch (PDOException $e) {
    http_response_code(400);
    exit();
}

if (empty($_GET['company']) || empty($_GET['number']) || empty($_GET['name'])
    || empty($_GET['sum']) || empty($_GET['data_start']) || empty($_GET['data_end'])
    || empty($_GET['prepaid'])) {
    http_response_code(400);
    exit();
}

try {
    header('Content-Type: text/plain');
    $stmt = $conn->prepare("INSERT INTO contract (id_company, number, name, sum, data_start, data_end, prepaid) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array($_GET['company'], $_GET['number'], $_GET['name']
        , $_GET['sum'], $_GET['data_start'], $_GET['data_end'], $_GET['prepaid']));
    echo $conn->lastInsertId();
} catch (PDOException $e) {
    http_response_code(400);
    exit();
}
?>