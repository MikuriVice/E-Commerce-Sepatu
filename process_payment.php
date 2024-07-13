<?php 
include 'includes/session.php'; 
include 'includes/header.php'; 

$output = array('error'=>false);

if(isset($_SESSION['user']) && isset($_POST['total']) && isset($_FILES['proof'])){
    $userid = $_SESSION['user'];
    $total = $_POST['total'];
    $proof = $_FILES['proof']['name'];
    $target = 'uploads/' . basename($proof);
    $status = 'pending'; // Set status to pending

    if(move_uploaded_file($_FILES['proof']['tmp_name'], $target)){
        try{
            $conn = $pdo->open();

            // Insert into payments table
            $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, proof) VALUES (:user_id, :amount, :proof)");
            $stmt->execute(['user_id'=>$userid, 'amount'=>$total, 'proof'=>$proof]);

            // Get the last inserted payment ID
            $payment_id = $conn->lastInsertId();

            // Get the latest sales ID for the user
            $stmt = $conn->prepare("SELECT id FROM sales WHERE user_id=:user_id AND status='pending' ORDER BY id DESC LIMIT 1");
            $stmt->execute(['user_id'=>$userid]);
            $sales = $stmt->fetch();
            $sales_id = $sales['id'];

            // Update the latest sales record with payment transaction_id
            $stmt = $conn->prepare("UPDATE sales SET transaction_id=:transaction_id, status=:status WHERE id=:sales_id");
            $stmt->execute(['transaction_id'=>$payment_id, 'status'=>$status, 'sales_id'=>$sales_id]);
            

            $output['message'] = 'Payment confirmed. Thank you for your payment!';
        }
        catch(PDOException $e){
            $output['error'] = true;
            $output['message'] = $e->getMessage();
        }

        $pdo->close();

        // Redirect back to cart history after successful payment
        echo "<script>window.location.href = 'cart_view.php';</script>";
    } else {
        $output['error'] = true;
        $output['message'] = 'Failed to upload proof of transfer';
    }
} else {
    $output['error'] = true;
    $output['message'] = 'Incomplete form';
}

if($output['error']){
    echo "<div class='alert alert-danger'>".$output['message']."</div>";
} else {
    echo "<div class='alert alert-success'>".$output['message']."</div>";
}
?>
<?php include 'includes/footer.php'; ?>
