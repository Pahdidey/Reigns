<?php
	$link = bdConnexion();

   	$recSQL = "SELECT * FROM reigns_propositions WHERE id_joueur IS NULL" ;
	$result = mysqli_query($link , $recSQL);

	$propDispo = array();

	while ($ligne = mysqli_fetch_array($result)) {
		$propDispo[] = $ligne['id'];
	}

	$recSQL6 = "SELECT COUNT(*) AS total FROM reigns_joueurs WHERE objectif IS NOT NULL";
    $result6 = mysqli_query($link , $recSQL6);
    $ligne6 = mysqli_fetch_array($result6);

    $recSQL7 = 
    "SELECT id FROM reigns_joueurs WHERE objectif IS NOT NULL";
    $result7 = mysqli_query($link , $recSQL7);
    $joueursPartie = array();
    while ($ligne7 = mysqli_fetch_array($result7)) {
        $joueursPartie[] = $ligne7['id'];
    }


    $nbTotalParticipants = $ligne6['total'];
    $max = count($propDispo) - 1;
    $objectifsJoueurs = array();
    while($nbTotalParticipants != 0) {
      $nbAuHasard = mt_rand(0, $max);
      if(!in_array($nbAuHasard, $objectifsJoueurs)) {
        $objectifsJoueurs[] = $nbAuHasard;
        $nbTotalParticipants--;
      }
    }

    $mainJoueur = array();
    foreach ($objectifsJoueurs as $valeur) {
        echo "<p>{$valeur} : {$propDispo[$valeur]}</p>";
    	$mainJoueur[] = $propDispo[$valeur];
    }

    echo "<br><br>";

    $x = 0;

    mysqli_free_result($result);
    foreach ($joueursPartie as $valeur) {
    	echo "<p>" . $valeur . " : " . $mainJoueur[$x] . "</p>";
    	$recSQL = 
        "UPDATE reigns_propositions 
        SET 
        id_joueur = {$valeur}
        WHERE id = {$mainJoueur[$x]}";
        $result = mysqli_query($link , $recSQL);
        $ligne = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    	$x++;
    }

    mysqli_free_result($result);
    $recSQL = 
    "UPDATE reigns_joueurs SET proposition = NULL";
    $result = mysqli_query($link , $recSQL);
    $ligne = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
 	$x++;




    mysqli_free_result($result6);
    mysqli_free_result($result7);
    mysqli_free_result($result);
	mysqli_close($link);
	header('location:index.php?page=joueur&idjoueur=' . $_SESSION['id']);
?>
				


