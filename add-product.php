<?php
 session_start();

 if(empty($_SESSION)){
  session_unset();
  session_destroy();

  header("location: login.php");
  exit;
}

require 'connection.php';
function getAllSections(){
  $conn = connection();
  $sql = "SELECT * FROM sections";

  if($result = $conn->query($sql)){
    return $result;
  }else{
    die("Error retrieving all sections:" . $conn->error);
  }
}

function createProduct($name, $description, $price, $section_id){
  $conn = connection();
  $sql = "INSERT INTO products (name, description, price, section_id)
  VALUES ('$name', '$description', $price, $section_id)";

  if($conn->query($sql)){
    header('location: product.php');
    exit;
  }else{
    die('Error adding a new product:'. $conn->error);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
    include 'main-nav.php';
  ?>

   <div class="container">
    <div class="row">
      <div class="col">
        <div class="card w-25 mx-auto border-0">
          <div class="card-header">
            <h2 class="fw-light mb-3">New Product</h2>
          </div>

          <div class="card-body">
            <form action="" method="post">
              <div class="bm-3">
                <label for="name" class="form-label small fw-bold">Name</label>
                <input type="text" name="name" id="name" class="form-control" max="50" required>
              </div>

              <div class="bm-3">
                <label for="description" class="form-label small fw-bold">Description</label>
                <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
              </div>

              <div class="mb-3">
                <label for="price" class="form-label small fw-bold">Price</label>
                <div class="input-group">
                  <div class="input-group-text">$</div>
                  <input type="number" name="price" class="form-control" step="any" required>
                </div>
              </div>

              <div class="mb-4">
                <label for="section-id" class="form-label small fw-bold">Section</label>
                <select name="section_id" id="section-id" class="form-select" required>
                  <option value="" hidden>Select Section</option>
                  <?php 
                  $all_sections = getAllSections();
                  while($section = $all_sections->fetch_assoc()){
                    //fetch_assoc() -->transform the result into an associative 
                    // $section - holds the value of each column of a record
                    echo "<option value='".$section['id']."'>".$section['name']."</option>";
                  }
                  ?>
                </select>
              </div>
              <a href="products.php" class="btn btn-outline-success">Cancel</a>
              <button type="submit" name="btn_add" class="btn btn-success fw-bold px-5">
                <i class="fa-solid fa-plus"></i> Add
             </button>
            </form>
            <?php
              if(isset($_POST['btn_add'])){
                $name            = $_POST['name'];
                $description     = $_POST['description'];
                $price           = $_POST['price'];
                $section_id      = $_POST['section_id'];

                createProduct($name, $description, $price, $section_id);     
              }
            ?>
          </div>
        </div>
      </div>
    </div>
   </div>
</body>
</html>