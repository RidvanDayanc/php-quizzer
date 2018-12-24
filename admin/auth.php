<?php
if (array_key_exists("logged_user", $_COOKIE)) {
    header("Location: panel.php");
    exit;
}
$alert = false;
require_once '../database.php';
if (array_key_exists("action", $_GET)) {
    if (array_key_exists("username", $_POST) || array_key_exists("password", $_POST)) {
        if (strcmp($_GET['action'], 'register') === 0) {
            $query = $db->prepare("INSERT INTO users SET username = ?,password = ?");
            $insert = $query->execute(array($_POST['username'], $_POST['password']));
            $alert = "Kayıt Oldun !";
        } elseif (strcmp($_GET['action'], 'login') === 0) {
            $query = $db->prepare("SELECT * FROM users where username = ? AND password = ?");
            $query->bindParam(1, $_POST['username']);
            $query->bindParam(2, $_POST['password']);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                setcookie("logged_user", $result["id"], time() + (86400 * 30), "/");
            }
            header("Location: panel.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
   <head>
      <meta charset="UTF-8">
      <title>Sign-Up/Login Form</title>
      <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <div class="form">
         <ul class="tab-group">
            <li class="tab active"><a href="#signup">Sign Up</a></li>
            <li class="tab"><a href="#login">Log In</a></li>
         </ul>
         <div class="tab-content">
            <div id="signup">
               <h1>Sign Up for Free</h1>
               <form action="?action=register" method="post">
                  <!-- <div class="top-row">
                     <div class="field-wrap">
                        <label>
                        First Name<span class="req">*</span>
                        </label>
                        <input type="text" required autocomplete="off" />
                     </div>
                     <div class="field-wrap">
                        <label>
                        Last Name<span class="req">*</span>
                        </label>
                        <input type="text"required autocomplete="off"/>
                     </div>
                  </div> -->
                  <div class="field-wrap">
                     <label>
                     Email Address<span class="req">*</span>
                     </label>
                     <input type="email" name="username" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                     <label>
                     Set A Password<span class="req">*</span>
                     </label>
                     <input type="password" name="password" required autocomplete="off"/>
                  </div>
                  <button type="submit" class="button button-block"/>Get Started</button>
               </form>
            </div>
            <div id="login">
               <h1>Welcome Back!</h1>
               <form action="?action=login" method="post">
                  <div class="field-wrap">
                     <label>
                     Email Address<span class="req">*</span>
                     </label>
                     <input type="email" name="username" required autocomplete="off"/>
                  </div>
                  <div class="field-wrap">
                     <label>
                     Password<span class="req">*</span>
                     </label>
                     <input type="password" name="password" required autocomplete="off"/>
                  </div>
                  <!-- <p class="forgot"><a href="#">Forgot Password?</a></p> -->
                  <button class="button button-block"/>Log In</button>
               </form>
            </div>
         </div>
         <!-- tab-content -->
      </div>
      <!-- /form -->
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script  src="js/index.js"></script>
      <?php if($alert){ ?>
      <script>alert('<?php echo $alert; ?>')</script>
      <?php } ?>
   </body>
</html>
