var url = ajax_var.url;
var nonce = ajax_var.nonce;

jQuery(document).ready(function($) {
    $("form#form_entreprise").submit(function(event) {
        event.preventDefault();

        $.ajax({
        	url: ajax_var.url+'?action=inscription_entreprise',
            type: "POST",
            
            data: $("form#form_entreprise").serialize(),
            success: function(response){$("form#form_entreprise").after(response);}
        });
    });
});