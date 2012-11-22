#!/usr/bin/rrdcgi

-->
 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph varastot>
 <RRD::SETVAR title "Varastot">
 <RRD::SETVAR ds1 "korko3kk">
 <RRD::SETVAR ds1name "Sininen   ">
 <RRD::SETVAR ds2 "korko2kk">
 <RRD::SETVAR ds2name "Keltainen ">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature" data-ajax="false">
 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 500px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  --width 700 --height 250
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds1>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,-100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,125,/
  LINE1.3:<RRD::GETVAR ds1>_real#121285:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ffcc00:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"
>
</a>
</div>
