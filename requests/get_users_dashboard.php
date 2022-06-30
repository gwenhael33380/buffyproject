<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';



$filter = $_GET['filter'];


//sleep(5);

$req = $db->prepare("
	SELECT DISTINCT COUNT(c.id) count_comment, COUNT(a.id) count_article, u.id, u.id_role, u.first_name, u.last_name, u.pseudo, u.email, u.id_image, r.id id_role, r.role_name, r.role_slug, a.id id_article, c.id id_comment, i.id as id_image, i.file_name
	FROM users u
	LEFT JOIN roles r
	ON u.id_role = r.id
	LEFT JOIN articles a
	ON a.id_user = u.id
	LEFT JOIN comments c
	ON c.id_user = u.id
	LEFT JOIN images i
	ON u.id_image = i.id
	WHERE u.last_name LIKE CONCAT('%',:filter,'%')
	OR u.first_name LIKE CONCAT('%',:filter,'%')
	OR u.pseudo LIKE CONCAT('%',:filter,'%')
	OR u.email LIKE CONCAT('%',:filter,'%')
	GROUP BY u.id
	ORDER BY r.id ASC
");

$req->bindValue(':filter', $filter, PDO::PARAM_STR);
$req->execute();
$req->setFetchMode(PDO::FETCH_ASSOC);
$results = $req->fetchAll(PDO::FETCH_OBJ);

header('Content_type: application/json; charset=utf-8');
                                    //sécurise la faille XSS
print json_encode($results, JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);
