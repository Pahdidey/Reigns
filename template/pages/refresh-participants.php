<?php

	$id = $_GET['id'];

	if ($id != "") {

		$numpartie = $_SESSION['numpartieReigns'];

		$link = bdConnexion();

		$recSQL3 = "SELECT etat FROM reigns_parties WHERE nom = '{$numpartie}'";

        $result3 = mysqli_query($link , $recSQL3);
        $ligne3 = mysqli_fetch_array($result3);


        if ($ligne3['etat'] == "En attente") {

			$idParts = explode("-", $id);
			$nbEntrees = count($idParts);

			$x = 0;
			$selectParts = "";
		            
		    while($x < $nbEntrees){
		    	$selectParts .= "reigns_participants.id_joueur != " . $idParts[$x] . " AND ";
		        $x++;
		    }

		    $selectParts = substr($selectParts, 0, -5);


		    $recSQL = 
		    "SELECT 

		    jeudistance_joueurs.nom AS nomJoueur,

		    reigns_participants.id AS idParticipant, 
	        reigns_participants.id_partie AS idPartieParticipant,
	        reigns_participants.id_joueur AS idJoueurParticipant,

	        reigns_parties.id AS idPartie,
	        reigns_parties.nom AS nomPartie,

	        reigns_joueurs.id AS idJoueur

	        FROM reigns_participants

	        INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
	        INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
	        INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

		    WHERE {$selectParts} AND reigns_parties.nom = '{$numpartie}'";

		    $result = mysqli_query($link , $recSQL);

		    $messages = "";

		    while ($ligne = mysqli_fetch_array($result)) {
		        $messages .= "<li id='" . $ligne['idJoueurParticipant'] . "'>" . $ligne['nomJoueur'] . "</li>";
		    }

		    echo $messages;

		    mysqli_free_result($result);
		    mysqli_close($link);

		} elseif ($ligne3['etat'] == "En cours") {
			echo "En cours";
		}

	}
?>