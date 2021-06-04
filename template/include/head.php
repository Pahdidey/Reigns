<head>
    <meta charset="utf-8">
    <title>Reigns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0"/>

    <!-- <link rel="icon" type="image/png" href="./img/favicon.png" /> -->

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="./../css/reset.css">
	<link rel="stylesheet" href="./css/styles.css<?php echo "?".rand();?>">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="./js/scripts.js"></script>

	<?php 
		$link = bdConnexion();
		$recSQL = "SELECT role FROM reigns_joueurs WHERE id = {$_SESSION['id']}";
        $result = mysqli_query($link , $recSQL);
        $ligne = mysqli_fetch_array($result);
        if ($ligne['role'] == "Roi") {
	?>
	<script type="text/javascript" src="./js/scripts-roi.js"></script>

	<?php } ?>
</head>

  
    
    



   
