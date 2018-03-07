window.logoutUser = logoutUser;
function logoutUser() {
    $.ajax({
        url: "/logoutUser",
        type: "post",
        success: function(response) {
            if(response == 1) {
                window.location.href = '/';
            } else if(response == 0) {
                alert('Error.');
            }
        }
    })
}