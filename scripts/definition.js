$(document).ready(function() {
    $('body').on('click', '.termLink', function(e) {
        $.ajax({
            url     : settings.system.baseUrl + 'definition/ajax/' + $(this).data('term'),
            dataType: 'html',
            data    : {}
        }).done(function (data) {
            $('.cardArea').append(data)
        })
    })
})