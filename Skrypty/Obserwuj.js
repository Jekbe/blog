function obserwuj(id, value){
    $.ajax({
        url: '../Profile/Obserwuj.php',
        type: 'GET',
        data: {
            id: id,
            value: value
        },
        success(response) {
            const $selector = $('#obserwuj');
            if (value === 1) {
                $selector.text('Przestań obserwować')
                $selector.attr('onclick', 'obserwuj(' + id + ', 0)')
            } else {
                $selector.text('Obserwuj')
                $selector.attr('onclick', 'obserwuj(' + id + ', 1)')
            }
        },
        error() {
            alert('Wystąpił błąd. Spróbuj ponownie.');
        }
    })
}