$(document).ready(function (){

    
    /*
     * NEW MODEL
     */
    $('#new_model_form').submit(function () {
        $.post("../"+token+"_/new_model",$('#new_model_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#new_models_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#new_models_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#new_models_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });



    /*
     * NEW VIEW
     */
    $('#new_view_form').submit(function () {
        $.post("../"+token+"_/new_view",$('#new_view_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#new_view_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#new_view_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#new_view_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });
});