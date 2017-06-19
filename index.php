<?php
function lister($type) {
	// Vérifier si les boites sont à checker ou pas
	global $toDo;
	$listHtml = '';
 	foreach ($toDo as $key => $value){
 		$checked = "";
 		if ($value['progress'] == 'done'){
 			$checked = "checked";
 		}
 		if ($value['progress'] == $type){
		$item = "<li draggable='true' ><div  class='box-item'><label for='".$value['ID']."'><input name='".$value['ID']."'type='checkbox' id='" . $value['ID'] . "' value='checked'". $checked ."> " . $value['task'] . "</label></div></li> ";
		$listHtml = $listHtml .	 $item;
		$checked = '';
		}
	}
	return "<ul id='toDrag'>" . $listHtml . "</ul>";
}
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
		// Initier la connection à la DB
		try {
			$dbb = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'root', 'root');
		}
		catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
		// Update suite à un ajout
		if(isset($_POST['ajout'])){
			$req = $dbb->prepare("INSERT INTO todos(task, progress) VALUES(?, 'todo')");	
			$req->execute(array($_POST['tacheAjout']));
			$req->closeCursor();
		}
		// Update suite à une tache réalisée
		if(isset($_POST['done'])){
			foreach ($_POST as $keyPost => $valuePost) {
			 	if($valuePost == 'checked'){
				$req = $dbb->prepare("UPDATE todos SET progress = 'done' WHERE ID = ? ");	
				$req->execute(array($keyPost));
				$req->closeCursor();
				}
			}
		}
		// Récupérer la liste et faire le tri
		$req = $dbb->query('SELECT * FROM todos');
		$toDo = [];
		while ($donnee = $req->fetch()){
			array_push($toDo,$donnee);
		}
		$req->closeCursor();
		?>
		<div class="container">
			<h1>My To Do List</h1>
			<div class="row">
			<h2>A faire</h2>
				<form method="post">
					<?php
					echo(lister('todo'));
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
				echo(lister('done'));
				?>
				</form>
			</div>
		</div>
	<script  src="app.js"></script>
</body>
</html>