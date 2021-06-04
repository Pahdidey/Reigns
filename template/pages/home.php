<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body id="home">
        <header>
            <h1>Reigns</h1>
        </header>

        <section>

            <div class="box">
                <?php
                    if (isset($_SESSION['id'])) {
                        header('location:index.php?page=joueur&idjoueur=' . $_SESSION['id']);
                    } else {
                ?>

                    <h2>Se connecter</h2>

                    <form action="" method="POST">

                        <div>
                            <label for='nom'>Pseudo</label>
                            <input type='text' name='nom' id='nom' required placeholder="Pseudo" />
                        </div>

                        <div>
                            <label for='mdp'>Mot de passe</label>
                            <input type='password' name='mdp' id='mdp' required placeholder="Mot de passe"/>
                        </div>

                        <button type="submit">Se connecter</button>

                    </form>

                    <p><a href="index.php?page=inscription">Pas encore inscrit ?</a></p>

                    <?php
                        $nom = $_POST['nom'];
                        $mdp = sha1($_POST['mdp']);

                        if (!empty($_POST)) {

                            if ( (!empty($nom)) AND (!empty($mdp)) ) {

                                $link = bdConnexion();

                                $recSQL = "SELECT * FROM jeudistance_joueurs WHERE nom = '{$nom}' AND mdp = '{$mdp}'";

                                $result = mysqli_query($link , $recSQL);
                                $row_cnt = mysqli_num_rows($result);
                                $ligne = mysqli_fetch_array($result);

                                echo $row_cnt;

                                if( $row_cnt == 1 ) {
                                    $_SESSION['id'] = $ligne['id'];
                                    $_SESSION['nom'] = $ligne['nom'];

                                    mysqli_free_result($result);
                                    mysqli_close($link);

                                    header("Location: index.php?page=joueur&idjoueur={$_SESSION['id']}");
                                } else {
                                    echo "ERREUR";
                                }

                            } else {
                                echo "ERREUR";
                            }
                        }               

                    ?>

                <?php } ?>
            </div>
            
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>