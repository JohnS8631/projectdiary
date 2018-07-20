<?php
session_start();
$dcontent="";
if(array_key_exists('id',$_COOKIE))
{
  $_SESSION['id']=$_COOKIE['id'];
}
if(array_key_exists('id',$_SESSION))
{
  echo $_SESSION['id'];
  echo "<p id='kl'>Logged In!!<a href='index.php?logout=1'><button id='lop' class='btn btn-success' type='submit'>Log Out</button></a></p>";
  include("connection.php");
  $query="SELECT diary_contents FROM PROJECTDIARY WHERE id=11";
  $row=mysqli_fetch_array(mysqli_query($link,$query));
  $dcontent=$row['diary_contents'];
}
else
{
  header("Location:index.php");
}
include("headers.php");
?>
<div class="container">
  <textarea id="diary" class="form-control"><?php echo $dcontent; ?></textarea> 
</div>
<?php
include("footer.php");
?>

    
    
