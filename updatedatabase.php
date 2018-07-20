<?php
session_start();
if(array_key_exists("content",$_POST))
{
  include("connection.php");
  $query="UPDATE  PROJECTDIARY SET diary_contents='".mysqli_real_escape_string($link,$_POST['content'])."' WHERE id=11";
  mysqli_query($link,$query);
}
?>
