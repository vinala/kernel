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


    /*
     * NEW CONTROLLER
     */
    $('#new_controller_form').submit(function () {
        $.post("../"+token+"_/new_controller",$('#new_controller_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#new_controller_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#new_controller_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#new_controller_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });


    /*
     * NEW SCHEMA
     */
    $('#new_schema_form').submit(function () {
        $.post("../"+token+"_/new_schema",$('#new_schema_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#new_schema_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#new_schema_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#new_schema_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });

    /*
     * EXEC SCHEMA
     */
    $('#exec_schema_form').submit(function () {
        $.post("../"+token+"_/exec_schema",$('#exec_schema_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#exec_schema_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#exec_schema_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#exec_schema_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });

    /*
     * ROLLBACK SCHEMA
     */
    $('#rollback_schema_form').submit(function () {
        $.post("../"+token+"_/rollback_schema",$('#rollback_schema_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#rollback_schema_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#rollback_schema_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#rollback_schema_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });

    /*
     * MAKE BACKUP
     */
    $('#make_backup_form').submit(function () {
        $.post("../"+token+"_/make_backup",$('#make_backup_form').serialize(),function(data)
            {
                if(data == "true")
                {
                    $( "#make_backup_alert_succes" ).slideToggle( "slow" );
                    setTimeout(function(){ $( "#make_backup_alert_succes" ).slideToggle( "slow" ); }, 3000);
                }
                else $( "#make_backup_alert_failed" ).slideToggle( "slow" );
            });
        //
        return false;
    });
});