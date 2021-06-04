<?php
	$link = bdConnexion();

	$recSQL = "SELECT count(proposition) AS total FROM reigns_joueurs";

    $result = mysqli_query($link , $recSQL);
    $ligne = mysqli_fetch_array($result);


    if ($ligne['total'] == 0) {
    	echo "Nouvelle manche";
    }

	mysqli_free_result($result);
	mysqli_close($link);
?>