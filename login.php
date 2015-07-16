<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');

define("BASE_URL", 'http://maalgaadi.net/newTest/newTestLi/');
define("BASE_PATH", 'http://maalgaadi.net/newTest/newTestLi/');

define("IMAGE_URL", BASE_URL . "images/");
define("IMAGE_LOC", BASE_PATH . "images/");

include 'includes/common_functions.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include "includes/head.php"; ?>
    </head>
    <body style="background:none;">
        <div id="top">
            <div class="fixed"> <a href="" target = "_blank" title="" class="logo"><img src="images/logo.png" alt="" /><span id="blue"></span></a>

            </div>
        </div>
        <div class="login_m" align="center">
            <h1 class="txts1">Log In</h1>
            <form action="" style="margin-top:4%;" id="loginForm">
                <input type="email" name="email" id="email" class="ibox1" placeholder="Enter your Email Id" required/>
                <input type="password" name="passowrd" id="password" class="ibox1" placeholder="Enter your Password" required />
                <input type="button" value="submit" class="btn2" onClick="login('loginForm')" />
                <br/>
                <a href="#">Forgot Password?</a><br/>
                <div id="result" style="height: 20px;"></div>
                
            </form>
        </div>
        <!-- Footer -->
        <script>
        $(document).ready(function() {
     
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      login('loginForm')
      return false;
    }
  });
});
        </script>
        <?php include "includes/footer.php"; ?>
        <!-- /footer -->
    </body>
</html>