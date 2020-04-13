function _(id)
{
  return document.getElementById(id);
}
function pi(s)
{
  return parseInt(s);
}
function phoneNumber(x,event)
{
  var c=(event.which) ? event.which : event.keyCode;
  if((c > 31 && (c < 48 || c > 57)) && !(c>95 && c<106))
  {
    event.preventDefault();
    return false;
  }
}
function resetForm(p,x)
{
  p.type="password";
  x.classList.remove("hide-password");
  x.classList.add("show-password");
}
function togglePassword(x)
{
  var p=_("signup_password");
  if(p.type=="password")
  {
    p.type="text";
    x.classList.remove("show-password");
    x.classList.add("hide-password");
  }
  else
  {
    resetForm(p,x);
  }
}
function adjustCalendar()
{
  var c=_("clock");
  if(typeof(c)!='undefined' && c!= null)
  {
    var c=_("clock");
    var t=_("time");
    var cw=c.getBoundingClientRect().width;
    var tw=c.getBoundingClientRect().width;
    var wmax=parseInt((cw>tw)?cw:tw);
    c.style.width=wmax;
    t.style.width=wmax;
  }
}
function adjustUI()
{
  var tiles=_("navcontainer").children;
  var n=tiles.length,i=0;
  for(i=0;i<n;i++)
  {
    var icon=tiles[i].children[0];
    var ic=icon.getBoundingClientRect();
    var w=ic.width;
    var h=ic.height;
    var icmin=parseInt((w<h)?w:h);
    icon.style.width=icmin+"px";
    icon.style.height=icmin+"px";
  }
}
function startChanges()
{
  var day=_("svg_day_text");
  var hour=_("svg_hour_text");
  var minute=_("svg_minute_text");
  var second=_("svg_second_text");
  var maxday=pi(_("timerunner").getAttribute("maxday"));
  maxday=(maxday<1)?1:maxday;
  setInterval(function(){
    var timer={
      day:pi(day.innerHTML),
      hour:pi(hour.innerHTML),
      minute:pi(minute.innerHTML),
      second:pi(second.innerHTML)
    };
    //Second
    var s=timer.second;
    if(s>0)
    {
      setProgress("second",s-1,60," S");
    }
    else
    {
      setProgress("second",59,60," S");
      //Minute
      var m=timer.minute;
      if(m>0)
      {
        setProgress("minute",m-1,60," M");
      }
      else
      {
        setProgress("minute",59,60," M");
        //Hour
        var h=timer.hour;
        if(h>0)
        {
          setProgress("hour",h-1,24," H");
        }
        else
        {
          setProgress("hour",24,24," H");
          //Day
          var d=timer.day;
          if(d>0)
          {
            setProgress("day",d-1,maxday," D");
          }
          else
          {
            /// important
            /// when timer hits zero
            /// window.location.reload();
          }
          //Day
        }
        //Hour
      }
      //Minute
    }
    //Second
  },1000);
}
function checkAns(b,a)
{
  if(a.value=="")
  {
    b.classList.remove("gbutton");
    b.classList.add("rbutton");
  }
  else
  {
    b.classList.remove("rbutton");
    b.classList.add("gbutton");
  }
}
function resetButton(b)
{
  b.classList.remove("rbutton");
  b.classList.remove("gbutton");
}
function toggleMenu()
{
  var nav=_('navcontainer');
  var c=nav.classList;
  if(nav.getAttribute("status")=="collapse")
  {
    c.remove("collapse");
    c.add("expand");
    nav.setAttribute("status","expand");
  }
  else
  {
    c.remove("expand");
    c.add("collapse");
    nav.setAttribute("status","collapse");
  }
}
function isOverflowing(e)
{
  if(e.scrollHeight>e.clientHeight)
  {
    return "h";
  }
  if(e.scrollWidth>e.clientWidth)
  {
    return "w";
  }
  return "";
}
function setProgress(i,progress,total,unit)//id-num,progress,total,unit
{
  var dash=220;//SVG dash array
  progress=(progress>total)?total:progress;
  var cur=(progress*dash)/total;
  _('svg_'+i+'_path').setAttribute("stroke-dasharray",cur+","+(dash-cur));
  _('svg_'+i+'_text').innerHTML=progress+unit;
}
function firstClock()
{
  var day=_("svg_day_text");
  var hour=_("svg_hour_text");
  var minute=_("svg_minute_text");
  var second=_("svg_second_text");
  var maxday=pi(_("timerunner").getAttribute("maxday"));
  maxday=(maxday<1)?1:maxday;
  var d=pi(day.innerHTML);
  var h=pi(hour.innerHTML);
  var i=pi(minute.innerHTML);
  var s=pi(second.innerHTML);
  setProgress("day",d,maxday," D");
  setProgress("hour",h,24," H");
  setProgress("minute",i,60," M");
  setProgress("second",s,60," S");

}
