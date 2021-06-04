<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
    	<?php 
    	$link = bdConnexion();

    	$recSQL = "SELECT proposition FROM reigns_joueurs WHERE proposition IS NOT NULL" ;
		$result = mysqli_query($link , $recSQL);

		$donneesForm = array();
    	?>
        <header>
            <?php include(const_incl . 'nav.php'); ?>
            <h1>Gouverner le Royaume</h1>
        </header>

        <section>
            <div class="box">
                <p>Vous devez <strong>accepter</strong> au moins une proposition.</p>
                <form action="" method="post" class="flex center-align">
                	<?php while ($ligne = mysqli_fetch_array($result)) { ?>
                		<?php $donneesForm[] = $ligne['proposition']; ?>
						<div class="flex25 margin-bottom">
							<label for="prop-<?php echo $x; ?>">
    							<img src="./img/proposition/proposition-recto-<?php echo $ligne['proposition']; ?>.jpg">
    						</label>
							<select name="prop-<?php echo $ligne['proposition']; ?>" id="prop-<?php echo $ligne['proposition']; ?>">
							    <option value="Choisie">Accepter</option>
							    <option value="Refusée">Refuser</option>
							</select>		
    					</div>
					<?php } ?>
                	<button type="submit">Valider</button>
                </form>
            </div>
            <p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>#propconseillers">Revenir au profil</a></p> 
        </section>

        <?php
	        if (!empty($_POST)) {
	        	mysqli_free_result($result);
	        	$choixProp = array();
	        	$choix = "";
	        	$nbValueChoisie = 0;
	        	foreach($donneesForm as $valeur) {
	        		$choix = "prop-" . $valeur;
	        		$choixProp[$valeur] = $_POST[$choix];
	        		$nbValueChoisie++;
                }
                if ($nbValueChoisie > 0) {
                	foreach ($choixProp as $cle => $valeur) {
                		$recSQL = 
                        "UPDATE reigns_propositions 
                        SET 
                        resultat = '{$valeur}'
                        WHERE id = {$cle}";
                        $result = mysqli_query($link , $recSQL);
                        $ligne = mysqli_fetch_assoc($result);
                        mysqli_free_result($result);
                        echo "resultat : " . $valeur;
                        echo "<br>";
                        echo "id : " . $cle;
                        echo "<br>";
                        echo "<br>";
                	}
                	mysqli_close($link);
                	header('location:index.php?page=joueur&choix-roi=fait&idjoueur=' . $_SESSION['id']);
                }
                
	        }
        ?>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>		


