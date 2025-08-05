<?php
ob_start();
require_once __DIR__ . '/../vendor/autoload.php';
include_once('../connection.php');

$paymentId = isset($_GET['paymentId']) ? intval($_GET['paymentId']) : 0;

if ($paymentId <= 0) {
    die("Invalid Payment ID");
}

// Fetch payment and student data
$sql = "SELECT A.*, B.Name FROM tblpayments A 
        LEFT JOIN tblstudent B ON A.Student_id = B.Id 
        WHERE A.Id = $paymentId LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Payment not found");
}

$payment = $result->fetch_assoc();

// Calculate grand total from item list
$sqlItems = "SELECT item_price, quantity FROM tblpayment_items WHERE payment_id = $paymentId";
$resultItems = $conn->query($sqlItems);

$grandTotal = 0;
while ($item = $resultItems->fetch_assoc()) {
    $grandTotal += $item['item_price'] * $item['quantity'];
}

$conn->close();

date_default_timezone_set('Asia/Kuala_Lumpur');

$html = '
<html>
<head>
<meta charset="UTF-8">
<title>Receipt</title>
<style>
body { font-family: sans-serif; margin: 0; padding: 0; }
.invoice-box { padding: 30px; border: 1px solid #ccc; max-width: 800px; margin: auto; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
.company-name { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
.company-add { font-size: 12px; margin-bottom: 2px; }
.details { width: 100%; border-collapse: collapse; margin-top: 20px; }
.details th, .details td { border: 1px solid #ccc; padding: 8px; text-align: left; }
.details th { background-color: #f9f9f9; }
.text-right { text-align: right; }
</style>
</head>
<body>
<div class="invoice-box">

<table width="100%" style="margin-bottom: 20px;">
  <tr>
    <td style="vertical-align: top;">
      <div class="company-name">AI Robot Space Solution</div>
      <div class="company-add">(PG0567128-V)</div>
      <div class="company-add">122, Lorong Bukit Panchor 3,</div>
      <div class="company-add">Taman Bukit Panchor,</div>
      <div class="company-add">14300 Nibong Tebal.</div>
      <div class="company-add">Tel: 017-7587580</div>
      <div class="company-add">Email: spaceairobot@gmail.com</div>
    </td>
    <td style="text-align: right;">
      <img src="../css/img/bg.jpg" style="max-height: 100px;" alt="Company Logo">
    </td>
  </tr>
</table>

<h1 style="text-align: center;">Receipt</h1>

<table class="details">
  <tr><th>Receipt No:</th><td>' . htmlspecialchars($payment['invoice_no']) . '</td></tr>
  <tr><th>Student Name:</th><td>' . htmlspecialchars($payment['Name']) . '</td></tr>
  <tr><th>Payment Mode:</th><td>' . htmlspecialchars($payment['mode']) . '</td></tr>
  <tr><th>Payment Date:</th><td>' . htmlspecialchars($payment['payment_date']) . '</td></tr>
  <tr><th>Total Paid:</th><td><strong>MYR ' . number_format($grandTotal, 2) . '</strong></td></tr>
</table>

<p style="margin-top: 30px;">Printed on: ' . date('d-m-Y h:i A') . '</p>
<p style="margin-top: 10px;">This is an official receipt as proof of payment.</p>

</div>
</body>
</html>';

try {
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="receipt_' . $paymentId . '.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');

    $mpdf->Output();
    exit;
} catch (\Mpdf\MpdfException $e) {
    echo $e->getMessage();
}
?>
