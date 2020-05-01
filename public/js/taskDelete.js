const btnDelete = $('.btnDelete');

btnDelete.on('click', function () {
    Toastify({
        text: "Tâche supprimée",
        duration: 3000,
        destination: "https://github.com/apvarun/toastify-js",
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: 'right', // `left`, `center` or `right`
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        stopOnFocus: true, // Prevents dismissing of toast on hover
        onClick: function(){} // Callback after click
    }).showToast();

    const id = $(this).data('target');
    const url = "/task/delete/"+id;

    $('.task'+id).remove();

    axios.delete(url)
        .then(response =>{ console.log(response.data)  })
        .catch(error => console.log(error.response));
})