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
?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Hunter</title>
    <meta name="theme-color" content="#1976D2">
    <link rel="stylesheet" href="style/style-index.min.css" />
    <script src="script/script.min.js"></script>
  </head>
  <body class="index" onload="startTimer();">
    <div class="container">
      <div class="nav">
        <div class="title">Hunter</div>
        <div class="menu" onclick="_('navcontainer').classList.toggle('expand');">&vellip;</div>
      </div>
      <div class="navcontainer" id="navcontainer">
        <?php require_once("functions/navbar.php"); ?>
      </div>
      <div class="contents">
        <div class="colwrapper">
          <?php
            $comp_status=isCompetitionStarted();
            if($comp_status==1)
            {
              ?>
                <div class="timer">
                  <?php
                    $now=new DateTime;
                    $x=date_diff($now,$competition_end_date_time);
                    $x_y=$x->format("%y");
                    $x_m=$x->format("%m");
                    $x_d=$x->format("%d");
                    $x_h=$x->format("%h");
                    $x_i=$x->format("%i");
                    $x_s=$x->format("%s");
                    echo "<div class='box'><div class='num' id='timeryear'>".$x_y."</div><div class='desc'>Years</div></div>";
                    echo "<div class='box'><div class='num' id='timermonth'>".$x_m."</div><div class='desc'>Months</div></div>";
                    echo "<div class='box'><div class='num' id='timerday'>".$x_d."</div><div class='desc'>Days</div></div>";
                    echo "<div class='box'><div class='num' id='timerhour'>".$x_h."</div><div class='desc'>Hours</div></div>";
                    echo "<div class='box'><div class='num' id='timerminute'>".$x_i."</div><div class='desc'>Minutes</div></div>";
                    echo "<div class='box'><div class='num' id='timersecond'>".$x_s."</div><div class='desc'>Seconds</div></div>";
                  ?>
                </div>
                <div class="status">
                  <div class="text">Competition will end on <?php echo $competition_end_date_time->format("d/m/Y H:i:s"); ?></div>
                </div>
              <?php
            }
            else if($comp_status==2)
            {
              ?>
                <div class="status">Competition will Start on <?php echo $competition_start_date_time->format("d/M/Y H:i:s"); ?></div>
              <?php
            }
            else
            {
              ?>
                <div class="status">Competition is over, Check Leaderboards</div>
              <?php
            }
          ?>
        </div>
      </div>
    </div>
  </body>
</html>
