#!/usr/bin/rrdcgi

-->
 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph takka>
 <RRD::SETVAR title "Takka">
 <RRD::SETVAR ds1 "temp_takka">
 <RRD::SETVAR ds1name "Takka, yläosa">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature" data-ajax="false">
 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 500px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  --width 700 --height 250
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#ff0000:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>
