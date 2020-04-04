<a class='link active' href='index.php'>
  <div class="icon home"></div>
  <div class="title">Home</div>
</a>
<?php
  if(isset($_SESSION['user']) && !empty($_SESSION['user']))
  {
?>
    <a class='link' href='hunt.php'>
      <div class="icon hunt"></div>
      <div class="title">Hunt</div>
    </a>
<?php
  }
?>
<a class='link' href='leaderboard.php'>
  <div class="icon leaderboard"></div>
  <div class="title">Leaderboard</div>
</a>
<a class='link' href='rules.html'>
  <div class="icon rules"></div>
  <div class="title">Rules</div>
</a>
<a class='link' href='contact.html'>
  <div class="icon contact"></div>
  <div class="title">Contact</div>
</a>
<?php
  if(isset($_SESSION['user']) && !empty($_SESSION['user']))
  {
?>
    <a class='link' href='index.php?logout=true'>
      <div class="icon logout"></div>
      <div class="title">Logout</div>
    </a>
<?php
  }
  else
  {
?>
    <a class='link' href='register.php'>
      <div class="icon signup"></div>
      <div class="title">Sign Up</div>
    </a>
    <a class='link' href='signin.php'>
      <div class="icon signin"></div>
      <div class="title">Sign In</div>
    </a>
<?php
  }
?>
