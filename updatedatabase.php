
<?php
session_start();
if(array_key_exists("content",$_POST) && array_key_exists('emailad',$_SESSION))
{
  include("connection.php");
  $query="UPDATE  PROJECTDIARY SET diary_contents='".mysqli_real_escape_string($link,$_POST['content'])."' WHERE email='".mysqli_real_escape_string($link,$_SESSION['emailad'])."'";
  mysqli_query($link,$query);
}
?>
