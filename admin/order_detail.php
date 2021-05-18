<?php

    session_start();
    require '../config/config.php';
    require '../config/common.php';

    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
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

  
    $stmt = $pdo->prepare("SELECT * FROM sale_orders_detail WHERE sale_order_id=".$_GET['id']);
    $stmt -> execute();
    $raw_result = $stmt->fetchAll(); 
    $total_pages = ceil(count($raw_result)/$numofrecs);

    $stmt = $pdo->prepare("SELECT * FROM sale_orders_detail WHERE sale_order_id=".$_GET['id']." LIMIT $offset,$numofrecs");
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
                  <h3>Order Detail</h3>
              </div>
              <div class="card-body">
                <a href="order_list.php" type="button" class="btn btn-secondary">Back</a>
                    <table class="table table-bordered table-dark mt-3">
                        <thead>
                            <td>id</td>
                            <td>Product</td>
                            <td>Quantity</td>
                            <td>Order Date</td>
                        </thead>
                        <tbody>
                            <?php if($result): ?>
                                <?php foreach($result as $value): ?>
                                    <?php
                                        $proStmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                                        $proStmt->execute();
                                        $proResult = $proStmt->fetchAll();
                                    ?>
                                    <tr>
                                    <td><?php echo escape($value['id']) ?></td>
                                    <td><?php echo escape($proResult[0]['name']) ?></td>
                                    <td><?php echo escape($value['quantity']) ?></td>
                                    <td><?php echo escape(date('d-m-Y',strtotime($value['order_date']))) ?></td>
                                    </tr>
                                <?php endforeach; ?>    
                                <?php else: ?>
                            <?php endif; ?>   
                        </tbody>  
                    
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