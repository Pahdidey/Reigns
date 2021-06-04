<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
        <header>
            <?php include(const_incl . 'nav.php'); ?>
            <h1>Fin de partie</h1>
        </header>

        <section id="finpartie">

            <div class="box">

				<?php
					$numpartie = $_SESSION['numpartieReigns'];

					$link = bdConnexion();

					$recSQL = 
					"SELECT 
				    jeudistance_joueurs.nom AS nomJoueur,

				    reigns_joueurs.id AS idJoueur,
				    reigns_joueurs.role AS roleJoueur,
				    reigns_joueurs.proposition AS propositionJoueur,

				    reigns_parties.id AS idPartie,
				    reigns_parties.nom AS nomPartie
				    
				    FROM reigns_participants

				    INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
				    INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
				    INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

				    WHERE reigns_parties.nom = '{$numpartie}'";

					$result = mysqli_query($link , $recSQL);

					$donneesForm = array();
					$totalPoints = 0;
					$x = 0;
				?>

				<p>Entrez les points gagnés par l'objectif personnel de chaque Conseiller pour calculer <strong>le score final</strong>, mettre 0 si le Roi a 12&nbsp;points ou plus.</p>
				<p>Chaque proposition validée non résolue <strong>retire 1 point à son joueur</strong>.</p>
				<p>Le joueur qui a causé la mort du roi gagne <strong>1 point supplémentaire</strong> s'il raconte comment le roi est mort et que l'ensemble des joueurs valide.</p>


				<form action="" method="POST" class="flex">

					<?php while ($ligne = mysqli_fetch_array($result)) { ?>
	                    <div class="flex50">
	                    	<?php if ($ligne['roleJoueur'] == "Conseiller") { ?>
	                    		<?php
									$recSQL2 = "SELECT count(resultat) AS total FROM reigns_propositions WHERE id_joueur = {$ligne['idJoueur']} AND resultat ='Choisie'";

						            $result2 = mysqli_query($link , $recSQL2);
						            $ligne2 = mysqli_fetch_array($result2);

						            mysqli_free_result($result2);
					            ?>
		                        <label for='result-<?php echo $x; ?>'><strong><?php echo $ligne['nomJoueur']; ?> (Conseiller)</strong>&nbsp;: <?php echo $ligne2['total']; ?> points&nbsp;+</label>
	                        	<input type="number" name="result-<?php echo $x; ?>" id="result-<?php echo $x; ?>" />
	                        	<?php $donneesForm[$ligne['idJoueur']] = $ligne2['total']; ?>
	                        <?php } else { ?>
	                        	<?php
									$recSQL2 = "SELECT count(resultat) AS total FROM reigns_propositions WHERE resultat ='Choisie'";

						            $result2 = mysqli_query($link , $recSQL2);
						            $ligne2 = mysqli_fetch_array($result2);

						            mysqli_free_result($result2);
					            ?>
	                        	<label for='result-<?php echo $x; ?>'><strong><?php echo $ligne['nomJoueur']; ?> (Roi)</strong>&nbsp;: <?php echo $ligne2['total']; ?> points</label>
	                        	<input type="number" name="result-<?php echo $x; ?>" id="result-<?php echo $x; ?>" value="0" disabled />
	                        	<?php $donneesForm[$ligne['idJoueur']] = $ligne2['total']; ?>
	                        <?php } ?>
	                        <?php $x++; ?>
	                    </div>
                    <?php } ?>

                    <button type="submit" id="button">Valider</button>

                </form>


				

				<?php
					if (!empty($_POST)) {
						mysqli_free_result($result);
						$pointsFinaux = 0;
						$y = 0;
						foreach ($donneesForm as $cle => $valeur) {
		                    $points = "result-" . $y;
		                    $pointsFinaux = $valeur + $_POST[$points];
		                    echo $cle;
							echo " : ";
							echo $pointsFinaux;
							echo "<br>";
		                    $recSQL = 
		                    "UPDATE reigns_participants 
		                    SET 
		                    points = '{$pointsFinaux}'
		                    WHERE id_joueur = {$cle}";
		                    $result = mysqli_query($link , $recSQL);
		                    $ligne = mysqli_fetch_assoc($result);
		                    mysqli_free_result($result);
		                    $y++;
		            	}

		            	$recSQL2 = 
		            	"SELECT 
		            	jeudistance_joueurs.nom AS nomJoueur,

		            	reigns_joueurs.id AS idJoueur,

		            	reigns_participants.points AS pointsJoueur,
		            	reigns_participants.resultat AS resultatJoueur,
		            	reigns_participants.id_partie AS idPartie

		            	FROM reigns_participants 

		            	INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
		            	INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
		            	INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

		            	WHERE reigns_parties.nom = '{$numpartie}'
		            	ORDER BY reigns_participants.points DESC";

			            $result2 = mysqli_query($link , $recSQL2);

			            $z = 0;
			            $scoreGagnant = 0;
			            while ($ligne2 = mysqli_fetch_array($result2)) {
			            	if ($z == 0) {
			            		$scoreGagnant = $ligne2['pointsJoueur'];
			            		$recSQL =
			            		"UPDATE reigns_participants 
			                    SET 
			                    resultat = 'Victoire'
			                    WHERE id_joueur = {$ligne2['idJoueur']} AND id_partie = {$ligne2['idPartie']}";
			                    $result = mysqli_query($link , $recSQL);
			                    $ligne = mysqli_fetch_assoc($result);
			                    mysqli_free_result($result);
			            	} else if ($ligne2['pointsJoueur'] == $scoreGagnant) {
			            		$recSQL =
			            		"UPDATE reigns_participants 
			                    SET 
			                    resultat = 'Victoire'
			                    WHERE id_joueur = {$ligne2['idJoueur']} AND id_partie = {$ligne2['idPartie']}";
			                    $result = mysqli_query($link , $recSQL);
			                    $ligne = mysqli_fetch_assoc($result);
			                    mysqli_free_result($result);
			            	} else {
			            		$recSQL =
			            		"UPDATE reigns_participants 
			                    SET 
			                    resultat = 'Défaite'
			                    WHERE id_joueur = {$ligne2['idJoueur']} AND id_partie = {$ligne2['idPartie']}";
			                    $result = mysqli_query($link , $recSQL);
			                    $ligne = mysqli_fetch_assoc($result);
			                    mysqli_free_result($result);
			            	}
			            	$z++;
			            }

			            mysqli_free_result($result2);
			            mysqli_close($link);
		                header('location:index.php?page=fin-partie-recap');
					 }
                ?>

                <?php	
				    mysqli_close($link);
				?>

			</div>

			<p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>">Revenir au profil</a></p>
            
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>