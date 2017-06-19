<?php

		$toDo = [];
		$done = [];

		try {
			$dbb = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'root', 'root');
		}
		catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
		$req = $dbb->query('SELECT * FROM todos');

		while ($donnee = $req->fetch()){
			array_push($toDo,$donnee);
		}

			echo'<pre>';
		print_r($toDo);
			echo'</pre>';

?>


<!DOCTYPE html>
<html>
<head>
	<title>testDB</title>
</head>
<body>

</body>
</html>