window.activateTask = activateTask;
function activateTask(id, userId) {
    $.ajax({
        url: "/activateTask/"+id+'/'+userId,
        type: "post",
        data: { id: id },
        success: function(response) {
            console.log('activated');
        }
    });
}


window.deactivateTask = deactivateTask;
function deactivateTask(id, userId) {
    $.ajax({
        url: "/deactivateTask/"+id+'/'+userId,
        type: "post",
        data: { id: id },
        success: function(response) {
            console.log('deactivated');
        }
    })
}