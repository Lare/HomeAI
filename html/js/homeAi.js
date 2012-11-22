setInterval(function() {
    var d = new Date();

    var t = d.getHours() < 10 ? "0"+ d.getHours() : d.getHours();
    var m = d.getMinutes() < 10 ? "0"+ d.getMinutes() : d.getMinutes();
    var p = d.getDate() < 10 ? "0"+ d.getDate() : d.getDate();
    var k = (d.getMonth() + 1) < 10 ? "0"+ (d.getMonth() + 1) : (d.getMonth() + 1);
    var y = d.getFullYear();

    var dNames = new Array("Su", "Ma", "Ti", "Ke", "To", "Pe", "La");
    var string = dNames[d.getDay()] +" "+ p +"."+ k +"."+ y +" "+ t +":"+ m

    jq('#Clock').text(string);
}, 60000);


$(document).ready(function() {
    jq.ctNotifyOption({
        opacity: 1,
        delay: 3000
    }, 'ctMessage');

    jq.ctNotifyOption({
        opacity: 1,
        delay: 3000
    }, 'ctError');

    jq.ctNotifyOption({
        opacity: 1,
        delay: 3000
    }, 'ctWarning');

    jq('#Clock').live('click', function() {
        jq('#ClockDate').val('');
        jq('#ClockDate').datebox('open');
    });

    jq('#ClockDate').change(function() {
        var date = jq(this).val();

        jq("#linkEvents").attr("href", systemUrl +"?Module=Events&Date="+ date)
        jq("#linkEvents").click();
    });

    jq('#EventFormSubmit').live('click', function() {
        var Title = jq('#EventFormTitle').val();
        var Description = jq('#EventFormDescription').val();
        var Date = jq(this).data('date');

        if(!jq.trim(Title).length) {
            alert('Et syöttänyt tapahtumalle lainkaan otsikkoa...');
        }

        else {
            jq.ajax({
                    url: systemUrl,
                    data: 'Module=Events&Action=SaveEvent&Title='+ Title +'&Description='+ Description +'&Date='+ Date,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function(xhr) {
                    },
                    success: function(data) {
                        if (data.error) {
                            makeMessageError(data.error);
                        }

                        else {
                            makeMessageOk('Tapahtuma lisätty onnistuneesti');
                        }

                         window.location.reload();
                    }
                });
        }
    });
});


function makeMessage(message) {
    jq('#ctNotify_ctMessage ul li').remove();
    jq.ctNotify(message, 'message', 'ctMessage');
}

function makeMessageOk(message) {
    jq('#ctNotify_ctMessage ul li').remove();
    jq.ctNotify(message, 'message', 'ctMessage');
}

function makeMessageError(message) {
    jq('#ctNotify_ctError ul li').remove();
    jq.ctNotify(message, 'error', 'ctError');
}

function makeMessageWarning(message) {
    jq('#ctNotify_ctError ul li').remove();
    jq.ctNotify(message, 'warning', 'ctWarning');
}

function getParameter(paramName) {
    var searchString = window.location.search.substring(1), i, val, params = searchString.split("&");

    for (i = 0; i < params.length; i++) {
        val = params[i].split("=");

        if (val[0] == paramName) {
            return unescape(val[1]);
        }
    }

    return null;
}
