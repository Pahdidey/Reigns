<?php

	$id = $_GET['id'];

	if ($id != "") {

		$idParts = explode("-", $id);
		$nbEntrees = count($idParts);

		$x = 0;
		$selectParts = "";
	            
	    while($x < $nbEntrees){
	    	$selectParts .= "reigns_joueurs.proposition != " . $idParts[$x] . " AND ";
	        $x++;
	    }

	    $selectParts = substr($selectParts, 0, -5);

		$link = bdConnexion();

		//$recSQL = "SELECT proposition FROM reigns_joueurs WHERE {$selectParts}";
		$recSQL = 
		"SELECT 
		jeudistance_joueurs.nom AS nomJoueur,
		reigns_joueurs.proposition AS propositionJoueur
		FROM reigns_joueurs
		INNER JOIN jeudistance_joueurs ON reigns_joueurs.id = jeudistance_joueurs.id
		WHERE {$selectParts}";

        $result = mysqli_query($link , $recSQL);

        $messages = "";


	    while ($ligne = mysqli_fetch_array($result)) {
	    	if ($ligne['propositionJoueur'] != "") {
	    		$messages .= "<figure class='flex20' id='" . $ligne['propositionJoueur'] . "'><img src='./img/proposition/proposition-recto-" . $ligne['propositionJoueur'] . ".jpg' alt='Proposition n°" . $ligne['propositionJoueur'] . "'><figcaption class='center'>" . $ligne['nomJoueur'] . "</figcaption></figure>";
	    	}     
	    }

	    echo $messages;

	    mysqli_free_result($result);
	    mysqli_close($link);
	}

?>