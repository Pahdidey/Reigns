$(document).ready(function() {


	// Recharge auto des propositions


	/*function rechargeautopropositions(){
        setTimeout( function(){
            var idPart = "";
            $("#propconseillers figure").each(function() {
                idPart += "-" + $(this).attr('id');
            });
            idPart = idPart.substring(1);
            $.ajax({
                url : "index.php",
                data: "page=refresh-propositions&id="+ idPart,
                type : 'GET',
                success : afficherechargepropositions
            });
            rechargeautopropositions();
        }, 5000);
    }

    function afficherechargepropositions(reponse) { 
        $('#propconseillers .flex').append(reponse);
    }

    rechargeautopropositions();*/


    setInterval(function(){
       $("#joueur #propconseillers").load("#joueur #propconseillers .box");
    }, 5000);






  
});



