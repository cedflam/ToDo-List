$('document').ready(function () {
    /**
     * Permet de faire une recherche instantanée
     */
    $('input[name=search]').bind('keyup', function () {
        let val = $(this).val().toLowerCase();
        let table = $('table tbody tr');
        table.hide();
        table.each(function () {
            let text = $(this).text().toLowerCase();
            if (text.indexOf(val) !== -1) {
                $(this).show();
            }
        })
    });
});