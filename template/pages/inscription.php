<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body id="home">
        <header>
            <h1>Reigns</h1>
        </header>

        <section>

            <div class="box">
               
                <h2>S'inscrire</h2>

                <form action="" method="POST">

                    <div>
                        <label for='nom'>Pseudo</label>
                        <input type='text' name='nom' id='nom' required placeholder="Pseudo" />
                        <p id="message" class="error"></p>
                    </div>

                    <div>
                        <label for='mdp'>Mot de passe</label>
                        <input type='password' name='mdp' id='mdp' required placeholder="Mot de passe" />
                    </div>

                    <button type="submit" id="button">S'inscrire</button>

                </form>

                <p><a href="index.php?page=home">Déjà inscrit ?</a></p>

                <?php
                    $nom = $_POST['nom'];
                    $mdp = sha1($_POST['mdp']);

                    if (!empty($_POST)) {
                        if ( (!empty($nom)) AND (!empty($mdp)) ) {
                            $link = bdConnexion();

                            $recSQL = "INSERT INTO jeudistance_joueurs (nom, mdp) VALUES ('{$nom}', '{$mdp}')";

                            $result = mysqli_query($link , $recSQL);
                            $nbInsert = mysqli_affected_rows($link);

                            if ($nbInsert == 1) {
                                $recSQL2 = "SELECT id FROM jeudistance_joueurs WHERE nom = '{$nom}'";
                                $result2 = mysqli_query($link , $recSQL2);
                                $ligne2 = mysqli_fetch_array($result2);

                                $idNouveauJoueur = $ligne2['id'];

                                $recSQL3 = "INSERT INTO motmalin_joueurs (id, main) VALUES ('{$idNouveauJoueur}', '26')";
                                $result3 = mysqli_query($link , $recSQL3); 
                                $nbInsert3 = mysqli_affected_rows($link);

                                $recSQL4 = "INSERT INTO reigns_joueurs (id, role) VALUES ('{$idNouveauJoueur}', 'Conseiller')";
                                $result4 = mysqli_query($link , $recSQL4);    
                                $nbInsert4 = mysqli_affected_rows($link);


                                if (($nbInsert3 == 1) AND ($nbInsert4 == 1)) {
                                    echo "<p class='center colorcwh'>Tout a bien été ajouté.</p>";
                                    echo "<p class='center'><a class='colorcwh more' href='index.php?page=home'>Se connecter</a></p>";
                                }
                            } else {
                                echo "<p class='center colorcwh'>Echec de l'inscription, veuillez recommencer.</p>";
                            } 

                            mysqli_free_result($result);
                            mysqli_free_result($result2);
                            mysqli_free_result($result3);
                            mysqli_close($link);
                        }
                    }
                ?>
         
            </div>
            
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>