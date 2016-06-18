$(document).ready(function (){
    $('#new_model_form').submit(function () {
        $.post(token+"_/new_model",$('#new_model_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#new_models_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#new_models_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#new_models_alert_failed" ).slideToggle( "slow" );}
        }); return false;
    });
});