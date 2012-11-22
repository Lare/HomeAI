setInterval(function() {
    jq.ajax({
        url: systemUrl +'?Module='+ module +'&Action=GetHashes',
        dataType: 'json',
        success: function(data) {
            if (data.Temparature != hashTemperature) {
                hashTemperature = data.Temparature;

                updateTemperature();
            }

            if (data.Controls != hashControls) {
                hashControls = data.Controls;

                updateControls();
            }
        }
    });
}, 10000);

$(document).ready(function() {
    jq(".iPhoneSwitch").each(function() {
        makeiPhoneControls(jq(this));
    });
});

function updateTemperature() {
    jq.ajax({
        url: systemUrl +'?Module='+ module +'&Action=GetTemperature',
        beforeSend: function(xhr) {
        },
        success: function(data) {
            console.log(data);
            jq("#Temperature").html(data);
        }
    });
}

function updateControls() {
    jq.ajax({
        url: systemUrl +'?Module='+ module +'&Action=GetControls',
        beforeSend: function(xhr) {
        },
        success: function(data) {
            jq("#ControlBox").html(data);

            jq("#ControlBox .iPhoneSwitch").each(function() {
                makeiPhoneControls(jq(this));
            });

            jq('#Controls').listview();
        }
    });
}

function makeiPhoneControls(element) {
    element.iphoneStyle({
        onChange: function(elem, value) {
            if (elem.is(':checked') == true) {
                var status = 1;
            }

            else {
                var status = 0;
            }

            var relayId = elem.data('id');
            var relayBit = elem.data('bit');

            jq.ajax({
                url: systemUrl +'?Module='+ module +'&Action=SetRelayStatus&RelayId='+ relayId +'&RelayBit='+ relayBit +'&Status='+ status,
                type: 'post',
                dataType: 'json',
                beforeSend: function(xhr) {
                },
                success: function(data) {
                    if (data.error) {
                        makeMessageError(data.error);
                    }

                    updateControls();
                }
            });
        }
    });
}
