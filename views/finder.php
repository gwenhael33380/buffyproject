<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

//$filter = $_GET['filter'];
$filter = 'n';


$req = $db->prepare("
	SELECT  *
	FROM users
    WHERE first_name LIKE CONCAT('%',:filter,'%')	
    ORDER BY id ASC
");

$req->bindValue(':filter', $filter, PDO::PARAM_STR);

$req->execute();
$results = $req->fetchAll(PDO::FETCH_OBJ);

header('Content_type: application/json; charset=utf-8');
print json_encode($results);






?>


