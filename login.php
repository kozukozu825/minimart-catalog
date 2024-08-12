<?php
  include "connection.php";

  function login($username, $password){
    $conn = connection();
    $sql = "SELECT * FROM users WHERE username = '$username'";

    if($result = $conn->query($sql)){
      #Check if the username exists.
      if($result->num_rows ==1){
        $user = $result->fetch_assoc();

        #Check if the password is correct.
        if(password_verify($password, $user['password'])){
          /********* SESSION ********/
          session_start();

          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

          header("location: products.php");
          exit;
        }else{
          echo "<div class='alert alert-danger'>Incorrect password.</div>";
        }
      }else{
        echo "<div class='alert alert-danger'>Username not found.</div>";
      }
    }else{
      die("Error retrieving the user: " . $conn->error);  
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Minimart Catalog | Login</title>
</head>
<body>
  <div class="container py-5">
    <div class="card w-25 mx-auto">
      <div class="card-header">
        <h1 class="card-title h4">Login</h1>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control form-control-sm mb-3" required>
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control form-control-sm mb-3" required>
          <input type="submit"  value="Login" name="btn_log_in" class="btn btn-sm btn-success w-100 mb-3">

          <a href="register.php" class="btn btn-danger btn-sm">Create Account</a>
        </form>

        <?php
        if(isset($_POST['btn_log_in'])){
          $username = $_POST['username'];
          $password = $_POST['password'];

          login($username, $password);
        }

        ?>

      </div>
    </div>
  </div>
  
</body>
</html>