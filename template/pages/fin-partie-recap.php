<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
    	
    <body>
    	<header>
    		<?php include(const_incl . 'nav.php'); ?>
            <h1>Partie terminée</h1>
        </header>

		<section>

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

				    reigns_participants.points AS pointsJoueur,
				    reigns_participants.resultat AS resultatJoueur,

				    reigns_parties.id AS idPartie,
				    reigns_parties.nom AS nomPartie
				    
				    FROM reigns_participants

				    INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
				    INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
				    INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

				    WHERE reigns_parties.nom = '{$numpartie}'";

					$result = mysqli_query($link , $recSQL);
				?>
					<p>La partie <?php echo $numpartie; ?> est terminée.</p>
					
					<ul class="styled">
					<?php while ($ligne = mysqli_fetch_array($result)) { ?>					
						<li><strong><?php echo $ligne['nomJoueur']; ?></strong> (<?php echo $ligne['roleJoueur']; ?>)&nbsp;: <?php echo $ligne['pointsJoueur']; ?> points&nbsp;- <?php echo $ligne['resultatJoueur']; ?>.</li>					
					<?php } ?>
					</ul>


			    <?php
			    	$recSQL2 = "SELECT etat FROM reigns_parties WHERE nom = '{$numpartie}'";

		            $result2 = mysqli_query($link , $recSQL2);
		            $ligne2 = mysqli_fetch_array($result2);

		            if ($ligne2['etat'] == "En cours") {
		            	$recSQL3 = "UPDATE reigns_parties SET etat = 'Terminée' WHERE nom = '{$numpartie}'";
			        	$result3 = mysqli_query($link , $recSQL3);

			        	sleep(5);
				    	$recSQL4 = "UPDATE reigns_joueurs SET objectif = NULL, proposition = NULL, role = 'Conseiller'";
	        			$result4 = mysqli_query($link , $recSQL4);

	        			$recSQL4 = "UPDATE reigns_propositions SET id_joueur = NULL, resultat = NULL";
	        			$result4 = mysqli_query($link , $recSQL4);

				    	mysqli_free_result($result3);
				        mysqli_free_result($result6);
				        mysqli_free_result($result7);
						mysqli_close($link);
		            }
		            unset($_SESSION['numpartieReigns']);
				?>

			    <div class="actions">
			    	<a href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>" class="button close">Revenir au profil</a>
			    </div>
		    

			</div>

		</section>

		
		<?php include(const_incl . 'footer.php'); ?>

	</body>
</html>