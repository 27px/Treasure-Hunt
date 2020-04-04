<?php
  ob_start();
  session_start();
  require_once("config/config.php");
  if(isCompetitionStarted()!=1)
  {
    header("Location:index.php");
  }
  $name="";
  $phone="";
  $college="";
  $course="";
  $pass="";
  $error="";
  if(isset($_POST['signup']))
  {
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $college=$_POST['college'];
    $course=$_POST['course'];
    $pass=$_POST['pass'];
    if(empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['college']) || empty($_POST['course']) || empty($_POST['pass']))
    {
      $error="Error : Enter all fields.";
    }
    else
    {
      $pro=$db->prepare("SELECT phone FROM login WHERE phone=? limit 1;");
      $pro->bind_param("s",$phone);
      $pro->execute();
      $r=$pro->get_result();
      if(mysqli_num_rows($r)>0)
      {
        $error="Phone Number already registered.<br><span class='info'>Need Help?</span><a href='contact.html' style='margin-left:8px;'>Contact Us</a>";
      }
      else
      {
        $pro=$db->prepare("INSERT INTO `login`(`phone`,`name`,`college`,`course`,`password`,`answered`,`last_answered`) VALUES (?,?,?,?,?,'00000000000000000000',CURRENT_TIMESTAMP);");
        $pro->bind_param("sssss",$phone,$name,$college,$course,$pass);
        if($pro->execute())
        {
          header("Location:signin.php");
        }
        else
        {
          $error=$pro->error;
        }
      }
    }
  }
  $db->close();
?>
<html>
<head>
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="style/main.min.css">
  <script src="script/script.min.js"></script>
  <link rel="preload" href="images/hide.svg" as="image" type="image/svg+xml"/>
  <link rel="preload" href="images/show.svg" as="image" type="image/svg+xml"/>
</head>
<body class="register">
  <div class="container">
    <div class="subcontainer">
      <div class="details">
        <div class="wrapper">
          <div class="lowtitle">Treasure Hunt</div>
          <div class="title">Hunt It</div>
          <div class="subtitle">Find the Treasure</div>
          <div class="description">The Online Coding Treasure Hunt</div>
        </div>
      </div>
      <div class="navcontainer">
        <div class="wrapper">
          <a class="link min" href="#"><div class="hamburger">---</div></a>
          <a class="link main" href="index.php">Home</a>
          <a class="link" href="rules.html">Rules</a>
          <a class="link" href="contact.html">Contact Us</a>
          <a class="link" href="leaderboard.php">Leaderboard</a>
          <a class='link active' href='register.php'>Sign Up</a>
          <a class='link' href='signin.php'>Sign In</a>
        </div>
      </div>
    </div>
    <div class="subcontainer">
      <form class="signupform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row title"><big>S</big>ign <big>U</big>p</div>
        <div class="row">
          <input required type="text" id="signup_name" placeholder="Name" name="name" maxlength="50" value="<?php echo $name; ?>" spellcheck="false">
        </div>
        <div class="row">
          <input required type="text" id="signup_phone" placeholder="Phone" name="phone" maxlength="10" onkeydown="phoneNumber(this,event);" value="<?php echo $phone; ?>">
        </div>
        <div class="row">
          <input required type=text id="signup_college" placeholder="College" name="college" maxlength="150" value="<?php echo $college; ?>">
        </div>
        <div class="row">
          <input required type="text" id="signup_course" placeholder="Course" name="course" maxlength="75" value="<?php echo $course; ?>">
        </div>
        <div class="row">
          <input required type="password" id="signup_password" placeholder="Password ( Max : 25 Chars )" name="pass" maxlength="25" spellcheck="false">
          <div class="eye show-password" onclick="togglePassword(this);" id="sp"></div>
        </div>
        <?php
          if($error!="")
          {
            echo "<div class='row error'>".$error."</div>";
          }
        ?>
        <div class="row">
          <button type="reset" class="left" onclick="resetForm(_('signup_password'),_('sp'));">Reset</button>
          <button type="submit" class="right" name="signup">Register</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
