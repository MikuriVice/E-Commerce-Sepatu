<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper">
        <div class="container">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-sm-9">
                        <h1 class="page-header">YOUR CART</h1>
                        <div class="box box-solid">
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th width="20%">Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        <!-- Data produk akan dimuat disini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                            if(isset($_SESSION['user'])){
                                echo "
                                    <button id='checkout' class='btn btn-primary'>Checkout</button>
                                ";
                            }
                            else{
                                echo "
                                    <h4>You need to <a href='login.php'>Login</a> to checkout.</h4>
                                ";
                            }
                        ?>
                    </div>
                    <div class="col-sm-3">
                        <?php include 'includes/sidebar.php'; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-header">Transaction History</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $conn = $pdo->open();
                                    $userid = $_SESSION['user'];

                                    $stmt = $conn->prepare("
                                        SELECT sales.*, payments.amount AS amount
                                        FROM sales
                                        LEFT JOIN payments ON sales.transaction_id = payments.id
                                        WHERE sales.user_id = :userid
                                        ORDER BY sales.id DESC
                                    ");
                                    $stmt->execute(['userid' => $userid]);
                                    $count = 1;

                                    foreach ($stmt as $row) {
                                        $transaction_id = isset($row['transaction_id']) ? $row['transaction_id'] : 'N/A';
                                        $amount = isset($row['amount']) ? 'Rp. ' . number_format($row['amount'], 0, ',', '.') : 'N/A';
                                        $status = isset($row['status']) ? $row['status'] : 'N/A';
                                        $sales_date = isset($row['sales_date']) ? date('Y-m-d H:i:s', strtotime($row['sales_date'])) : 'N/A';

                                        echo "
                                            <tr>
                                                <td>{$count}</td>
                                                <td>{$transaction_id}</td>
                                                <td>{$amount}</td>
                                                <td>{$status}</td>
                                                <td>{$sales_date}</td>
                                            </tr>
                                        ";
                                        $count++;
                                    }

                                    $pdo->close();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php $pdo->close(); ?>
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
var total = 0;
$(function(){
    $(document).on('click', '.cart_delete', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'cart_delete.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                    getTotal();
                }
            }
        });
    });

    $(document).on('click', '.minus', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_'+id).val();
        if(qty>1){
            qty--;
        }
        $('#qty_'+id).val(qty);
        $.ajax({
            type: 'POST',
            url: 'cart_update.php',
            data: {
                id: id,
                qty: qty,
            },
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                    getTotal();
                }
            }
        });
    });

    $(document).on('click', '.add', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_'+id).val();
        qty++;
        $('#qty_'+id).val(qty);
        $.ajax({
            type: 'POST',
            url: 'cart_update.php',
            data: {
                id: id,
                qty: qty,
            },
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                    getTotal();
                }
            }
        });
    });

    $(document).on('click', '#checkout', function(e){
        e.preventDefault();
        var products = [];
        $('#tbody input[type="checkbox"]:checked').each(function(){
            var id = $(this).val();
            var qty = $('#qty_'+id).val();
            products.push({id: id, quantity: qty});
        });

        if(products.length === 0) {
            alert('Please select at least one product to checkout.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'checkout.php',
            data: {checkout: true, products: products},
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    // Store the total amount in session
                    $.ajax({
                        type: 'POST',
                        url: 'store_total.php',
                        data: {total: total},
                        success: function(){
                            window.location = 'payment_confirmation.php';
                        }
                    });
                }
                else{
                    alert(response.message);
                }
            }
        });
    });

    // Load initial cart details and total
    getDetails();
    getTotal();

});

// Function to fetch cart details via AJAX
function getDetails(){
    $.ajax({
        type: 'POST',
        url: 'cart_details.php',
        dataType: 'json',
        success: function(response){
            $('#tbody').html(response);
            getCart();
        }
    });
}

// Function to fetch total amount via AJAX
function getTotal(){
    $.ajax({
        type: 'POST',
        url: 'cart_total.php',
        dataType: 'json',
        success:function(response){
            total = response;
        }
    });
}
</script>
<!-- Paypal Express -->
<script>
paypal.Button.render({
    env: 'sandbox', // change for production if app is live,

    client: {
        sandbox:    'ASb1ZbVxG5ZFzCWLdYLi_d1-k5rmSjvBZhxP2etCxBKXaJHxPba13JJD_D3dTNriRbAv3Kp_72cgDvaZ',
        //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
    },

    commit: true, // Show a 'Pay Now' button

    style: {
        color: 'gold',
        size: 'small'
    },

    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                        //total purchase
                        amount: { 
                            total: total, 
                            currency: 'USD' 
                        }
                    }
                ]
            }
        });
    },

    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function(payment) {
            window.location = 'sales.php?pay='+payment.id;
        });
    },

}, '#paypal-button');
</script>
</body>
</html>
