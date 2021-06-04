<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
        <header>
            <h1>Proposition</h1>
        </header>

        <section>
            <div class="propositionroi">
                <figure>
                    <img src="./img/proposition/proposition-recto-<?php echo $_GET['carte']; ?>.jpg">
                </figure>
            </div>
            <p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>#infos">Revenir au profil</a></p>         
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>