$( document ).ready(function() {


	var Timer1;
	var Timer2;
    var Timer4;
    
    //
    Timer0 = setInterval(function(){ fade1() }, 200);
	Timer1 = setInterval(function(){ fade_() }, 400);
    //
    function fade_ () 
    {
        $( "#content" ).fadeTo( "slow", 1 );
        clearInterval(Timer1);
    }

	function fade1 () 
    {
        $({blurRadius: 0}).animate({blurRadius: 5}, {
            duration: 600,
            easing: 'linear', // "swing"
            //
            step: function() {
                $('#bg').css({
                    "-webkit-filter": "blur("+this.blurRadius+"px)",
                    "filter": "blur("+this.blurRadius+"px)"
                });
            }
        });
        clearInterval(Timer0);
	}

	function fade2 () 
	{
		$( "#bottom_panel" ).fadeTo( "slow", 1 );
        $( "#bottom_panel_2" ).fadeTo( "slow", 1 );
		clearInterval(Timer2);
	}

	function fade3 () 
	{
		$( "#hello_logo" ).fadeTo( "slow", 1 );
		clearInterval(Timer3);
	}

    function fade4 () 
    {
        $( "#welcom" ).fadeTo( "slow", 1 );
        clearInterval(Timer4);
    }

    $('#fst-config-msg-form').submit(function () {
        $( "#fst_db_msg_step" ).fadeOut( 300, function(){ $( "#fst_db_conf_step" ).fadeIn( 300 ); } );
        return false;
    });

	$('#fst-config-db-form').submit(function () {
        $.post('hello/db_check',$('#fst-config-db-form').serialize(),function(data)
            {
                if(data=="true")
                {
                    $( "#fst_db_conf_step" ).fadeOut( 300, function(){ $( "#fst_pass_msg_step" ).fadeIn( 300 ); } );
                }
                else $( "#fst_db_config_error" ).slideDown();
            });
        //
        return false;
    });

    $('#nxt_to_glob').click(function () {
        $( "#fst_pass_msg_step" ).fadeOut( 300, function(){ $( "#fst_glob_conf_step" ).fadeIn( 300 ); } );
        //
        return false;
    });

    $('#fst-glob-db-form').submit(function () {
        $.post('hello/set_glob',$('#fst-glob-db-form').serialize(),function(data)
            {
                if(data=="true")
                {
                    document.getElementById('dev_nom').innerHTML=document.getElementById('dev_name').value;

                    $( "#fst_glob_conf_step" ).fadeOut( 300, function(){ $( "#fst_sec_conf_step" ).fadeIn( 300 ); } );
                }
                else alert('Un erreur est survenue');
            });
        //
        return false;
    });

    $('#fst-sec-db-form').submit(function () {
        $.post('hello/set_secur',$('#fst-sec-db-form').serialize(),function(data)
            {
                if(data=="true")
                {
                    $( "#fst_sec_conf_step" ).fadeOut( 300, function(){ $( "#fst_pnl_conf_step" ).fadeIn( 300 ); } );
                }
                else alert('Un erreur est survenue');
            });
        //
        return false;
    });

    $('#fst-pnl-db-form').submit(function () {
        $.post('hello/set_panel',$('#fst-pnl-db-form').serialize(),function(data)
            {
                if(data=="true")
                {
                    if(document.getElementById('pnl_route').value!="")
                       document.getElementById('fst_panel').href=document.getElementById('pnl_route').value;
                    else  document.getElementById('fst_panel').href="fiesta";
                    //
                    $( "#fst_config_icon" ).fadeOut( 300);
                    $( "#fst_pnl_conf_step" ).fadeOut( 300, function(){ 
                        Timer3 = setInterval(function(){ fade3() }, 200);
                        Timer4 = setInterval(function(){ fade4() }, 400);
                        Timer2 = setInterval(function(){ fade2() }, 800);
                     } );
                }
                else alert('Un erreur est survenue');
            });
        //
        return false;
    });
});
