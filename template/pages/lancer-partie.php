<!DOCTYPE html>
<html lang="fr">
    <?php include(const_incl . 'head.php'); ?>
        
    <body>
        <header>
            <?php include(const_incl . 'nav.php'); ?>
            <h1>Lancer la partie</h1>
        </header>

        <section>

            <?php
            	$numpartie = $_SESSION['numpartieReigns'];
            	
            	$link = bdConnexion();
                        
                $recSQL = 
                "SELECT 
                jeudistance_joueurs.id AS idJoueur,
                jeudistance_joueurs.nom AS nomJoueur,

                reigns_participants.id AS idParticipant, 
                reigns_participants.id_partie AS idPartieParticipant,
                reigns_participants.id_joueur AS idJoueurParticipant,

                reigns_parties.id AS idPartie,
                reigns_parties.nom AS nomPartie,
                reigns_parties.etat AS etatPartie
                
                FROM reigns_participants

                INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
                INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

                WHERE reigns_parties.nom = '{$numpartie}'";

                $result = mysqli_query($link , $recSQL);
            ?>

            <div class="box">


                <form action="" method="POST">

                    <div>
                        <label for='choixroi'>Choisir un Roi</label>
                        <select name="choixroi" id="choixroi">
                            <?php
                            while ($ligne = mysqli_fetch_array($result)) {
                                echo "<option value='" . $ligne['idJoueur'] . "'>" . $ligne['nomJoueur'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" id="button">Valider</button>

                </form>


                <?php
                    $recSQL2 = "SELECT id, etat FROM reigns_parties WHERE nom = '{$numpartie}'";

                    $result2 = mysqli_query($link , $recSQL2);
                    $ligne2 = mysqli_fetch_array($result2);

                    if ($ligne2['etat'] == "En attente") {
                        $idRoi = $_POST['choixroi'];

                        if (!empty($_POST)) {
                            if (!empty($idRoi)) {
                                $recSQL3 = "UPDATE reigns_joueurs SET role = 'Roi' WHERE id = {$idRoi}";
                                $result3 = mysqli_query($link , $recSQL3);

                                $recSQL4 = "UPDATE reigns_parties SET etat = 'En cours' WHERE id = {$ligne2['id']}";
                                $result4 = mysqli_query($link , $recSQL4);


                                $recSQL5 = 
                                "SELECT 
                                COUNT(*) AS total
                                FROM 
                                reigns_participants 
                                INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
                                INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
                                WHERE reigns_parties.nom = '{$numpartie}' AND reigns_joueurs.role != 'Roi'";
                                $result5 = mysqli_query($link , $recSQL5);
                                $ligne5 = mysqli_fetch_array($result5);


                                $recSQL6 = "SELECT COUNT(*) AS total FROM reigns_objectifs";
                                $result6 = mysqli_query($link , $recSQL6);
                                $ligne6 = mysqli_fetch_array($result6);

                                $recSQL7 = 
                                "SELECT 
                                reigns_participants.id_joueur AS idParticipant
                                FROM 
                                reigns_participants 
                                INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
                                INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
                                WHERE reigns_parties.nom = '{$numpartie}' AND reigns_joueurs.role != 'Roi'";
                                $result7 = mysqli_query($link , $recSQL7);
                                $joueursPartie = array();
                                while ($ligne7 = mysqli_fetch_array($result7)) {
                                    $joueursPartie[] = $ligne7['idParticipant'];
                                }

                                $nbTotalParticipants = $ligne5['total'];
                                $max = $ligne6['total'];
                                $objectifsJoueurs = array();
                                while($nbTotalParticipants != 0) {
                                  $nbAuHasard = mt_rand(1, $max);
                                  if(!in_array($nbAuHasard, $objectifsJoueurs)) {
                                    $objectifsJoueurs[] = $nbAuHasard;
                                    $nbTotalParticipants--;
                                  }
                                }

                                $x = 0;

                                mysqli_free_result($result);

                                foreach($joueursPartie as $valeur) {
                                    $recSQL = 
                                    "UPDATE reigns_joueurs 
                                    SET 
                                    objectif = {$objectifsJoueurs[$x]}
                                    WHERE id = {$joueursPartie[$x]}";
                                    $result = mysqli_query($link , $recSQL);
                                    $ligne = mysqli_fetch_assoc($result);
                                    mysqli_free_result($result);
                                    $x++;
                                }

                                $recSQL8 = 
                                "SELECT 
                                COUNT(*) AS total
                                FROM 
                                reigns_participants 
                                INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
                                INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
                                WHERE reigns_parties.nom = '{$numpartie}' AND reigns_joueurs.role != 'Roi'";
                                $result8 = mysqli_query($link , $recSQL8);
                                $ligne8 = mysqli_fetch_array($result8);


                                $recSQL9 = "SELECT COUNT(*) AS total FROM reigns_propositions";
                                $result9 = mysqli_query($link , $recSQL9);
                                $ligne9 = mysqli_fetch_array($result9);


                                $recSQL10 = 
                                "SELECT 
                                reigns_participants.id_joueur AS idParticipant
                                FROM 
                                reigns_participants 
                                INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
                                INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
                                WHERE reigns_parties.nom = '{$numpartie}' AND reigns_joueurs.role != 'Roi'";
                                $result10 = mysqli_query($link , $recSQL10);
                                $joueursPartie = array();
                                while ($ligne10 = mysqli_fetch_array($result10)) {
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                    $joueursPartie[] = $ligne10['idParticipant'];
                                }

                                $nbTotalParticipants = $ligne8['total'] * 7;
                                $max = $ligne9['total'];
                                $propositionJoueurs = array();
                                while($nbTotalParticipants != 0) {
                                  $nbAuHasard = mt_rand(1, $max);
                                  if(!in_array($nbAuHasard, $propositionJoueurs)) {
                                    $propositionJoueurs[] = $nbAuHasard;
                                    $nbTotalParticipants--;
                                  }
                                }

                                $y = 0;

                                mysqli_free_result($result);

                                foreach($joueursPartie as $valeur) {
                                    $recSQL = 
                                    "UPDATE reigns_propositions 
                                    SET 
                                    id_joueur = {$joueursPartie[$y]}
                                    WHERE id = {$propositionJoueurs[$y]}";
                                    $result = mysqli_query($link , $recSQL);
                                    $ligne = mysqli_fetch_assoc($result);
                                    mysqli_free_result($result);
                                    $y++;
                                }
      
                                mysqli_free_result($result2);
                                mysqli_free_result($result3);
                                mysqli_free_result($result4);
                                mysqli_free_result($result5);
                                mysqli_free_result($result6);
                                mysqli_free_result($result7);
                                mysqli_free_result($result8);

                                mysqli_close($link);

                                header('location:index.php?page=joueur&partie=lancee&idjoueur=' . $_SESSION['id']);
                            }
                        }
                    } else if ($ligne2['etat'] == "En cours") {
                        echo "<p>La partie est déjà en cours</p>";
                    } else if ($ligne2['etat'] == "Terminée") {
                        echo "<p>La partie est terminée</p>";
                    } else {
                        echo "<p>Erreur</p>";
                    }

                    mysqli_free_result($result);
                    mysqli_close($link);
                ?>
                
            </div>

            <p class="center"><a class="back" href="index.php?page=joueur&idjoueur=<?php echo $_SESSION['id']; ?>">Revenir au profil</a></p>

        </section>

        
        <?php include(const_incl . 'footer.php'); ?>

    </body>
</html>