<?php
	include 'includes/session.php';

	$id = $_POST['id'];

	$conn = $pdo->open();

	$output = array('list'=>'');

	$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE details.sales_id=:id");
	$stmt->execute(['id'=>$id]);

	$total = 0;
	foreach($stmt as $row){
		$output['transaction'] = $row['pay_id'];
		$output['date'] = date('M d, Y', strtotime($row['sales_date']));
		$subtotal = $row['price']*$row['quantity'];
		$total += $subtotal;
		$output['list'] .= "
			<tr class='prepend_items'>
				<td>".$row['name']."</td>
				<td> Rp. ".number_format($row['price'],0,',','.')."</td>
				<td>".$row['quantity']."</td>
				<td> Rp. ".number_format($subtotal,0,',','.')."</td>
			</tr>
		";
	}
	
	$output['total'] = '<b> Rp. '.number_format($total,0,',','.').'<b>';
	$pdo->close();
	echo json_encode($output);

?>