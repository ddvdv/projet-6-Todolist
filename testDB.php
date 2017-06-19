<?php

try {
	$dbb = new PDO('mysql:host=localhost;dbname=monTest;charset=utf8', 'root', 'root');
}
catch (Exception $e){
	die('Erreur : ' . $e->getMessage());
}

$reponse = $dbb->query('SELECT * FROM userList WHERE id = 2;');

while ($donnee = $reponse->fetch()){
	echo("Le personnage que j'ai sélectionné est " . $donnee['firstname']);
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>testDB</title>
</head>
<body>

</body>
</html>