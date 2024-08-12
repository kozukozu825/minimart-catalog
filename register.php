<?php
   include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Minimart Catalog | Register</title>
</head>
<body>
   <div class="container py-5">
    <?php
    //form handling - get the data from the form
    if( isset($_POST["btn_register"]))
    {
       //INPUT
       $first_name = $_POST["first_name"];
       $last_name = $_POST["last_name"];
       $username = $_POST["username"];
       $password = $_POST["password"];
       $confirm_password = $_POST["confirm_password"];

       //PROCESS
       if($password == $confirm_password) //check if the passwords match
       {
           register($first_name, $last_name, $username, $password);
        }
        else
       {
          //display an error message
          echo "<div class='alert alert-danger w-50 mx-auto text-center'>Passwords do not match. Kindly try again.</div>";
       }
    }
    ?>
    <div class="card w-25 mx-auto">
      <div class="card-header">
        <h1 class="card-title h4">Register</h1>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <label for="first_name" class="form-label">First Name</label>
          <input type="text" name="first_name" id="first_name" class="form-control form-control-sm mb-3" required>
          <label for="last_name" class="form-label">Last Name</label>
          <input type="text" name="last_name" id="last_name" class="form-control form-control-sm mb-3" required>
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control form-control-sm mb-3" required>
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control form-control-sm mb-3" required>
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-sm mb-3" required>
          <input type="submit" value="Register" name="btn_register" class="btn btn_sm btn-primary w-100">
        </form>
      </div>
    </div>
   </div>
</body>
</html>
<?php
   function register($first_name, $last_name, $username, $password)
   {
      $conn = connection();
      $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users(first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$encrypted_password')";

      $result = $conn->query($sql);

      if($result)
      {
        header("Location:login.php"); //redirect to login page    
      }
      else
      {
        //display an error message
        echo "<div class='alert alert-danger w-50 mx-auto'>Registration failed.<br><small>".$conn->error."</small></div>";
      }
    }



?>