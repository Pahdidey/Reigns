<?php
    header("Content-Type: text/plain"); 
    header("Cache-Control: no-cache , private"); 
    header("Pragma: no-cache");

    if (isset($_REQUEST['nom'])) {
        $nom = $_REQUEST['nom'];

        $link = bdConnexion();

        $recSQL = "SELECT id FROM jeudistance_joueurs WHERE nom = '{$nom}'";

        $result = mysqli_query($link , $recSQL);
        $ligne = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {
            $id = $ligne['id'];
        } else {
            $id = 0;
        }
        echo $id;
    } else {
        $nom = "inconnu";
    }
?>