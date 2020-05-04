const btnDelete = $(".btnDelete");

btnDelete.on('click', function () {

    const id = $(this).data('target');
    const url = "/tasks/delete/" + id;

    $(".task" + id).remove();

    axios.delete(url)
        .then(response => {
            toast("Tâche supprimée", "linear-gradient(to right, #00b09b, #96c93d)");
        })
        .catch(error => toast("Une erreur s'est produite", "red"));
})

