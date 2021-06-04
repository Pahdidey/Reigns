<?php
    $numpartie = $_SESSION['numpartieReigns'];

    $link = bdConnexion();

    echo "<p><strong>Participants :</strong></p>";

    $recSQL2 = 
    "SELECT 
    jeudistance_joueurs.id AS idJoueur,
    jeudistance_joueurs.nom AS nomJoueur,

    reigns_participants.id AS idParticipant, 
    reigns_participants.id_partie AS idPartieParticipant,
    reigns_participants.id_joueur AS idJoueurParticipant,

    reigns_joueurs.role AS roleJoueur,
    reigns_joueurs.proposition AS propositionJoueur,

    reigns_parties.id AS idPartie,
    reigns_parties.nom AS nomPartie
    
    FROM reigns_participants

    INNER JOIN reigns_parties ON reigns_participants.id_partie = reigns_parties.id
    INNER JOIN reigns_joueurs ON reigns_participants.id_joueur = reigns_joueurs.id
    INNER JOIN jeudistance_joueurs ON reigns_participants.id_joueur = jeudistance_joueurs.id

    WHERE reigns_parties.nom = '{$numpartie}'";

    $result2 = mysqli_query($link , $recSQL2);


    echo "<ul class='styled' id='participants'>";
    while ($ligne2 = mysqli_fetch_array($result2)) {
        if ($ligne2['roleJoueur'] == "Roi") {
            $roleJoueur = "<img src='./img/crown.png' alt='Roi' />";
        } else if ($ligne2['propositionJoueur'] != NULL) {
            $roleJoueur = "<a class='ico visibility' href='index.php?page=propositionroi&carte={$ligne2['propositionJoueur']}' title='Voir la proposition'></a>";
        } else {
            $roleJoueur = "";
        }
        echo "<li id='" . $ligne2['idJoueur'] . "'>" . $ligne2['nomJoueur'] . $roleJoueur;
        if ($ligne2['roleJoueur'] != "Roi") {
            $recSQL3 = "SELECT resultat FROM reigns_propositions WHERE id = {$ligne2['propositionJoueur']}";
            $result3 = mysqli_query($link , $recSQL3);
            $ligne3 = mysqli_fetch_array($result3);
            if ($ligne3['resultat'] == "Choisie") {
                echo '<img src="./img/checked.png" alt="Choisie"/>';
            } elseif ($ligne3['resultat'] == "Refusée") {
                echo '<img src="./img/cancel.png" alt="Refusée"/>';
            }
        }     
        echo "</li>";
        mysqli_free_result($result3);
    }
    echo "</ul>";

    mysqli_free_result($result2);
    mysqli_free_result($result);
    mysqli_close($link);


?>
