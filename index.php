<?php
require 'functions.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
 	<link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet"> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<h3>
		<?php
		// Récupérer le fichier
		fileGetter("data.json");

		// S'il y a une tâche à ajouter
		if(isset($_POST['ajout'])){
			modifier('ajout');
		}

		// Si une tâche a été marquée comme réalisée
		if(isset($_POST['done'])){
			modifier('done');
		}
		?>
</h3>
		<div class="container">
			<div class="header">
				<h1>My To Do List</h1>
				<div id="icone" >
					<img src="ico.png" alt="icone">
				</div>
			</div>
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
				<?php
					echo(lister($done, 'done'));
				?>
			</div>


		</div>


	<script  src="app.js"></script>
</body>
</html>