$(document).ready(function() {
    var len = 10;

    jq("fieldset div.ui-radio label").each(function() {
        len += jq(this).width();
    });

    jq("#RangeButtons").width(len).css({
        'position'      : 'relative',
        'margin-left'   : '-'+ (len / 2) +'px',
        'margin-bottom' : '10px',
        'top'           : '3px',
        'left'          : '50%'
    });
});

$('#wrapper').live('pageinit', function(event) {
    jq("div.ui-radio label").bind('tap', function() {
        range = parseInt(jq(this).parent().children('input').val());
        graphId = parseInt(getParameter('GraphId'));

        fetchGraphData(graphId, range);
    });

    graphId = parseInt(getParameter('GraphId'));

    if (!isNaN(graphId)) {
        setInterval(function() {
            range = parseInt(jq("div.ui-radio label.ui-radio-on").parent().children('input').val());

            fetchGraphData(graphId, range);
        }, 300000);
    }
});

function fetchGraphData(graphId, range) {
    jq.ajax({
        url: systemUrl +'?Module='+ module +'&Action=GetGraphs&Range='+ range +'&GraphId='+ graphId,
        success: function(data) {
            jq('#GraphImages').html(data);
        }
    });
}