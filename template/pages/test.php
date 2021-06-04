<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
    	
    <body>
    	<?php include(const_incl . 'header.php'); ?>


		<?php 
			$link = bdConnexion();
		?>





		<?php
			// Test affichage liste des cartes
			$recSQL = "SELECT id, nom FROM cartes";
			$result = mysqli_query($link , $recSQL);
			echo "<ul>";
			while ($ligne = mysqli_fetch_array($result)) {
				echo "<li>" . $ligne['id'] . " - " . $ligne['nom'] . "</li>";
			}
			echo "</ul>";
		?>







		<?php
			mysqli_free_result($result);
			mysqli_free_result($result2);
			mysqli_close($link);

		?>

		<?php include(const_incl . 'footer.php'); ?>

	</body>
</html>

				


