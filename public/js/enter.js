$(function() {
    $("form").on("keyup keypress", function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            // e.preventDefault();
            return false;
        }

        $(".bootstrap-tagsinput input").on("input", function(e) {
            $(this).val($(this).val().replace(/,/g, ""));
        });
    });
});
