//Gère la redirection à la fermeture de la modale
const btnCloseDone = () => {
    $('.editTaskDone').click( () => {
        const url = "/tasks/done"
        $(location).attr("href", url);
    })
}
const btnCloseList = () => {
    $('.editTaskList').click( () => {
        const url = "/tasks"
        $(location).attr("href", url);
    })
}
const btnCloseUser = () => {
    $('.editTaskUser').click( () => {
        const url = "/tasks/user"
        $(location).attr("href", url);
    })
}
const btnCloseCreate = () => {
    $('.createTask').click( () => {
        const url = "/tasks/user"
        $(location).attr("href", url);
    })
}

