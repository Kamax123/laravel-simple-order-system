$(document).ready(function () {
    if($('#invoice_by_email').val() !== '1') {
        $("#email").hide();
        $('label[for="email"]').hide();
    }
    $('#invoice_by_email').on('change', function () {
        if ($(this).val() === "1") {
            $('label[for="email"]').show();
            $("#email").show();
            $("#email").attr("required", true);
        } else {
            $("#email").hide();
            $('label[for="email"]').hide();
        }
    });
})