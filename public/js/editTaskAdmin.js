//Affiche des messages flash
const toast =  (text, color) => {
    Toastify({
        text: text,
        duration: 3000,
        destination: "https://github.com/apvarun/toastify-js",
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: 'right', // `left`, `center` or `right`
        backgroundColor: color,
        stopOnFocus: true, // Prevents dismissing of toast on hover
        onClick: function () {
        } // Callback after click
    }).showToast();
}

/**
 * Permet d'éditer une tâche
 */
const btnEdit = $('.btnEdit');
btnEdit.on('click', function (e) {
    e.preventDefault();
    const id = $(this).data('target');
    const url = "/task/edit/" + id;

    const title = $('.title'+id).val()
    const content = $('.content'+id).val()


    const task = {
        title: title,
        content:content
    }

    const errors = {
        title: "",
        content: ""
    }
    console.log(title, content)



    axios.post(url, task).then(response => {
        console.log('ok');
        toast("Vous pouvez fermer la fenêtre", "blue")
        toast(
            "la tâche " + task.title + " a été modifiée !",
            "linear-gradient(to right, #00b09b, #96c93d)"
        )
    })
        .catch(error => {
            if (error.response.data) {
                const apiErrors = {};
                error.response.data.violations.forEach(violation => {
                    apiErrors[violation.propertyPath] = violation.title;
                });
                errors.title = apiErrors.title;
                errors.content = apiErrors.content;

                if(errors.title){
                    toast(errors.title, "red");
                }else if(errors.content){
                    toast(errors.content, "red");
                }else{
                    toast(errors.title, "red");
                    toast(errors.content, "red");
                }
            }
        })
        .finally(close => {
            btnCloseDone();
            btnCloseList();
            btnCloseUser();

        })

    console.log("task = "+task.title, task.content)
    console.log("errors = "+errors.title, errors.content)
    console.log("url = "+url);
})
