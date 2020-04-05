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
function startTimer()
{
  var day=_("timerday");
  var hour=_("timerhour");
  var minute=_("timerminute");
  var second=_("timersecond");
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
      second.innerHTML=s-1;
    }
    else
    {
      second.innerHTML=59;
      //Minute
      var m=timer.minute;
      if(m>0)
      {
        minute.innerHTML=m-1;
      }
      else
      {
        minute.innerHTML=59;
        //Hour
        var h=timer.hour;
        if(h>0)
        {
          hour.innerHTML=h-1;
        }
        else
        {
          hour.innerHTML=24;
          //Day
          var d=timer.day;
          if(d>0)
          {
            day.innerHTML=d-1;
          }
          else
          {
            window.location.reload();
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
