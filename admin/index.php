<?php

  session_start();
  require '../config/config.php';
  require '../config/common.php';

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('location: login.php');
  }

  
  

?>


<?php include('header.php') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                  <h3>Blog</h3>
              </div>
              <div class="card-body">
                <a href="add.php" type="button" class="btn btn-primary">Create Blog Post</a>
                <table class="table table-bordered table-dark mt-3">
                  <thead>
                    <td>id</td>
                    <td>Title</td>
                    <td>Content</td>
                    <td>Actions</td>
                  </thead>
                    
                  
                </table>
                <br>
                <!-- pagination -->
                

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