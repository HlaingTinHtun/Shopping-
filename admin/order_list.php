<?php

    session_start();
    require '../config/config.php';
    require '../config/common.php';

    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('location: login.php');
    }

    if($_SESSION['role'] != 1) {
      header('location: login.php');
    }


    // pagination
    if(!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
    } else {
    $pageno = 1;
    }

    $numofrecs = 2;
    $offset = ($pageno -1) * $numofrecs;

  
    $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
    $stmt -> execute();
    $raw_result = $stmt->fetchAll(); 
    $total_pages = ceil(count($raw_result)/$numofrecs);

    $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numofrecs");
    $stmt -> execute();
    $result = $stmt->fetchAll(); 
  
   
  

?>


<?php include('header.php') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                  <h3>Order Listings</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-dark mt-3">
                  <thead>
                    <td>id</td>
                    <td>User</td>
                    <td>Total Price</td>
                    <td>Actions</td>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                        <?php foreach($result as $value): ?>
                            <?php
                                $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                                $userStmt->execute();
                                $userResult = $userStmt->fetchAll();
                            ?>
                            <tr>
                              <td><?php echo escape($value['id']) ?></td>
                              <td><?php echo escape($userResult[0]['name']) ?></td>
                              <td><?php echo escape($value['total_price']) ?></td>
                              <td>
                                  <a href="order_detail.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-success">View</a>
                              </td>
                            </tr>
                        <?php endforeach; ?>    
                        <?php else: ?>
                    <?php endif; ?>   
                  </tbody>  
                  
                </table>
                <br>
                <!-- pagination -->
                <nav aria-label="Page navigation example" style="float:right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pgaeno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1 ) {echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1) {echo '#';} else {echo '?pageno='.($pageno - 1); } ?>">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';} else {echo '?pageno='.($pageno + 1);} ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
                  </ul>
                </nav>

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