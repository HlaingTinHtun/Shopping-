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
       if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4 || empty($_POST['phone']) || empty($_POST['address'])) {
           if(empty($_POST['name'])) {
               $nameError = "Name is required";
           }
           if(empty($_POST['email'])) {
               $emailError = "Email is required";
           }
            if(empty($_POST['password'])) {
                $passError = "Password is required";
            } elseif(strlen($_POST['password']) < 4) {
                $passError = "Password must be at least 4 characters or digits";
            }
            if(empty($_POST['phone'])) {
                $phoneError = "Phone is required";
            }
            if(empty($_POST['address'])) {
                $addressError = "Address is required";
            }   
       } else {
           $name = $_POST['name'];
           $email = $_POST['email'];
           $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
           $phone = $_POST['phone'];
           $address = $_POST['address'];
           if(empty($_POST['role'])) {
               $role = 0;
           } else {
               $role = 1;
           }

           $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
           $stmt->bindParam(':email', $email);
           $stmt->execute();
           $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if($user) {
               echo "<script>alert('Email is already exists');</script>";
           } else {
               $stmt = $pdo->prepare("INSERT INTO users (name, email, password, address, role, phone) VALUES (:name, :email, :password, :address, :role, :phone)");
               $result = $stmt->execute(
                   array(':name'=>$name, ':email'=>$email, ':password'=>$password, ':address'=>$address, ':role'=>$role, ':phone'=>$phone)
               );

               if($result) {
                echo "<script>alert('User is Added successfully!');window.location.href='user_list.php';</script>";
               }
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
                <form action="user_add.php" method="post" enctype="multipart/form-data"> 
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="form-group">
                        <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Email</label><p style="color:red"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Password</label><p style="color:red"><?php echo empty($passError) ? '' : '*'.$passError; ?></p>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Phone</label><p style="color:red"><?php echo empty($phoneError) ? '' : '*'.$phoneError; ?></p>
                        <input type="number" name="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Address</label><p style="color:red"><?php echo empty($addressError) ? '' : '*'.$addressError; ?></p>
                        <textarea name="address" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Admin</label>
                        <input type="checkbox" name="role" value="1">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Submit">
                        <a href="user_list.php" type="button" class="btn btn-warning">Back</a>
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