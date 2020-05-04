//Gère la redirection à la fermeture de la modale
var btnCloseDone = () => {
    $(".editTaskDone").click( () => {
        const url = "/tasks/done"
        $(location).attr("href", url);
    })
}
var btnCloseList = () => {
    $(".editTaskList").click( () => {
        const url = "/tasks"
        $(location).attr("href", url);
    })
}
var btnCloseUser = () => {
    $(".editTaskUser").click( () => {
        const url = "/tasks/user"
        $(location).attr("href", url);
    })
}
var btnCloseCreate = () => {
    $(".createTask").click( () => {
        const url = "/tasks/user"
        $(location).attr("href", url);
    })
}


