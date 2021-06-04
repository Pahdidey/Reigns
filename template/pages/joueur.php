<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
    	
    <body>

    	<?php if ($_SESSION['id'] == $_GET['idjoueur']) { ?>

    	<?php 
			$link = bdConnexion();

			$recSQL = 
			"SELECT 
			jeudistance_joueurs.nom AS nomJoueur,

			reigns_joueurs.id AS idJoueur,
			reigns_joueurs.role AS roleJoueur,
			reigns_joueurs.objectif AS objectifJoueur,
			reigns_joueurs.proposition AS propositionJoueur

			FROM reigns_joueurs 

			INNER JOIN jeudistance_joueurs ON reigns_joueurs.id = jeudistance_joueurs.id

			WHERE reigns_joueurs.id =" . $_GET['idjoueur'];

			$result = mysqli_query($link , $recSQL);
			$ligne = mysqli_fetch_array($result);



			$recSQL2 = 
			"SELECT
			reigns_parties.id AS idPartie,
			reigns_parties.nom AS nomPartie,
			reigns_parties.etat AS etatPartie,

			reigns_participants.id_joueur AS idJoueurParticipants
			
			FROM reigns_parties 
			INNER JOIN reigns_participants ON reigns_parties.id = reigns_participants.id_partie 
			ORDER BY reigns_parties.id 
			DESC";
			$result2 = mysqli_query($link , $recSQL2);
			while ($ligne2 = mysqli_fetch_array($result2)) {
				if (($ligne2['etatPartie'] == "En cours") AND ($ligne2['idJoueurParticipants'] == $_SESSION['id'])) {
					$_SESSION['numpartieReigns'] = $ligne2['nomPartie'];
				}
			}



			$numpartie = $_SESSION['numpartieReigns'];

			$recSQL3 = "SELECT id, etat FROM reigns_parties WHERE nom = '{$numpartie}'";

            $result3 = mysqli_query($link , $recSQL3);
            $ligne3 = mysqli_fetch_array($result3);




            $recSQL4 = "SELECT etat FROM reigns_parties ORDER BY id DESC LIMIT 1";

            $result4 = mysqli_query($link , $recSQL4);
            $ligne4 = mysqli_fetch_array($result4);



            $recSQL5 = "SELECT id FROM reigns_propositions WHERE id_joueur = {$_GET['idjoueur']} AND resultat IS NULL" ;

			$result5 = mysqli_query($link , $recSQL5);


			$recSQL6 = "SELECT COUNT(*) AS total FROM reigns_propositions WHERE id_joueur = {$_GET['idjoueur']} AND resultat IS NULL";

			$result6 = mysqli_query($link , $recSQL6);
			$ligne6 = mysqli_fetch_array($result6);

			$recSQL7 = 
		    "SELECT 
		    jeudistance_joueurs.nom AS nomJoueur,

		    reigns_joueurs.role AS roleJoueur,
		    reigns_joueurs.proposition AS propositionJoueur,

		    reigns_parties.id AS idPartie,
		    reigns_parties.nom AS nomPartie
		    
		    FROM reigns_participants

		    INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
		    INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
		    INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

		    WHERE reigns_parties.nom = '{$numpartie}' AND reigns_joueurs.role != 'Roi'";

		    $result7 = mysqli_query($link , $recSQL7);


		    $recSQL8 = "SELECT COUNT(id_partie) AS total FROM reigns_participants WHERE id_partie = {$ligne3['id']}";

			$result8 = mysqli_query($link , $recSQL8);
			$ligne8 = mysqli_fetch_array($result8);

			$totalConseillers = $ligne8['total'] - 1;

		?>

    	<header>
    		<?php include(const_incl . 'nav.php'); ?>
            <h1><?php echo $ligne['nomJoueur']; ?></h1>
            <?php if ($ligne3['etat'] == "En cours") { ?>
            	<p>Vous êtes <strong><?php echo $ligne['roleJoueur']; ?></strong>&nbsp;!</p>
            <?php } ?>
        </header>

    	<section id="joueur">
    		<div id="partie">
    			<?php if ($ligne3['etat'] == "En cours") { ?>
    				<?php if ($ligne['roleJoueur'] == "Conseiller") { ?>
		    			<div class="box">
		    				<div>
		    					<h2>Votre objectif secret</h2>
		    					<p>Vers le négatif si le fond est noir, vers le positif si le fond est blanc.</p>
		    					<img class="objectif" src="./img/objectif/objectif-<?php echo $ligne['objectifJoueur']; ?>.jpg">
		    				</div>
		    			</div>

		    			<div class="box" id="propositions">
		    				<div>
		    					<h2>Vos cartes Proposition</h2>
		    					<?php if($ligne6['total'] != 7) { ?>
		    						<p>Vous avez fait votre proposition au Roi pour cette manche. <a class="ico visibility" href="index.php?page=proposition&carte=<?php echo $ligne['propositionJoueur']; ?>" title="Voir votre proposition"></a></p>
		    					<?php } ?>
		    					<form action="index.php?page=choix-proposition" method="post" class="flex">
		    						<?php while ($ligne5 = mysqli_fetch_array($result5)) { ?>
		    							<div>
			    							<input type="radio" id="prop-<?php echo $ligne5['id']; ?>" name="proposition" value="<?php echo $ligne5['id']; ?>" class="invisible" <?php if($ligne6['total'] != 7) { ?>disabled <?php } ?> required>
			    							<label for="prop-<?php echo $ligne5['id']; ?>">
				    							<img src="./img/proposition/proposition-recto-<?php echo $ligne5['id']; ?>.jpg">
				    							<img src="./img/proposition/proposition-verso-<?php echo $ligne5['id']; ?>.jpg">
				    						</label>
				    					</div>
									<?php } ?>
									<?php if($ligne6['total'] == 7) { ?>
										<button type="submit">Faire une Proposition</button>
									<?php } ?>
						    	</form>
						    </div>
		    			</div>
	    			<?php } else { ?>
	    				<div id="propconseillers">
		    				<div class="box">
			    				<div>
			    					<h2>Les propositions de vos fidèles Conseillers</h2>
			    					<?php if ($_GET['choix-roi'] == "fait") { ?>
			    						<p>Vous venez de rendre votre verdict : </p>
			    					<?php } ?>
			    					<div class="flex">
			    						<?php $nbProp = 0; ?>
			    						<?php $nbPropChoix = 0; ?>
				    					<?php while ($ligne7 = mysqli_fetch_array($result7)) { ?>
				    						<?php if ($ligne7['propositionJoueur'] != NULL) { ?>
					    						<figure class="flex20" id="<?php echo $ligne7['propositionJoueur']; ?>">
					    							<img src="./img/proposition/proposition-recto-<?php echo $ligne7['propositionJoueur']; ?>.jpg" alt="Proposition n°<?php echo $ligne7['propositionJoueur']; ?>">
					    							<figcaption class="center">
					    								<?php echo $ligne7['nomJoueur']; ?> 
					    								<?php
						    							$recSQL9 = "SELECT resultat FROM reigns_propositions WHERE id = {$ligne7['propositionJoueur']}";
														$result9 = mysqli_query($link , $recSQL9);
														$ligne9 = mysqli_fetch_array($result9);
						    							?>
					    								<?php if ($ligne9['resultat'] == "Choisie") { ?>
						    								<img src="./img/checked.png" alt="Choisie" />
						    								<?php $nbPropChoix++; ?>
						    							<?php } else if ($ligne9['resultat'] == "Refusée") { ?>
						    								<img src="./img/cancel.png" alt="Refusée" />
						    								<?php $nbPropChoix++; ?>
						    							<?php } ?>
						    							<?php mysqli_free_result($result9); ?>
					    							</figcaption>
					    						</figure>
					    						<?php $nbProp++; ?>
				    						<?php } ?>
									    <?php } ?>
									</div>
									<?php if ($nbProp == 0) { ?>
										<p>Aucune proposition pour le moment...</p>
									<?php } else if ($nbProp == $nbPropChoix) { ?>
										<div class="actions center">
											<a href="index.php?page=nouvelle-manche" class="button C3 add">Nouvelle manche</a>
											<a href="index.php?page=fin-partie" class="button CRed">Finir la partie</a>
										</div>
									<?php } else if ($nbProp == $totalConseillers) { ?>
				    					<div class="actions center">
											<a href="index.php?page=choix-proposition-roi" class="button C3">Gouverner le royaume</a>
										</div>
				    				<?php } ?>
			    				</div>
			    			</div>
			    		</div>
	    			<?php } ?>
    			<?php } ?>

    			<div class="box" id="infos">
					<div>
						<?php if ($numpartie == "") { ?>
							<p>Aucune partie en cours.</p>
							<?php if ($ligne4['etat'] == "Terminée") { ?>
								<div class="actions">
									<a href="index.php?page=nouvelle-partie" class="button">Créer une nouvelle partie</a>
								</div>
							<?php } ?>
							<div class="actions">
								<a href="index.php?page=rejoindre-partie" class="button">Rejoindre une partie</a>
							</div>

						<?php } else { ?>
							<?php if ($_GET['partie'] == "nouvelle") { ?>
								<p>La nouvelle partie a bien été créée. Voici le code à partager : <strong><?php echo $numpartie; ?></strong></p>
								<?php include(const_pages . 'participants.php'); ?>
								<div class="actions">
									<a href="index.php?page=lancer-partie" class="button" id="lancer-partie">Lancer la partie</a>
								</div>

							<?php } else if (($_GET['partie'] == "rejointe") AND ($ligne3['etat'] == "En attente")) { ?>
								<p>Vous avez rejoint la partie <strong><?php echo $numpartie; ?></strong>.</p>
								<?php include(const_pages . 'participants.php'); ?>
								<div class="actions">
									<a href="index.php?page=lancer-partie" class="button" id="lancer-partie">Lancer la partie</a>
								</div>

							<?php } else if ($ligne3['etat'] == "En attente") { ?>
								<p>Vous participez à la partie <strong><?php echo $numpartie; ?></strong>.</p>
								<?php include(const_pages . 'participants.php'); ?>
								<div class="actions">
									<a href="index.php?page=lancer-partie" class="button" id="lancer-partie">Lancer la partie</a>
								</div>

							<?php } else if ($ligne3['etat'] == "En cours") { ?>
								<p>La partie <strong><?php echo $numpartie; ?></strong> est en cours.</p>
								<?php include(const_pages . 'participants.php'); ?>

							<?php } else if ($ligne3['etat'] == "Terminée") { ?>
								<p>La partie <strong><?php echo $numpartie; ?></strong> est terminée.</p>	
								<div class="actions">
									<a href="index.php?page=nouvelle-partie" class="button">Créer une nouvelle partie</a>
								</div>
								<div class="actions">
									<a href="index.php?page=rejoindre-partie" class="button">Rejoindre une partie</a>
								</div>

							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>

		<?php } else { ?>
			<p class="center">Vous n'avez pas accès à ce profil</p>
		<?php } ?>


		<?php include(const_incl . 'footer.php'); ?>

	</body>
</html>
