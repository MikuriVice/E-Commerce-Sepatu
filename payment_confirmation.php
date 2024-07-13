<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
if(!isset($_SESSION['user'])){
    header('location: login.php');
}
?>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <div class="content-wrapper">
        <div class="container">
            <section class="content">
                <div class="row">
                    <div class="col-sm-9">
                        <h1 class="page-header">Payment Confirmation</h1>
                        <div class="box box-solid">
                            <div class="box-body">
                                <form method="POST" action="process_payment.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="total">Total Amount</label>
                                        <input type="text" id="total" name="total" class="form-control" value="<?php echo $_SESSION['total']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="proof">Upload Proof of Transfer</label>
                                        <input type="file" id="proof" name="proof" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Confirm Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <?php include 'includes/sidebar.php'; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php $pdo->close(); ?>
    <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
</body>
</html>
