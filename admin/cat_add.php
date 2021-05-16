<?php
 
    session_start();
    require '../config/config.php';
    require '../config/common.php';

    //  if user don't login, cann't enter the system
    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
        header('location: login.php');
    }


    if($_POST) {
       if(empty($_POST['name']) || empty($_POST['description'])) {
           if(empty($_POST['name'])) {
               $nameError = "Name is required";
           }
           if(empty($_POST['description'])) {
               $descError = "Description is required";
           }
       } else {
           $name = $_POST['name'];
           $desc = $_POST['description'];

           $stmt = $pdo->prepare("INSERT INTO categories(name, description) VALUES(:name, :description)");
           $result = $stmt->execute(
               array(':name'=>$name, ':description'=>$desc)
           );

           if($result) {
               echo "<script>alert('Successfully!.Category is added');window.location.href='category.php';</script>";
           }
       }
    }

?>



<?php include('header.php') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="cat_add.php" method="post" enctype="multipart/form-data"> 
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="form-group">
                        <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Description</label><p style="color:red"><?php echo empty($descError) ? '' : '*'.$descError; ?></p>
                        <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="button-group">
                        <input type="submit" class="btn btn-success" value="Submit">
                        <a href="category.php" type="button" class="btn btn-warning">Back</a>
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