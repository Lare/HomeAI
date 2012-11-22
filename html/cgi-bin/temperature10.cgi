#!/usr/bin/rrdcgi

-->
 <RRD::SETVAR rrdpath /var/lib/rrd/temp_hum/>
 <RRD::SETVAR graph power_1>
 <RRD::SETVAR title "Tehon kulutus">
 <RRD::SETVAR ds1 "power_1">
 <RRD::SETVAR ds1name "Kulutus W">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> -l 0 --end <RRD::CV END> -w 500px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  --width 700 --height 250
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,3600,*
  CDEF:<RRD::GETVAR ds1>_yearlyavg=<RRD::GETVAR ds1>_real,8760,*,1000,/
  AREA:<RRD::GETVAR ds1>_real#13B8F4:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  GPRINT:<RRD::GETVAR ds1>_yearlyavg:AVERAGE:"Tällä kulutuksella vuotuinen kulutus kWh\: %6.2lf \\n"
>
</a>
<BR>
