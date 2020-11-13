import $ from "jquery";

$(document).ready(function() {
    $(".btn-envoyer").click(function(e){
        e.preventDefault();
        $(".text-danger").remove();
        let form = $("#form-contact")
        let dataform = $(form).serializeArray();
        let url = $(form).attr('action');
        let messageSuccess =  $("<div class=\"message-success\">\n" +
            "            <span>\n" +
            "                <i class=\"fas fa-check-circle\"></i> Votre message a bien été envoyé\n" +
            "            </span>\n" +
            "        </div>");
        $.ajax({
            url: url,
            type : 'POST',
            data: dataform,
            dataType: 'json',
            success: function(data,statut) {
                if(data.response) {
                    $("#contact").prepend(messageSuccess);
                    $(form)[0].reset();
                }
            },
            error: function(data, statut) {
                let errors = data.responseJSON.errors;

                for (const field in errors) {
                    let message = errors[field];
                    $("[data-name='" + field + "']").after("<div class=\"text-danger pl-3 mt-2\"><i class=\"fas fa-exclamation-circle mr-2\"></i>"+ message +"</div>\n")
                };
            }
        })
        $(messageSuccess).delay(5000).fadeOut("slow");
    })
});