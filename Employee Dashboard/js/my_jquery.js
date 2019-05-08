$(function() {
    $('#reportOptions').hide();
    $('#typeOption').change(function(){
        if($('#typeOption').val() == 'newReport') {
            $('#reportOptions').show();
        } else {
            $('#reportOptions').hide();
        }
    });
});
