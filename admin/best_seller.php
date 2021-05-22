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

  $stmt = $pdo->prepare("SELECT * FROM sale_orders_detail WHERE quantity > 3");
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
                  <h3>Best Seller Product</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered" id="j-table">
                  <thead>
                    <th>id</th>
                    <th>Product</th>
                    <th>Quantity</th>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                        <?php foreach($result as $value): ?>
                            <?php $i = 1 ?>
                            <?php
                                $proStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                                $proStmt->execute();
                                $proResult = $proStmt->fetchAll();
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo escape($proResult[0]['name']) ?></td>
                                    <td><?php echo escape($value['quantity']) ?></td>
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