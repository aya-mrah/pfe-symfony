$(document).ready(function(){

    $("#xx").hide();

    $("#projet_statut").change(function () {
        $("#projet_statut option:selected").each(function () {
            if(($(this).val()=="travaille")||($(this).val()=="fin")){
                $("#xx").show();
            }
            else {

                $("#xx").hide();

            };
        })
    });

});