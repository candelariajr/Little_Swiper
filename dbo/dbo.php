<?php
$ini_array = parse_ini_file("db.ini");

$dsn = 'mysql:host='.$ini_array['host'].
    ';dbname='.$ini_array['dbname'].
    ';charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = false;
try {
    $pdo = new PDO($dsn, $ini_array['user'], $ini_array['password'], $options);
}catch (PDOException $e) {
    //throw new PDOException($e->getMessage(), (int)$e->getCode());
    error("Connection Failed: CODE: ".$e->getCode(). " MESSAGE: ".$e->getMessage());
}
function error($message){
    echo json_encode(array('error' => $message));
}

function message($message){
    echo json_encode(array('message' => $message));
}

if($pdo && isset($_GET['getCount'])){
    $stmt= $pdo->query('SELECT count(*) from entries');
    $resultRow = $stmt->fetch();
    message(json_encode($resultRow));
}
