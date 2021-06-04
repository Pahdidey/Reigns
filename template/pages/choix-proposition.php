<?php
	$carteProposee = $_POST['proposition'];

	echo $carteProposee;

	$link = bdConnexion();

	$recSQL = 
	"UPDATE reigns_propositions SET resultat = 'Proposée' WHERE id = {$carteProposee}";
	$result = mysqli_query($link , $recSQL);

	$recSQL2 = "UPDATE reigns_joueurs SET proposition = {$carteProposee} WHERE id = {$_SESSION['id']}";
	$result2 = mysqli_query($link , $recSQL2);

	header('location:index.php?page=joueur&carte=proposee&idjoueur=' . $_SESSION['id']);
?>
				


