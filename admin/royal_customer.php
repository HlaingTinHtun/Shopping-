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

  $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE total_price > 100");
  $stmt->execute();
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
                  <h3>Royal Customer</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered" id="j-table">
                  <thead>
                    <th>id</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                        <?php foreach($result as $value): ?>
                            <?php $i = 1 ?>
                            <?php
                                $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                                $userStmt->execute();
                                $userResult = $userStmt->fetchAll();
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo escape($userResult[0]['name']) ?></td>
                                    <td><?php echo escape('$ ' . $value['total_price']) ?></td>
                                </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
                <br>

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

<script>
    $(document).ready(function() {
        $('#j-table').DataTable();
    } );
</script>