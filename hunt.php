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
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Hunter</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style/main.min.css">
</head>
  <body class="hunt">
<div class="signin">
  <div class="container py-5">
<div class="row text-center">
<div class="col">
  <?php
    if($error==1)
    {
      ?>
        <label class="text p-3" style="color:#FF4040;font-size:25px;font-weight:600;text-shadow:0px 0px 5px #000000;"><?php echo $status; ?></label>
      <?php
    }
    else if($finished==0)
    {
      ?>
        <h1 class=" text-center whitecolor p-3" style="font-weight:600;text-shadow:0px 0px 5px #000000;">Level <?php echo $level; ?></h1>
        <div class="container">
          <div class="container whitecolor question my-4" style="font-weight:600;font-size:40px;text-shadow:0px 0px 5px #000000;"><?php echo $question; ?></div>
          <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="form-group m-0">
              <input type="text" class="form-control max2 relcen trinp" id="name" placeholder="Answer" name="answer" required>
              <label class="text p-3" style="color:#FF4040;font-size:25px;font-weight:600;text-shadow:0px 0px 5px #000000;"><?php echo $status; ?></label>
            </div>
            <button type="submit" class="btn btn-success text-capitalize mt-1" name="subanswer">submit</button>
          </form>
        </div>
      <?php
    }
    else
    {
      ?>
        <h1 class=" text-center p-3" style="font-weight:600;text-shadow:0px 0px 5px #000000;color:#00FF00;">Finished All Questions</h1>
      <?php
    }
  ?>
</div>
</div>
</div>
</div>
</body>
</html>
