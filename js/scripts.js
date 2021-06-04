// Loader
$(window).load(function() {
  $(".loader").fadeOut("1000");
});


$(document).ready(function() {

	// Ouverture du menu

    $("#toggle-button").click(function(){
        $('#toggle-menu').animate({width: 'toggle'}, 500);
        $(this).toggleClass('open');
    });




    // Vérifier nom inscription

    function nomVerifier() { 
		$.ajax({ 
			type: 'POST', 
			url: 'index.php', 
			data: "page=verif-nom&nom="+ $('#nom').val(), 
			dataType: 'text', 
			success: afficherReponse, 
			error: function() {
				alert('Erreur serveur');
			} 
		});
	}

	function afficherReponse(reponse) { 
		var nouveauResultat = reponse; 
		if (nouveauResultat != 0) {
			$('#message').html("Ce pseudo est déjà pris");
			$('#button').attr("disabled",true);
		} 
	}


    $("#nom").keyup(function() {
		nomVerifier();
	});

	$('#button').ajaxStart(function(request, settings) { 
		$(this).attr("disabled",false) 
	}); 

	$('#button').ajaxStop(function(request, settings){ 
		$(this).attr("disabled",true) 
	});



	// Recharge auto des participants


	function rechargeautoparticipants(){
        setTimeout( function(){
            var idPart = "";
            $("#participants li").each(function() {
                idPart += "-" + $(this).attr('id');
            });
            idPart = idPart.substring(1);
            $.ajax({
                url : "index.php",
                data: "page=refresh-participants&id="+ idPart,
                type : 'GET',
                success : afficherechargeparticipants
            });
            rechargeautoparticipants();
        }, 5000);
    }

    function afficherechargeparticipants(reponse) { 
        if ((reponse.indexOf("En cours") != -1)) {
            $("#joueur #partie #infos").load("#joueur #partie #infos div");
        } else {
            $('#participants').append(reponse);
        }
    }

    rechargeautoparticipants();






    // Recharge auto du début de la partie

    function rechargeautodebutpartie(){
        setTimeout( function(){
            $.ajax({
                url : "index.php?page=refresh-debutpartie",
                type : 'GET',
                success : affichrechargedebutpartie
            });
            rechargeautodebutpartie();
        }, 1000);
    }

    var x = 1;

    function affichrechargedebutpartie(reponse) { 
        if ((reponse.indexOf("En cours") != -1) && (x != 0)) {
            x = 0;
            $("#joueur").load("#joueur #partie");
        }
    }

    rechargeautodebutpartie();





    // Recharge auto de la nouvelle manche

    function rechargeautonouvellemanche(){
        setTimeout( function(){
            $.ajax({
                url : "index.php?page=refresh-nouvellemanche",
                type : 'GET',
                success : affichrechargenouvellemanche
            });
            rechargeautonouvellemanche();
        }, 1000);
    }



    var y = 1;

    function affichrechargenouvellemanche(reponse) {
        if ((reponse.indexOf("Nouvelle manche") != -1) && (y != 0)) {
            y = 0;
            console.log('refresh-nouvellemanche');
            $("#joueur").load("#joueur #partie");
        }
    }

    rechargeautonouvellemanche();






    // Recharge auto de la fin de la partie

    function rechargeautofinpartie(){
        setTimeout( function(){
            $.ajax({
                url : "index.php?page=refresh-finpartie",
                type : 'GET',
                success : affichrechargefinpartie
            });
            rechargeautofinpartie();
        }, 5000);
    }


    var z = 1;
    function affichrechargefinpartie(reponse) { 
        if ((reponse.indexOf("Terminée") != -1) && (z != 0)) {
            z = 0;
            window.location.href = "index.php?page=fin-partie-recap";
            //$window.location.replace("index.php?page=fin-partie-recap");
        }
    }

    rechargeautofinpartie();




  
});



