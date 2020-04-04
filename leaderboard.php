<?php
  ob_start();
  session_start();
  require_once("config/config.php");
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Hunter</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style/main.min.css">
  <script src="script/script.min.js"></script>
</head>
<body class="leaderboard">
  <div class="navcontainer">
    <div class="wrapper">
      <a class="link min" href="#"><div class="hamburger">---</div></a>
      <a class="link main" href="index.php">Home</a>
      <a class="link" href="rules.html">Rules</a>
      <a class="link" href="contact.html">Contact Us</a>
      <a class="link active" href="leaderboard.php">Leaderboard</a>
      <?php
        if(isset($_SESSION['user']) && !empty($_SESSION['user']))
        {
      ?>
          <a class='link' href='hunt.php'>Hunt</a>
          <a class='link' href='index.php?logout=true'>Logout</a>
      <?php
        }
        else
        {
      ?>
          <a class='link' href='register.php'>Sign Up</a>
          <a class='link' href='signin.php'>Sign In</a>
      <?php
        }
      ?>
    </div>
  </div>
  <div class="leaderboard">
    <div class="title">Leaderboard</div>
    <table class="leaderboard" border="1">
      <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>College</th>
        <th>Course</th>
        <th>Questions Solved</th>
      </tr>
      <?php
        $r=$db->query("SELECT * FROM `login` order by answered desc,last_answered asc;");
        $my_score_row=array();
        $my_score=99999;//Max Value
        if(mysqli_num_rows($r)>0)
        {
          $i=0;
          while($row=mysqli_fetch_assoc($r))
          {
            $i++;
            if($i<=$max_leaderboard_num_row)
            {
              $tclass="";
              if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user']==$row['phone'])
              {
                $tclass="highlight";
                $my_score=$i;
                $my_score_row=$row;
              }
              echo "<tr class='".$tclass."'><td>".$i."</td><td>".$row['name']."</td><td>".$row['college']."</td><td>".$row['course']."</td><td>".$row['answered']."</td></tr>";
            }
            else
            {
              if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user']==$row['phone'])
              {
                $my_score=$i;
                $my_score_row=$row;
                if($i>$max_leaderboard_num_row)
                {
                  break;//Exit after finding current position
                }
              }
            }
          }
        }
      ?>
    </table>
    <?php
      if(isset($_SESSION['user']) && !empty($_SESSION['user']))
      {
        echo "<div class='ttitle'>Your Rank : <span class='hightext'>".$my_score."</span></div>";
        echo "<table class='leaderboard' id='whborder'><tr><th>Rank</th><th>Name</th><th>College</th><th>Course</th><th>Questions Solved</th></tr><tr class='highlight'><td>".$my_score."</td><td>".$my_score_row['name']."</td><td>".$my_score_row['college']."</td><td>".$my_score_row['course']."</td><td>".$my_score_row['answered']."</td></tr></table>";
      }
    ?>
  </div>
</body>
</html>
<?php
  $db->close();
?>
