<?php

try {
	$dbb = new PDO('mysql:host=localhost;dbname=monTest;charset=utf8', 'root', 'root');
}
catch (Exception $e){
	die('Erreur : ' . $e->getMessage());
}

$reponse = $dbb->prepare('SELECT * FROM userList WHERE firstname = ?;');

$reponse->execute(array('Tintin'));

while ($donnee = $reponse->fetch()){
	echo("Le nom du personnage que j'ai sélectionné est " . $donnee['lastname']);
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