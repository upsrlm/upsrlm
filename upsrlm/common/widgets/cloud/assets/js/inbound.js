var lastTimeID = 0;
var user_id = 0;
var check_call_url = 0;
var redirect_url = 0;
$(document).ready(function () {
    startCall();
});

function startCall() {
    setInterval(function () {
        getInboundcall();
    }, 2500);
}

function getInboundcall() {
    user_id = $('#user_id').val();
    check_call_url = $('#check_call_url').val();
    redirect_url = $('#redirect_url').val();
    $.ajax({
        type: "GET",
        url: check_call_url,
        async: false,
    }).done(function (data)
    {
        if (data.success == true) {
            window.location.href = redirect_url+data.log_id;
        }
    });
}

