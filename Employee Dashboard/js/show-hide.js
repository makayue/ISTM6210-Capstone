$(document).ready(function() {
    $("#myform").submit(function(e) {
        $("#first").hide();
        $("#after-hide").hide();
        $("#second").show();
        $("#after-show").show();
    });
});
