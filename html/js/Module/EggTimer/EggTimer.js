$(document).ready(function() {
    document.getElementById('AlarmSound').addEventListener('ended', function() {
        this.currentTime = 0;
    }, false);

    jq("#StartTimer").click(function() {
        var value = jq("#TimerDuration").val().split(',');

        re = /(\d{1,2}):(\d{1,2}):(\d{1,2})$/;

        time = value[1].match(re);

        re = /^(\d)/;

        date = value[0].match(re);

        var days = parseInt(date[1]);
        var hours = parseInt(time[1]);
        var minutes = parseInt(time[2]);
        var seconds = parseInt(time[3]);
        var curDate = new Date();
        var timer = new Date(curDate.getFullYear(), curDate.getMonth(), (curDate.getDate() + days), (curDate.getHours() + hours), (curDate.getMinutes() + minutes), (curDate.getSeconds() + seconds));

        jq("#EggTimer").removeClass('Alert');

        var alarm = jq("#AlarmSound")[0];

        alarm.pause();

        jq("#EggTimer").countdown('destroy');
        jq("#EggTimer").countdown({until: timer, onExpiry: playAlert});
    });

    function playAlert() {
        jq("#EggTimer").addClass('Alert');

        var alarm = jq("#AlarmSound")[0];

        alarm.play();
    }
});