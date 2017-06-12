<?php		
	// Fonction pour récupérer les données du fichier json et les décoder en array
	function fileGetter($file){
		global $toDo;
		global $done;
		$toDo = [];
		$done = [];
		$myTasksJson = file_get_contents($file);
		$myTasksArray = json_decode($myTasksJson, true);
		foreach ($myTasksArray as $key => $value) {
			if ($value['progress'] == "todo"){
				array_push($toDo, $value);
			}
			else {
				array_push($done, $value);
			}
		}
	}

	// Si une tâche est ajoutée ou supprimée
	function modifier($type){
		global $toDo;
		global $done;
		if($type == 'ajout'){
			$aRealise = $_POST['tacheAjout'];
			$rank = count($toDo)+1;
			$toAdd = ['id'=>$rank,
					  'task'=>$aRealise,
					  'progress'=>'todo'];
			array_push($toDo, $toAdd);
		}
		elseif($type == 'done'){
			// Parcourrir le POST pour identifier la tâche réalisée
			foreach ($_POST as $keyPost => $valuePost) {
			 	if($valuePost == 'checked'){
			 		// La supprimer de la liste à faire et l'ajouter à la listée réalisée
					foreach ($toDo as $keyItem => $valueItem) {
						if($keyPost == $valueItem['id']){
							array_push($done, $valueItem);
							array_splice($toDo, $keyItem, 1);
						}
					}
				}
			}
		}
		// Appeler l'updater pour mettre à jour le fichier JSON
		updater();
	}

	// Fonction à appeler pour mettre à jour le fichier JSON
	function updater(){
		global $toDo;
		global $done;
		$listToUpdate = [];
		foreach($toDo as $key => $value) {
			$listToUpdate[$value] = "todo";
		}
		foreach($done as $key => $value) {
			$listToUpdate[$value] = "done";
		}
		$jsonUpdate = json_encode($listToUpdate);
		print_r($listToUpdate);
		file_put_contents('data.json', $jsonUpdate);
		echo($jsonUpdate);
	}

	// Transformer les array de liste en HTML selon le type
	function lister($list, $progress) {
		$listHtml = '';
		if ($progress == "done"){
			// S'il s'agit de la liste exécutée
			foreach ($list as $key => $value) {
				$item = "<li>" . $value['task'] . "</li>";
				$listHtml = $listHtml .	 $item;
			}
		}
		else {
			foreach ($list as $key => $value) {
				$item = "<li><input type='checkbox' name='" . $value['id'] . "' value='checked'>" . $value['task'] . "</li> ";
				$listHtml = $listHtml .	 $item;
			}
		}
		return "<ul>" . $listHtml . "</ul>";
	}