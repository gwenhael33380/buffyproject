<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Article');
$req = $db->prepare("
       SELECT a.id, a.id_user, a.title, a.content, a.content_2 a.created_at, a.id_image, u.first_name, u.last_name, i.file_name, i.alt
    FROM articles a
    LEFT JOIN users u
    ON u.id = a.id_user
    LEFT JOIN images i
    ON a.id_image = i.id
    WHERE a.id = ?
    ORDER BY a.created_at DESC    
    ");

$req->execute();
$article = $req->fetchAll(PDO::FETCH_OBJ);