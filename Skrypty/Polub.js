function polub(id, value){
    $.ajax({
        url: '../Polub.php',
        type: 'GET',
        data: {
            id: id,
            value: value
        },
        success(response){
            const $selector = $('#polubienie')
            if (value === 1){
                $selector.text('Nie lubię');
                $selector.attr('onclick', 'polub(' + id + ', 0)')
            } else {
                $selector.text('Lubię to');
                $selector.attr('onclick', 'polub(' + id + ', 1)')
            }
        },
        error(){
            alert('Wystąpił błąd. Spróbuj ponownie.')
        }
    })
}