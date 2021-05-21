<?php 
    require 'config/config.php';
?>


<?php include('header.php') ?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php if(!empty($_SESSION['cart'])): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total = 0; 
                                ?>
                                <?php foreach($_SESSION['cart'] as $key => $qty): ?>
                                    <?php 
                                        $id = str_replace('id','',$key);
                                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                        $stmt->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total += $result['price'] * $qty; 
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="admin/images/<?php echo $result['image'] ?>" width="100" height="100" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <p><?php echo $result['name'] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5><?php echo '$ '.$result['price'] ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <input type="text" name="qty" id="sst" maxlength="12" value="<?php echo $qty ?>" title="Quantity:"
                                                    class="input-text qty" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <h5><?php echo '$ '.$result['price'] * $qty ?></h5>
                                        </td>
                                        <td>
                                            <a  href="cart_item_clear.php?pid=<?php echo $result['id'] ?>" class="primary-btn" style="line-height: 30px;border-radius: 10px;">Clear</a>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5><?php echo '$ '.$total ?></h5>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="out_button_area">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center">
                                            <a class="gray_btn" href="clearall.php">Clear All</a>
                                            <a class="primary-btn" href="index.php">Continue Shopping</a>
                                            <a class="gray_btn" href="sale_order.php">Order Submit</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

  
    <!-- start footer Area -->
<?php include('footer.php') ?>
