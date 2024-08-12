<?php
 session_start();

 if(empty($_SESSION)){
  session_unset();
  session_destroy();

  header("location: login.php");
  exit;
}

require 'connection.php';

$id        = $_GET['id'];
$product   = getProduct($id);

function getProduct($id){
  $conn = connection();
  $sql  = "SELECT * FROM products WHERE id = $id";
  
  if($result = $conn->query($sql)){
     return $result->fetch_assoc();
  }else{
    die('Error retrieving the product: ' .$conn->error);
  }
}

function getAllSections(){
  $conn = connection();
  $sql  = "SELECT * FROM sections";

  if($result = $conn->query($sql)){
    return $result;
  }else{
    die('Error retrieving all sections: ' . $conn->error);
  }
}

function updateProduct($id, $name, $description, $price, $section_id){
    $conn  = connection();
    $sql   = "UPDATE products SET name = '$name', description = '$description', price = $price, section_id = $section_id WHERE id = $id";

    if($conn->query($sql)){
      header('location: products.php');
      exit;
    }else{
      die('Error updating the product: ' .$conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Edit Product</title>
</head>
<body>
<?php
    include 'main-nav.php';
  ?>

  <main class="container">
    <div class="row justify-content-center">
      <div class="col-3">
        <h2 class="fw-light mb-3">Edit Product</h2>

        <form action="" method="post">
          <div class="mb-3">
            <label for="name" class="form-label small fw-bold">Name</label>
            <input type="text" name="name" id="name" value=<?= $product['name'] ?> maxlength="50" class="form-control" required autofocus>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label small fw-bold">Description</label>
            <textarea name="description" id="description" row="5" class="form-control"><?= $product['description']?></textarea>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label small fw-bold">Price</label>
            <div class="input-group">
                <div class="input-group-text">$</div>
                <input type="number" name="price" id="price" value="<?= $product['price'] ?>"  class="form-control" step="any" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="section-id" class="form-label small fw-bold">Section</label>
            <select name="section_id" id="section_id" class="form-select" required>
              <option value="" hidden>Select Section</option>
              <?php
              $all_sections = getAllSections();
              while($section = $all_sections->fetch_assoc()){
                if($section['id'] == $product['section_id']){
                ?>
                <option value="<?= $section['id'] ?>" selected><?= $section['name'] ?></option>
                <?php
                }else{
                ?>
                <option value="<?= $section['id'] ?>"><?= $section['name'] ?></option>
                <?php
                }

            }
            ?>
            </select>
          </div>
          
          <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
          <button type="submit" class="btn btn-secondary fw-bold" name="btn_update">
            <i class="fas fa-checl"></i> Save Changes
          </button>
        </form>
        <?php
          
          if(isset($_POST['btn_update'])){
            $id                = $_GET['id'];
            $name              = $_POST['name'];
            $description       = $_POST['description'];
            $price             = $_POST['price'];
            $section_id        = $_POST['section_id'];

            updateProduct($id, $name, $description, $price, $section_id);
          }
        ?>
      </div>
    </div>
  </main>
</body>
</html>