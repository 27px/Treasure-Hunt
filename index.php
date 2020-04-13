<?php
  ob_start();
  session_start();
  require_once("config/config.php");
  if(isset($_GET['logout']) && $_GET['logout']=="true")
  {
    $_SESSION['user']="";
    session_destroy();
    header("Location:index.php");
  }
  $x_d=0;
  $x_h=0;
  $x_i=0;
  $x_s=0;
  $maxday=0;
  $stat_mer="";
  function putSVG($p,$u,$id)
  {
    ?>
      <svg class="runner daytimer" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#29B6F6;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#0D47A1;stop-opacity:1" />
          </linearGradient>
        </defs>
        <circle cx="50" cy="50" r="45" fill="url(#grad)" stroke="rgba(26,35,126,0.5)" stroke-weight="1"/>
        <path id="svg_<?php echo $id; ?>_path" fill="none" stroke-linecap="round" stroke-width="8" stroke="#FFFFFF" stroke-dasharray="0,220" d="M50 15 a 35 35 0 0 1 0 70 a 35 35 0 0 1 0 -70"/>
        <text id="svg_<?php echo $id; ?>_text" x="50" y="50" text-anchor="middle" font-family="Roboto,sans-serif" dy="7" font-size="21" fill="#FFFFFF"><?php echo $p." ".$u; ?></text>
      </svg>
    <?php
  }
  function setProgressInitial($d,$h,$i,$s,$maxday)
  {
    ?>
      <div class="timerunner" id="timerunner" maxday="<?php echo $maxday; ?>">
        <div class="a">
          <?php putSVG($d,"D","day"); ?>
          <?php putSVG($h,"H","hour"); ?>
        </div>
        <div class="b">
          <?php putSVG($i,"M","minute"); ?>
          <?php putSVG($s,"S","second"); ?>
        </div>
      </div>
    <?php
  }
?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <title>Hunter</title>
    <meta name="theme-color" content="#1976D2">
    <script>
      document.onreadystatechange=function(){
        if(document.readyState=="complete")
        {
          var l=_("loader");
          l.parentNode.removeChild(_("loader"));
        }
      };
    </script>
    <link rel="preload" as="image" type="image/jpg" href="images/blue.jpg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/home.svg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/rules.svg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/contact.svg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/leaderboard.svg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/signup.svg" />
    <link rel="preload" as="image" type="image/svg+xml" href="images/signin.svg" />
    <!--
    <link rel="preload" as="font" type="font/ttf" href="font/Lemon.ttf" />
    <link rel="preload" as="font" type="font/ttf" href="font/digital-7.ttf" />
    <link rel="preload" as="font" type="font/ttf" href="font/Roboto.ttf" />
    -->
    <link rel="preload" as="style" type="text/css" href="style/style-index.min.css" />
    <link rel="preload" as="script" type="text/javascript" href="script/script.min.js" />
    <link rel="stylesheet" href="style/style-index.min.css" />
    <script src="script/script.min.js"></script>
  </head>
  <body class="index" onload="firstClock();adjustUI();adjustCalendar();" onresize="adjustUI();" onorientationchange="adjustUI();">
    <div class="loader" id="loader">
      <div class="loadcontainer">
        <?php
          for($i=0;$i<10;$i++)
          {
            echo "<div class='c'></div>";
          }
        ?>
      </div>
    </div>
    <div class="container">
      <div class="nav">
        <div class="title">Hunter</div>
        <div class="menu" onclick="toggleMenu();" id="menu">
          <div class="bar"></div>
          <div class="bar"></div>
          <div class="bar"></div>
        </div>
      </div>
      <div class="navcontainer collapse" id="navcontainer" status="collapse">
        <?php require_once("functions/navbar.php"); ?>
      </div>
      <div class="contents">
        <?php
          $stat_date_active=1;
          $comp_status=isCompetitionStarted();
          $classStatus=($comp_status==1)?"reddish":"greenish";
          if($comp_status==1)
          {
            $now=new DateTime;
            $x=date_diff($now,$competition_end_date_time,true);
            $x_d=$x->format("%a");
            $x_h=$x->format("%h");
            $x_i=$x->format("%i");
            $x_s=$x->format("%s");
            $status="Competition has Started, and will end on ";
            $stat_d=$competition_end_date_time->format("d");
            $stat_m=$competition_end_date_time->format("m");
            $stat_y=$competition_end_date_time->format("Y");
            $stat_h=$competition_end_date_time->format("H");
            $stat_i=$competition_end_date_time->format("i");
            $stat_s=$competition_end_date_time->format("s");
            $stat_l=$competition_end_date_time->format("l");
            $stat_f=$competition_end_date_time->format("F");
            $stat_mer=$competition_end_date_time->format("A");
            $maxday=$competition_number_of_days;
          }
          else if($comp_status==2)
          {
            $now=new DateTime;
            $x=date_diff($now,$competition_start_date_time,true);
            $x_d=$x->format("%a");
            $x_h=$x->format("%h");
            $x_i=$x->format("%i");
            $x_s=$x->format("%s");
            $status="Competition will Start on";
            $stat_d=$competition_start_date_time->format("d");
            $stat_m=$competition_start_date_time->format("m");
            $stat_y=$competition_start_date_time->format("Y");
            $stat_h=$competition_start_date_time->format("H");
            $stat_i=$competition_start_date_time->format("i");
            $stat_s=$competition_start_date_time->format("s");
            $stat_l=$competition_start_date_time->format("l");
            $stat_f=$competition_start_date_time->format("F");
            $stat_mer=$competition_start_date_time->format("A");
            $maxday=$x_d;
          }
          else
          {
            $stat_date_active=0;
            $status="Competition is over, Check Leaderboards";
          }
        ?>
        <div class="main">
          <div class="mainwrapper">
            <div class="twrap">
              <div class="proname">Hunter</div>
              <div class="name">Treasure Hunt</div>
              <?php setProgressInitial($x_d,$x_h,$x_i,$x_s,$maxday); ?>
            </div>
            <div class="twrap">
              <div class="status"><?php echo $status; ?></div>
              <?php
                if($stat_date_active==1)
                {
                  echo "<div class='clockwrapper ".$classStatus."'>";
                    echo "<div class='clock' id='clock'>";
                      echo "<div class='w'>".$stat_l."</div>";
                      echo "<div class='d'>".$stat_d."</div>";
                      echo "<div class='wrapper'>";
                        echo "<div class='f'>".$stat_f."</div>";
                        echo "<div class='y'>".$stat_y."</div>";
                      echo "</div>";
                    echo "</div>";
                    echo "<div class='time' id='time'>";
                      echo "<div class='first'>".($stat_h%12)." : ".$stat_i."</div>";
                      echo "<div class='s'>".$stat_s."</div>";
                      echo "<div class='mer'>".$stat_mer."</div>";
                    echo "</div>";
                  echo "</div>";
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
      <?php
        if($stat_date_active==1)
        {
      ?>
        <script>startChanges();</script>
      <?php
        }
      ?>
  </body>
</html>
