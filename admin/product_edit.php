<?php
 
    session_start();
    require '../config/config.php';
    require '../config/common.php';

    //  if user don't login, cann't enter the system
    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
        header('location: login.php');
    }

    if($_SESSION['role'] != 1) {
        header('location: login.php');
    }


    if($_POST) {
        if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_FILES['image'])) {
            if(empty($_POST['name'])) {
                $nameError = "Name is required";
            }
            if(empty($_POST['description'])) {
                $descError = "Description is required";
            }
            if(empty($_POST['category'])) {
                $catError = "Category is required";
            }
            if(empty($_POST['price'])) {
                $priceError = "Price is required";
            } elseif(is_numeric($_POST['price']) != 1) {
                $priceError = "Price must be integer value";
            }
            if(empty($_POST['quantity'])) {
                $qtyError = "Quantity is required";
            } elseif(is_numeric($_POST['quantity']) != 1) {
                $qtyError = "Quantity must be integer value";
            }

        } else {
            if(is_numeric($_POST['price']) != 1) {
                $priceError = "Price must be integer value";
            }
            if(is_numeric($_POST['quantity']) != 1) {
                $qtyError = "Quantity must be integer value";
            }

            if($priceError == '' && $qtyError == '') {
                if($_FILES['image']['name'] != null) {
                    $file = 'images/'.($_FILES['image']['name']);
                    $imageType = pathinfo($file, PATHINFO_EXTENSION);
    
                    if($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
                        echo "<script>alert('Images must be jpg,jpeg or png');</script>";
                    } else {
                        $id = $_POST['id'];
                        $name = $_POST['name'];
                        $desc = $_POST['description'];
                        $category = $_POST['category'];
                        $price = $_POST['price'];
                        $quantity = $_POST['quantity'];
                        $image = $_FILES['image']['name'];
    
                        move_uploaded_file($_FILES['image']['tmp_name'], $file);
    
                        $stmt = $pdo->prepare("UPDATE products SET name='$name', description='$desc', category_id='$category', price='$price', quantity='$quantity', image='$image' WHERE id='$id'");
                        $result = $stmt->execute();
    
                        if($result) {
                            echo "<script>alert('Product is updated successfully');window.location.href='index.php';</script>";
                        }
                    }
                } else {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $desc = $_POST['description'];
                    $category = $_POST['category'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];
    
                    $stmt = $pdo->prepare("UPDATE products SET name='$name', description='$desc', category_id='$category', price='$price', quantity='$quantity' WHERE id='$id'");
                    $result = $stmt->execute();
    
                    if($result) {
                        echo "<script>alert('Product is updated successfully');window.location.href='index.php';</script>";
                    }
                }
            }
        }
    }

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();

?>



<?php include('header.php') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data"> 
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <div class="form-group">
                        <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                        <input type="text" name="name" class="form-control" value="<?php echo escape($result[0]['name']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Description</label><p style="color:red"><?php echo empty($descError) ? '' : '*'.$descError; ?></p>
                        <textarea name="description" class="form-control" id="" cols="30" rows="10"><?php echo escape($result[0]['description']) ?></textarea>
                    </div>    

                    <div class="form-group">
                    <!-- select category_id -->
                        <?php
                            $catStmt = $pdo->prepare("SELECT * FROM categories");
                            $catStmt->execute();
                            $catResult = $catStmt->fetchAll();
                        ?>

                        <label for="">Category</label><p style="color:red"><?php echo empty($catError) ? '' : '*'.$catError; ?></p>
                        <select name="category" id="" class="form-control">
                            <option value="">Select Category</option>
                            <?php foreach($catResult as $value): ?>
                                <?php if($value['id'] == $result[0]['category_id']): ?>
                                    <option value="<?php echo $value['id'] ?>" selected><?php echo $value['name'] ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>    
                        </select>
                    </div>                

                    <div class="form-group">
                        <label for="">Price</label><p style="color:red"><?php echo empty($priceError) ? '' : '*'.$priceError; ?></p>
                        <input type="number" name="price" class="form-control" value="<?php echo escape($result[0]['price']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Quantity</label><p style="color:red"><?php echo empty($qtyError) ? '' : '*'.$qtyError; ?></p>
                        <input type="number" name="quantity" class="form-control" value="<?php echo escape($result[0]['quantity']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Image</label><p style="color:red"><?php echo empty($imageError) ? '' : '*'.$imageError; ?></p>
                        <img src="images/<?php echo escape($result[0]['image']) ?>" alt="" width="150" height="150"><br><br>
                        <input type="file" name="image">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Submit">
                        <a href="index.php" type="button" class="btn btn-warning">Back</a>
                    </div>
                </form>
              </div>
            </div>
          </div>
  
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
<?php include('footer.php') ?>