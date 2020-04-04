<?php
  ob_start();
  session_start();
  require_once("config/config.php");
  if(isset($_SESSION['user']) && !empty($_SESSION['user']))
  {
    header("Location:hunt.php");
  }
  if(isCompetitionStarted()!=1)
  {
    header("Location:register.php");
  }
  $phone="";
  $pass="";
  $error="";
  if(isset($_POST['login']))
  {
    $phone=$_POST['phone'];
    $pass=$_POST['pass'];
    if(empty($_POST['phone']) || empty($_POST['pass']))
    {
      $error="Error : Enter all fields.";
    }
    else
    {
      $pro=$db->prepare("SELECT answered FROM login WHERE phone=? and password=? limit 1;");
      $pro->bind_param("ss",$phone,$pass);
      $pro->execute();
      $r=$pro->get_result();
      if(mysqli_num_rows($r)>0)
      {
        $_SESSION['user']=$phone;
        header("Location:hunt.php");
      }
      else
      {
        $error="Invalid User id / Password";
      }
    }
  }
  $db->close();
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Hunter</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
          <a class='link' href='register.php'>Sign Up</a>
          <a class='link active' href='signin.php'>Sign In</a>
        </div>
      </div>
    </div>
    <div class="subcontainer">
      <form class="signupform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row title"><big>S</big>ign <big>I</big>n</div>
        <div class="row">
          <input required type="text" id="signup_phone" placeholder="Phone" name="phone" maxlength="10" onkeydown="phoneNumber(this,event);" value="<?php echo $phone; ?>">
        </div>
        <div class="row">
          <input required type="password" id="signup_password" placeholder="Password" name="pass" maxlength="35" spellcheck="false">
          <div class="eye show-password" onclick="togglePassword(this);" id="sp"></div>
        </div>
        <?php
          if($error!="")
          {
            echo "<div class='row error'>".$error."</div>";
          }
        ?>
        <div class="row">
          <!--spacing-->
        </div>
        <div class="row">
          <button type="reset" class="left" onclick="resetForm(_('signup_password'),_('sp'));">Reset</button>
          <button type="submit" class="right" name="login">Login</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
