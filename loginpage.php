<?php
session_start();
$dcontent="";
if(array_key_exists('emailad',$_SESSION))
{
  echo "<p id='kl'>Logged In!!<a href='index.php?logout=1'><button id='lop' class='btn btn-success' type='submit'>Log Out</button></a></p>";
  include("connection.php");
  $query="SELECT diary_contents FROM PROJECTDIARY WHERE email='".mysqli_real_escape_string($link,$_SESSION['emailad'])."'";
  $result=mysqli_query($link,$query);
  $row=mysqli_fetch_array($result);
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

    
    
