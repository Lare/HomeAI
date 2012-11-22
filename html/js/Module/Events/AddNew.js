$(document).ready(function() {
    jq("#EventForm").validate({
        errorElement: "div",
        rules: {
            Title: "required",
            Date: "required"
        },
        messages: {
            Title: "Syötä otsikko",
            Date: "Valitse päivämäärä"
        },
        errorPlacement: function(error, element) {
            element.closest('.row').find(".message").toggle();
            error.appendTo(element.closest('.row').find(".message"));
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});