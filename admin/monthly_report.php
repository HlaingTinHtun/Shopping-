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

  $current_date = date("Y-m-d");
  $from_date = date("Y-m-d",strtotime($current_date . '+1 day'));
  $to_date = date("Y-m-d",strtotime($current_date . '-1 month'));

  $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE order_date < :from_date AND order_date >= :to_date ORDER BY id DESC");
  $stmt->execute(
      array(':from_date'=>$from_date, ':to_date'=>$to_date)
  );
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
                  <h3>Monthly Reports</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered" id="j-table">
                  <thead>
                    <th>id</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                        <?php $i = 1 ?>
                        <?php foreach($result as $value): ?>
                            <?php
                                $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                                $userStmt->execute();
                                $userResult = $userStmt->fetchAll();
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo escape($userResult[0]['name']) ?></td>
                                <td><?php echo escape($value['total_price']) ?></td>
                                <td><?php echo escape(date("Y-m-d", strtotime($value['order_date']))) ?></td>
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