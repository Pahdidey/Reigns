<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
        <header>
            <h1>Votre proposition</h1>
        </header>

        <section>
            <div class="box">
                <div class="flex proposition">
                    <figure class="flex50">
                        <img src="./img/proposition/proposition-recto-<?php echo $_GET['carte']; ?>.jpg">
                        <figcaption>Recto</figcaption>
                    </figure>
                    <figure class="flex50">
                        <img src="./img/proposition/proposition-verso-<?php echo $_GET['carte']; ?>.jpg">
                        <figcaption>Verso</figcaption>
                    </figure>
                </div>
            </div>
            <p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>#propositions">Revenir au profil</a></p>         
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>