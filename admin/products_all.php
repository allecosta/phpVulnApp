<?php

require 'includes/session.php';

$output = '';

$conn = $pdo->open();

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
	$output .= "
		<option value='" . $row['id'] . "' class='append_items'>" . $row['name'] . "</option>
	";
}

$pdo->close();

echo json_encode($output);
