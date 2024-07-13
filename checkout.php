<?php
include 'includes/session.php';

$output = array('error'=>false);

if(isset($_SESSION['user']) && isset($_POST['checkout']) && isset($_POST['products'])){
    $userid = $_SESSION['user'];
    $date = date('Y-m-d');
    $status = 'pending'; // Set status to pending

    try{
        $conn = $pdo->open();

        // Insert into sales table
        $stmt = $conn->prepare("INSERT INTO sales (user_id, sales_date, status) VALUES (:user_id, :sales_date, :status)");
        $stmt->execute(['user_id'=>$userid, 'sales_date'=>$date, 'status'=>$status]);
        $salesid = $conn->lastInsertId();

        // Insert into details table for each product
        foreach($_POST['products'] as $product){
            $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
            $stmt->execute(['sales_id'=>$salesid, 'product_id'=>$product['id'], 'quantity'=>$product['quantity']]);
        }

        // Clear the cart or perform any necessary cleanup
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
        $stmt->execute(['user_id'=>$userid]);

        $output['message'] = 'Transaction completed. Thank you for your purchase!';
    }
    catch(PDOException $e){
        $output['error'] = true;
        $output['message'] = $e->getMessage();
    }

    $pdo->close();
}
else{
    $output['error'] = true;
    $output['message'] = 'No product selected';
}

echo json_encode($output);
?>
