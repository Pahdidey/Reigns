<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
    	
    <body>
    	<header>
    		<?php include(const_incl . 'nav.php'); ?>
            <h1>Rejoindre une partie</h1>
        </header>

		<section>

			<div class="box">

				<form action="" method="post">
					<div>
				        <label for="nom-partie"><strong>Identifiant de la partie</strong></label>
				        <input type="text" id="nom-partie" name="nom-partie" required>
				    </div>

				    <button type="submit">Valider</button>
				</form>

				<?php
		            $nom = $_POST['nom-partie'];

		            if (!empty($_POST)) {
		                if (!empty($nom)) {

		                	$link = bdConnexion();

							$recSQL = "SELECT id, nom FROM reigns_parties";
							$result = mysqli_query($link , $recSQL);

							while ($ligne = mysqli_fetch_array($result)) {
								if ($ligne['nom'] == $nom) {

									$recSQL2 = "INSERT INTO reigns_participants (id_partie, id_joueur) VALUES ('{$ligne['id']}', '{$_SESSION['id']}')";

				                    $result2 = mysqli_query($link , $recSQL2);
				                    $nbInsert = mysqli_affected_rows($link);

				                    if ($nbInsert == 1) {
				                        echo "<p>Le joueur a bien été ajouté à la nouvelle partie</p>";
				                        $_SESSION['numpartieReigns'] = $nom;
	            						header('location:index.php?page=joueur&partie=rejointe&idjoueur=' . $_SESSION['id']);
				                    } else {
				                        echo "<p>Echec de l'ajout du joueur à la nouvelle partie</p>";
				                    } 

				                    mysqli_free_result($result2);

								}
							}

							mysqli_free_result($result);
				            mysqli_close($link);
		                }
		            }
		        ?>

			</div>

			<p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>">Revenir au profil</a></p>

		</section>

		
		<?php include(const_incl . 'footer.php'); ?>

	</body>
</html>