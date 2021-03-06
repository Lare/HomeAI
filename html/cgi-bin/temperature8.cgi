#!/usr/bin/rrdcgi

-->
 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph yk_kosteus>
 <RRD::SETVAR title "Yläkerta, kosteus">
 <RRD::SETVAR ds1 "hum_ykmhe">
 <RRD::SETVAR ds1name "Vierashuone    ">
 <RRD::SETVAR ds2 "hum_ykmhp">
 <RRD::SETVAR ds2name "Pohjoinen huone">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature" data-ajax="false">
 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 500px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  --width 700 --height 250
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#13B8F4:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#0606A2:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>
