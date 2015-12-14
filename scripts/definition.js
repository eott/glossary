$(document).ready(function() {
    $('.termLink').on('click', function(e) {
        $.ajax({
            url     : 'http://192.168.7.58/glossary/definition/ajax/' + $(this).data('term'),
            dataType: 'html',
            data    : {}
        }).done(function (data) {
            $('.cardArea').append(data)
        })
    })
})