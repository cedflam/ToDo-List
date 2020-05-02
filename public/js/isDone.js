const btn = $('.btnIsDone');

btn.on('click', function (e) {


    const id = $(this).data('target');
    const url = "/task/isDone/"+id;

    $('.task'+id).remove();

    axios.get(url)
        .then(response =>{
            Toastify({
                text: "Statut de la tâche modifié !",
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

        })
        .catch(error => {
            console.log(error.response)
            Toastify({
                text: "Une erreur s'est produite !, Merci de recharger la page !",
                duration: 3000,
                destination: "https://github.com/apvarun/toastify-js",
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: 'right', // `left`, `center` or `right`
                backgroundColor: "red",
                stopOnFocus: true, // Prevents dismissing of toast on hover
                onClick: function(){} // Callback after click
            }).showToast();
        });

})

