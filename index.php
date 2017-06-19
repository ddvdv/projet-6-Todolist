<?php
require 'functions.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
	 	<link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet"> 
		<link rel="stylesheet" href="style.css">
	</head>
<body>
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


		// Récupérer le fichier
		//fileGetter("data.json");

		// S'il y a une tâche à ajouter
		if(isset($_POST['ajout'])){
			modifier('ajout');
		}

		// Si une tâche a été marquée comme réalisée
		if(isset($_POST['done'])){
			modifier('done');
		}
		?>
		<div class="container">
			<h1>My To Do List</h1>
			<div class="row">
			<h2>A faire</h2>
				<form method="post">
				<?php
					echo(lister($toDo, 'todo'));
				?>
					<input type="submit" name="done" value="done">
				</form>
			</div>

			<div class="row">
			<h2>Ajouter une tâche</h2>
				<form method='post'>
					Tâche à effectuer:
					<input type="text" name="tacheAjout">
					<input type="submit" name="ajout" value="ajout">
				</form>
			</div>

			<div class="row">
			<h2>Archive</h2>
				<form method='post' class="crossed">
				<?php
					echo(lister($done, 'done'));
				?>
				</form>
			</div>


		</div>


	<script  src="app.js"></script>
</body>
</html>