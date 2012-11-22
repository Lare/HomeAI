#!/usr/bin/rrdcgi
-->
 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph ulko>
 <RRD::SETVAR title "Ulkolämpötila">
 <RRD::SETVAR ds1 "temp_ulko">
 <RRD::SETVAR ds1name "Ulko      ">
 <RRD::SETVAR ds2 "temp_jarvi">
 <RRD::SETVAR ds2name "Järvi     ">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=1" data-ajax="false">

<RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#00a000:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ff0000:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>


 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph sisa>
 <RRD::SETVAR title "Sauna ja lämminvesivaraaja">
 <RRD::SETVAR ds1 "temp_ssauna">
 <RRD::SETVAR ds1name "Sauna     ">
 <RRD::SETVAR ds2 "temp_lvv">
 <RRD::SETVAR ds2name "Varaaja   ">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=2" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#00a000:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ff0000:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph autotalli>
 <RRD::SETVAR title "Autotalli">
 <RRD::SETVAR ds1 "temp_at_ilp">
 <RRD::SETVAR ds1name "ILP       ">
 <RRD::SETVAR ds2 "temp_at">
 <RRD::SETVAR ds2name "Keskikohta">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=3" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#00a000:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ff0000:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph kosteudet>
 <RRD::SETVAR title "Kosteusprosentit">
 <RRD::SETVAR ds1 "hum_at">
 <RRD::SETVAR ds1name "Autotalli ">
 <RRD::SETVAR ds2 "hum_ulko">
 <RRD::SETVAR ds2name "Ulkoilma  ">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=5" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
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

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph tuloilma>
 <RRD::SETVAR title "Tuloilma">
 <RRD::SETVAR ds1 "temp_tuloilma">
 <RRD::SETVAR ds1name "Tuloilma  ">
 <RRD::SETVAR ds2 "temp_tuloilmavastus">
 <RRD::SETVAR ds2name "Tuloilmav.">
 <RRD::SETVAR ds3 "temp_ulko">
 <RRD::SETVAR ds3name "Ulkoilma  ">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=6" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  DEF:<RRD::GETVAR ds3>=<RRD::GETVAR rrdpath><RRD::GETVAR ds3>.rrd:<RRD::GETVAR ds3>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  CDEF:<RRD::GETVAR ds3>_real=<RRD::GETVAR ds3>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#ffcc00:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ff0000:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds3>_real#13B8F4:<RRD::GETVAR ds3name>
  GPRINT:<RRD::GETVAR ds3>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds3>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds3>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds3>_real:LAST:"Viim.\: %6.2lf \\n"


>
</a>
</div>

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph yk_lampo>
 <RRD::SETVAR title "Yläkerta, lämpötilat">
 <RRD::SETVAR ds1 "temp_ykmhe">
 <RRD::SETVAR ds1name "Vierashuone    ">
 <RRD::SETVAR ds2 "temp_ykmhp">
 <RRD::SETVAR ds2name "Pohjoinen huone">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=7" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
  DEF:<RRD::GETVAR ds1>=<RRD::GETVAR rrdpath><RRD::GETVAR ds1>.rrd:<RRD::GETVAR ds1>:AVERAGE
  DEF:<RRD::GETVAR ds2>=<RRD::GETVAR rrdpath><RRD::GETVAR ds2>.rrd:<RRD::GETVAR ds2>:AVERAGE
  CDEF:<RRD::GETVAR ds1>_real=<RRD::GETVAR ds1>,100,/
  CDEF:<RRD::GETVAR ds2>_real=<RRD::GETVAR ds2>,100,/
  LINE1.3:<RRD::GETVAR ds1>_real#ffcc00:<RRD::GETVAR ds1name>
  GPRINT:<RRD::GETVAR ds1>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds1>_real:LAST:"Viim.\: %6.2lf \\n"
  LINE1.3:<RRD::GETVAR ds2>_real#ff0000:<RRD::GETVAR ds2name>
  GPRINT:<RRD::GETVAR ds2>_real:AVERAGE:"Keskim.\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MIN:"Alin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:MAX:"Ylin\: %6.2lf "
  GPRINT:<RRD::GETVAR ds2>_real:LAST:"Viim.\: %6.2lf \\n"

>
</a>
</div>

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph yk_kosteus>
 <RRD::SETVAR title "Yläkerta, kosteus">
 <RRD::SETVAR ds1 "hum_ykmhe">
 <RRD::SETVAR ds1name "Vierashuone    ">
 <RRD::SETVAR ds2 "hum_ykmhp">
 <RRD::SETVAR ds2name "Pohjoinen huone">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=8" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
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

 <RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph takka>
 <RRD::SETVAR title "Takka">
 <RRD::SETVAR ds1 "temp_takka">
 <RRD::SETVAR ds1name "Takka, yläosa">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=9" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
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

<RRD::SETVAR rrdpath <RRD::CV RRD>>
 <RRD::SETVAR graph power_1>
 <RRD::SETVAR title "Sähkön kulutus">
 <RRD::SETVAR ds1 "power_1">
 <RRD::SETVAR ds1name "Kulutus W">

<div class="GroupImage">
<a href="<RRD::CV URL>?Module=GraphsTemperature&GraphId=10" data-ajax="false">

 <RRD::GRAPH
  <RRD::CV PATH><RRD::GETVAR graph>.png
  --imginfo '<img src="<RRD::CV IMGURL>%s?timestamp=<RRD::CV TIME>" width="%lu" height="%lu" />'
  -a PNG -E --start <RRD::CV START> --alt-autoscale --end <RRD::CV END> -w 700px --title=<RRD::GETVAR title>
  --color BACK#000000 --color CANVAS#000000 --color FONT#ffffff --color AXIS#ffffff
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
</div>
