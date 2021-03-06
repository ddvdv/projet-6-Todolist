<?php		
	// Fonction pour récupérer les données du fichier json et les décoder en array
	function fileGetter($file){
		global $toDo;
		global $done;
		$toDo = [];
		$done = [];
		// Récupération du fichier
		$myTasksJson = file_get_contents($file);
		$myTasksArray = json_decode($myTasksJson, true);
		// Boucle de tri selon liste "à faire" ou "done"
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
		global $idArray;
		global $lastId;
		$idArray = [];
		$lastId;
		// Update suite à un ajout
		if($type == 'ajout'){
			// Déterminer quel est le dernier ID toutes categ confondues
			$myTasksArray = array_merge($toDo, $done);
			foreach ($myTasksArray as $key => $value) {
				array_push($idArray, $value['id']);
				$lastId = max($idArray);
			}
			// Push de la tâche à réaliser dans la liste ToDo
			$aRealise = $_POST['tacheAjout'];
			$rank = $lastId + 1;
			$toAdd = ['id'=>$rank,
					  'task'=>$aRealise,
					  'progress'=>'todo'];
			array_push($toDo, $toAdd);
		} // Update suite à une tache réalisée
		elseif($type == 'done'){
			// Parcourir le POST pour identifier la tâche réalisée
			foreach ($_POST as $keyPost => $valuePost) {
			 	if($valuePost == 'checked'){
			 		// La supprimer de la liste à faire et l'ajouter à la listée des tâches déjà faites
					foreach ($toDo as $keyItem => $valueItem) {
						if($keyPost == $valueItem['id']){
							$valueItem['progress'] = "done";
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
			array_push($listToUpdate, $value);
		}
		foreach($done as $key => $value) {
			array_push($listToUpdate, $value);
		}
		$jsonUpdate = json_encode($listToUpdate);
		file_put_contents('data.json', $jsonUpdate);
	}

	// Transformer les array de liste en HTML selon le type
	function lister($list, $type) {
		$listHtml = '';
		$checked = '';
		// Vérifier si les boites sont à checker ou pas
	 	foreach ($list as $key => $value) {
	 		if ($type == 'done'){
				$checked = 'checked';
			}
			$item = "<li><div class='box-item'><label for='".$value['id']."'><input name='".$value['id']."'type='checkbox' id='" . $value['id'] . "' value='checked'". $checked ."> " . $value['task'] . "</label></div></li> ";
			$listHtml = $listHtml .	 $item;
			$checked = '';
		}
		return "<ul>" . $listHtml . "</ul>";
	}