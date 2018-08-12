<?php
$error="";
$missing="";
$success="";
session_start();
if(array_key_exists('logout',$_GET))
{
  unset($_SESSION);
  setcookie("id","",time()-60*60*24*365);
  $_COOKIE['id']="";
  session_destroy();
}
else if((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id']))
{
  header("Location:loggedinpage.php");
}
if(array_key_exists('submit',$_POST))
{
  include("connection.php");
  if(!$_POST['emailad'])
  {
    $missing.="The email address field is empty<br>";
  }
  if(!$_POST['passwd'])
  {
    $missing.="The password field is empty<br>";
  }
  if($_POST['emailad'] AND filter_var($_POST['emailad'],FILTER_VALIDATE_EMAIL)==false)
  {
    $error.="The email address you entered is incorrect<br>";
  }
  $regex="/[A-Z]/";
  if(!preg_match($regex,$_POST['passwd']))
  {
    $error.="The password needs to contain atleast one Capital Alphabet<br>";
  }
  $regex="/[a-z]/";
  if(!preg_match($regex,$_POST['passwd']))
  {
    $error.="The password needs to contain atleast one Lowercase Alphabet<br>";
  }
  $regex="/[0-9]/";
  if(!preg_match($regex,$_POST['passwd']))
  {
    $error.="The password needs to contain atleast one Numeric Digit<br>";
  }
  $regex="/[#$%&!^?_]/";
  if(!preg_match($regex,$_POST['passwd']))
  {
    $error.="The password needs to contain atleast one Special Character<br>";
  }
  if($missing!="")
  {
    $missing='<div class="alert alert-warning">'."<p>There were some fields missing in the form:</p>".$missing.'</div>';
  }
  if($error!="")
  {
    $error='<div class="alert alert-danger">'."<p>There were some errors in the form:</p>".$error.'</div>';
  }
  else
  {
    if($_POST['signup']=='1')
   {
    $query="SELECT id FROM PROJECTDIARY WHERE email='".mysqli_real_escape_string($link,$_POST['emailad'])."' LIMIT 1";
    $result=mysqli_query($link,$query);
    if(mysqli_num_rows($result)>0)
    {
      $error.="This email address is already registered with us!!";
    }
    else
    {
      $query="INSERT INTO PROJECTDIARY (`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['emailad'])."','".mysqli_real_escape_string($link,$_POST['passwd'])."')";
      if(!mysqli_query($link,$query))
      {
        $error.="There was some error signing you up,Try again later after some time";
      }
      else
      {
        $query="UPDATE PROJECTDIARY SET password='".password_hash($_POST['passwd'],PASSWORD_BCRYPT)."' WHERE id=".mysqli_insert_id($link)."";
        mysqli_query($link,$query);
        $success.="You have been successfully signed up with us!!";
        $_SESSION['id']=mysqli_insert_id($link);
        if($_POST['keeploggedin']=='1')
        {
          setcookie("id",mysqli_insert_id($link),time()+60*60*24*365);
        }
           header("Location:loggedinpage.php");
      }
    }
   }
    else
    {
     $query="SELECT * FROM PROJECTDIARY WHERE email='".mysqli_real_escape_string($link,$_POST['emailad'])."'";
       $result=mysqli_query($link,$query);
       $row=mysqli_fetch_array($result);
         if(password_verify($_POST['passwd'],$row['password']))
         {
          header("Location:loggedinpage.php");
        $query1="SELECT * FROM PROJECTDIARY WHERE email='".mysqli_real_escape_string($link,$_POST['emailad'])."'";
        $myresult=mysqli_query($link,$query1);
        $myrow=mysqli_fetch_array($myresult);
        $_SESSION['emailad']=$myrow['email'];
         }
        else
         {
         $error.="Entered password is incorrect";
         }
     }
}
   if($error!="")
  {
    $error='<div class="alert alert-danger">'."<p>There were some errors in the form:</p>".$error.'</div>';
  }
  if($success!="")
  {
    $success='<div class="alert alert-success">'."<p>Congrats:</p>".$success.'</div>';
  }
}

?>
 <!doctype html>
<html lang="en">
<?php include("headers.php"); ?>
  <body>
     <!-- Begin Web-Stat code v 6.3 -->
<span id="wts1768075">&nbsp;</span><script>
var wts=document.createElement('script');wts.type='text/javascript';
wts.async=true;wts.src='https://wts.one/5/1768075/log6_2.js';
document.getElementById('wts1768075').appendChild(wts);
</script><noscript><a href="https://www.web-stat.com">
<img src="//wts.one/6/5/1768075.gif" 
style="border:0px;" alt="Web-Stat traffic analytics"></a></noscript>
<!-- End Web-Stat code v 6.3 -->
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <div class="container"  id="signupform">
      
      <form method="post">
        <h1 id="fy">Secret Diary</h1>
        <h2 id="hu">Store your thoughts permanently and securely.</h2>
        <h3 id="er">Interested?Sign up now.</h3>
        <div id="missing"><?php echo $missing ?></div>
        <div id="error"><?php echo $error ?></div>
       <div id="success"><?php echo $success ?></div>
        <div class="rty">
         <input type="email" id="emailad" name="emailad"  placeholder="Your Email">
        </div>
        <div class="wer">
         <input type="password" id="passwd" name="passwd"  placeholder="Password">
        </div>
        <input type="hidden" name="signup" value="1">
        <input type="checkbox" id="keeploggedin" name="keeploggedin" value=1><p id="loggtext"> Keep me logged in</p>
        <button class="btn btn-primary" type="submit" id="lo" name="submit" value="signup">SIGNUP</button>
      </form>
    </div>
    <div class="container" id="loginform">
    <form method="post">
      <h4 id="gh">Login using your credentials used at the time of signing up!</h4>
      <div class="rty">
         <input type="email" id="emailad" name="emailad" placeholder="Your Email">
        </div>
        <div class="wer">
         <input type="password" id="passwd" name="passwd"  placeholder="Password">
        </div>
        <input type="hidden" name="signup" value="0">
        <input type="checkbox" id="keeploggedin" name="keeploggedin" value=1><p id="loggtext"> Keep me logged in</p>
        <button class="btn btn-success" type="submit" id="lo" name="submit" value="signup">LOGIN</button>
      <p name="forgot" id="fpassw"><a href="forgot_password.php">CHANGE PASSWORD</a></p>
    </form>
    </div>
   <?php include("footer.php");
          ?>
    <center>
       <b id="mkl"><center>&copy;2018,NIKHIL KUMAR WORKS</center></b>
          </center>
  </body>
</html>
