<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
      $(".toggleforms").click(function()
                                {
      
        $("#signupform").toggle();
        $("#loginform").toggle();
      });
  $('#diary').on("change keyup paste", function() {
      $.ajax({
        method:"POST",
        url:"updatedatabase.php",
        data:{
          content:$("#diary").val()
        }
        });
  });
    </script>
