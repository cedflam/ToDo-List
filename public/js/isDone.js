const btn = $('.btnIsDone');

btn.on('click', function () {

    const id = $(this).data('target');
    const url = "/task/isDone/"+id;

    $('.task'+id).remove();

    axios.get(url)
        .then(response =>{
            toast("Statut de la tâche modifié !","linear-gradient(to right, #00b09b, #96c93d)" )

        })
        .catch(error => {
            console.log(error.response)
            toast("Statut de la tâche modifié !", "red")
        });
})

