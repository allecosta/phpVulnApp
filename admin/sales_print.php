<?php

require 'includes/session.php';

function generateRow($from, $to, $conn)
{
	$contents = '';
	$sql = "SELECT 
				*, sales.id AS salesid 
			FROM 
				sales 
			LEFT JOIN 
				users ON users.id = sales.user_id 
			WHERE 
				sales_date 
			BETWEEN 
				'$from' AND '$to' 
			ORDER BY 
				sales_date DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$total = 0;

	foreach ($stmt as $row) {
		$sql = "SELECT 
					* 
				FROM 
					details 
				LEFT JOIN 
					products ON products.id = details.product_id 
				WHERE 
					sales_id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $row['salesid']]);
		$amount = 0;

		foreach ($stmt as $details) {
			$subtotal = $details['price'] * $details['quantity'];
			$amount += $subtotal;
		}

		$total += $amount;
		$contents .= '
			<tr>
				<td>' . date('M d, Y', strtotime($row['sales_date'])) . '</td>
				<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
				<td>' . $row['pay_id'] . '</td>
				<td align="right">&#36; ' . number_format($amount, 2) . '</td>
			</tr>
		';
	}

	$contents .= '
		<tr>
			<td colspan="3" align="right"><strong>Total</strong></td>
			<td align="right"><strong>&#36; ' . number_format($total, 2) . '</strong></td>
		</tr>
	';

	return $contents;
}

if (isset($_POST['print'])) {
	$ex = explode(' - ', $_POST['date_range']);
	$from = date('Y-m-d', strtotime($ex[0]));
	$to = date('Y-m-d', strtotime($ex[1]));
	$fromTitle = date('M d, Y', strtotime($ex[0]));
	$toTitle = date('M d, Y', strtotime($ex[1]));

	$conn = $pdo->open();

	require_once('../tcpdf/tcpdf.php');

	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetTitle('Sales Report: ' . $fromTitle . ' - ' . $toTitle);
	$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
	$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
	$pdf->SetDefaultMonospacedFont('helvetica');
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->SetFont('helvetica', '', 11);
	$pdf->AddPage();
	$content = '';
	$content .= '
		<h2 align="center">TechSoft IT Solutions</h2>
		<h4 align="center">RELATÓRIO DE VENDAS</h4>
		<h4 align="center">' . $fromTitle . " - " . $toTitle . '</h4>
		<table border="1" cellspacing="0" cellpadding="3">  
			<tr>  
				<th width="15%" align="center"><strong>Data</strong></th>
				<th width="30%" align="center"><strong>Comprador</strong></th>
				<th width="40%" align="center"><strong>Transação#</strong></th>
				<th width="15%" align="center"><strong>Valor</strong></th>  
			</tr>  
		';
	$content .= generateRow($from, $to, $conn);
	$content .= '</table>';
	$pdf->writeHTML($content);
	$pdf->Output('sales.pdf', 'I');

	$pdo->close();
} else {
	$_SESSION['error'] = 'Precisa de um intervalo de datas para fornecer impressão de vendas.';

	header('location: sales.php');
}
