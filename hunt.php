<?php
  ob_start();
  session_start();
  require_once("config/config.php");
  if(!(isset($_SESSION['user']) && !empty($_SESSION['user'])))
  {
    header("Location:register.php");
  }
  if(isCompetitionStarted()!=1)
  {
    header("Location:register.php");
  }
  $status="";
  $level=1;
  $question="";
  $qid=$no_of_questions+1000;//high value (Should be greater than total no of questions)
  $finished=0;
  $answered=0;
  $error=0;
  $pro=$db->prepare("SELECT answered FROM login WHERE phone=? limit 1;");
  $pro->bind_param("s",$_SESSION['user']);
  $pro->execute();
  $r=$pro->get_result();
  if(mysqli_num_rows($r)>0)
  {
    $row=mysqli_fetch_assoc($r);
    $answered=intval($row['answered']);
  }
  $qid=$answered+1;
  if($qid>$no_of_questions)
  {
    $finished=1;//answered all questions
  }
  else
  {
    $pro1=$db->prepare("SELECT questions FROM question where no=? limit 1;");
    $pro1->bind_param("i",$qid);
    $pro1->execute();
    $r=$pro1->get_result();
    if(mysqli_num_rows($r)>0)
    {
      $row=mysqli_fetch_assoc($r);
      $level=$qid;
      $question=$row['questions'];
    }
    else
    {
      //Error
      $error=1;
      $status="Error : #20 Please Contact Admin";
    }
  }
  if(isset($_POST['subanswer']) && isset($_POST['answer']) && !(empty($_POST['answer'])))
  {
    $ua=$_POST['answer'];
    $pro1=$db->prepare("SELECT questions FROM question where no=? and answer=? limit 1;");
    $pro1->bind_param("is",$qid,$ua);
    $pro1->execute();
    $r=$pro1->get_result();
    if(mysqli_num_rows($r)>0)
    {
      $pro2=$db->prepare("UPDATE `login` SET `answered`=?,last_answered=CURRENT_TIMESTAMP WHERE phone=?;");
      $pro2->bind_param("is",$qid,$_SESSION['user']);
      $pro2->execute();
      header("Location:hunt.php");
    }
    else
    {
      $status="Wrong Answer";
    }
  }
  $db->close();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hunter</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style/main.min.css">
    <script src="script/script.min.js"></script>
  </head>
    <body class="hunt">
      <div class="signin">
      <?php
        if($error==1)
        {
          ?>
            <div class="error"><?php echo $status; ?></div>
          <?php
        }
        else if($finished==0)
        {
          ?>
            <div class="container">
              <div class="navcontainer">
                <div class="wrapper">
                  <a class="link min" href="#"><div class="hamburger">---</div></a>
                  <a class="link main active" href="index.php">Home</a>
                  <a class="link" href="rules.html">Rules</a>
                  <a class="link" href="contact.html">Contact Us</a>
                  <a class="link" href="leaderboard.php">Leaderboard</a>
                  <?php
                    if(isset($_SESSION['user']) && !empty($_SESSION['user']))
                    {
                  ?>
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
              <div class="contents">
                <div class="wrapper">
                  <div class="level">Level <?php echo $level; ?></div>
                  <div class="question"><?php echo $question; ?></div>
                  <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="status"><?php echo $status; ?></div>
                    <input type="text" id="answer" placeholder="Answer" name="answer" required>
                    <button type="submit" name="subanswer" onmouseover="checkAns(this,_('answer'));" onmouseout="resetButton(this);">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          <?php
        }
        else
        {
          ?>
            <div class="finished">Finished All Questions</div>
          <?php
        }
      ?>
    </div>
  </body>
</html>
