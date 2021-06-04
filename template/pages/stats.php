<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
        <header>
            <?php include(const_incl . 'nav.php'); ?>
            <h1>Statistiques</h1>
        </header>

        <section>
            <div class="box">
                <p>A venir</p>
                <div class="actions">
                    <a href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>" class="button close">Revenir au profil</a>
                </div>
            </div>
        </section>

        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>