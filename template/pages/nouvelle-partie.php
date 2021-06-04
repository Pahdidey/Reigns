<?php
	$link = bdConnexion();

	$recSQL = "SELECT * FROM reigns_parties ORDER BY ID DESC LIMIT 1";

	$result = mysqli_query($link , $recSQL);
	$ligne = mysqli_fetch_array($result);

	if ($ligne['etat'] == "Terminée") {

		$chaine = 'abcdefghijklmnopqrstuvwxyz';
        $chaine .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';	
		$chaine .= '1234567890'; 
		$code = ''; 

		for ($i=0; $i < 5; $i++) { 
			$code .= substr($chaine,rand()%(strlen($chaine)),1); 
		}

		$recSQL2 = "INSERT INTO reigns_parties (nom, etat) VALUES ('{$code}', 'En attente')";

        $result2 = mysqli_query($link , $recSQL2);
        $nbInsert = mysqli_affected_rows($link);

        if ($nbInsert == 1) {
            echo "<p>La partie a bien été créée</p>";
            $_SESSION['numpartieReigns'] = $code;
          
        	$recSQL3 = "SELECT id FROM reigns_parties ORDER BY ID DESC LIMIT 1";
			$result3 = mysqli_query($link , $recSQL3);
			$ligne3 = mysqli_fetch_array($result3);

			$recSQL4 = "INSERT INTO reigns_participants (id_partie, id_joueur) VALUES ('{$ligne3['id']}', '{$_SESSION['id']}')";

	        $result4 = mysqli_query($link , $recSQL4);
	        $nbInsert4 = mysqli_affected_rows($link);

	        $recSQL5 = "UPDATE reigns_joueurs SET role = 'Conseiller'";
            $result5 = mysqli_query($link , $recSQL5);

	        if ($nbInsert4 == 1) {
	            echo "<p>Le joueur a bien été ajouté à la nouvelle partie</p>";
	            header('location:index.php?page=joueur&partie=nouvelle&idjoueur=' . $_SESSION['id']);
	        } else {
	            echo "<p>Echec de l'ajout du joueur à la nouvelle partie'</p>";
	        }
        } else {
            echo "<p>Echec de la création</p>";
        }

        mysqli_free_result($result2);
        mysqli_free_result($result3);
        mysqli_free_result($result4);
        mysqli_free_result($result5);

	}

	mysqli_free_result($result);
    mysqli_close($link);
?>