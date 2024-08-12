<?php
  session_start();
  include "connection.php";

  $user_details = getUser($_SESSION["user_id"]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Minimart Catalog | Profile</title>
</head>
<body>

<!-- insert navbar here -->
 <?php include "main-nav.php"; ?>
 <div class="container py-4">
  <?php
    if(isset($_POST["btn_submit"]))
    {
      //INPUT
      $file_name = $_FILES["photo"]["name"];
      $file_tmp = $_FILES["photo"]["tmp_name"];

      //PROCESS
      uploadPhoto($file_name,$file_tmp,$_SESSION["user_id"]);
    }
  
  ?>
  <div class="card w-25 mx-auto">
    <?php
      $photo = "default.jpeg";

      if($user_details["photo"] != NULL)
      {
        $photo = $user_details["photo"];
      }
    ?>


    <img src="assets/images/<?= $photo; ?>" alt="" class="card-img-top">
    <div class="card-body">
      <h1 class="card-title h4"><?= $user_details["first_name"]." ".$user_details["last_name"] ?></h1>
      <h2 class="card-subtitle text-muted h6 fst-italic mb-5"><?= $user_details["username"] ?></h2>
      <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" id="photo" class="form-control mb-3">
        <input type="submit" value="Submit" name="btn_submit" class="btn btn-primary w-100">
      </form>
    </div>
  </div>
 </div>
  
</body>
</html>

<?php
  function getUser($user_id)
  {
    $conn = connection();
    $sql  = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
  }

  function uploadPhoto($file_name,$file_tmp,$user_id){
    $conn = connection();
    $sql  = "UPDATE users SET photo = '$file_name' WHERE id = $user_id";
    $result = $conn->query($sql);

    if($result)
    {
      $destination = "assets/images/".$file_name;
      move_uploaded_file($file_tmp,$destination);
      header("Refresh:0"); //reload page
    }
    else
    {
     //display error message
     echo "<div class='alert alert-danger w-50 mx-auto text-center'>Upload failed.<br><small>".$conn->$error."</small></div>";
    }
  }
?>