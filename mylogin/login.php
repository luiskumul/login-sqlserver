<?php
   include("db_conn.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {

      // obtener el nombre de usuario y contraseña enviados desde el POST
      $myemail    = $_POST['email'];
      $mypassword = $_POST['password']; 
      
      $sql = "SELECT nombre FROM usuarios WHERE email = '$myemail' and password = '$mypassword'";
      $params = array();
      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
      $result = sqlsrv_query($conn,$sql, $params, $options);

      $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
      $usrName = $row['nombre'];
      
      $count = sqlsrv_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		if ($count === false ) {
         echo "Error in retrieveing row count.";
      } else if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $usrName;
         
         header("location: index.php");
      }else {
         $error = "Your Login Email or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   </head>
   
   <body>
	
   <div class="container">
      <form class="form-horizontal" method="post">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Sign in</button>
          </div>
        </div>
        <div> <?php if (isset($error)) {
           echo $error;
        } ?> </div>
      </form>
   </div>

   <!-- Scripts -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

   </body>
</html>