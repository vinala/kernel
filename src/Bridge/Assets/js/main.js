$( document ).ready(function() {
	$('#input_form').submit(function () {
		command = document.getElementById('input').value;
        $.post("bridge_ajax",$('#input_form').serialize(),function(data)
            {
            	document.getElementById('input').value = "";
            	$( "<div class='output'>"+data+"</div>" ).insertAfter( "#output_begins" );
            });
        //
        return false;
    });
});