<?php
	$numpartie = $_SESSION['numpartieReigns'];

	$link = bdConnexion();

	$recSQL = "SELECT etat FROM reigns_parties WHERE nom = '{$numpartie}'";

    $result = mysqli_query($link , $recSQL);
    $ligne = mysqli_fetch_array($result);

    echo $ligne['etat'];

	mysqli_free_result($result);
	mysqli_close($link);
?>