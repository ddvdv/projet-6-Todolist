<?php 

	try {
		$dbb = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'root', 'root');
	}
	catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
	}

	foreach ($_POST as $keyPost => $valuePost) {
	 	if($valuePost == 'checked'){
		$req = $dbb->prepare("UPDATE todos SET progress = 'done' WHERE ID = ? ");	
		$req->execute(array($keyPost));
		$req->closeCursor();
		}
	}

?>