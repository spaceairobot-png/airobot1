<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filterName = '';
$filterDate = date('Y-m-d');
$appendSql = "";
$appendSql0 = "";


if (isset($_POST['btnSearch'])) {
    $filterName = $_POST['txtStudentName'];
    $filterDate = $_POST['txtPaymentDate'];

    if ($filterName != '') {
        $appendSql0 .= " AND ifnull(A.Name,'') LIKE '%$filterName%'";
    }

} else {
    $appendSql0  = "";
}

if ($filterDate != '') {
        $appendSql .= " WHERE MONTH(payment_date) = Month('$filterDate') AND YEAR(payment_date) = YEAR('$filterDate')";
    }

$sql = "SELECT A.id,  A.Name,  B.Amount,
    CASE  WHEN B.student_id IS NULL THEN 'Outstanding' ELSE 'Paid' END AS PaymentStatus
    FROM tblstudent A
    LEFT JOIN (
        SELECT student_id , sum(amount) as Amount
        FROM tblpayments $appendSql
        GROUP BY Student_id
    ) B ON A.id = B.student_id
    WHERE A.isActive = 'A' $appendSql0 
    ORDER BY A.Name";

//echo $sql;

$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}

$rr = mysqli_num_rows($q);

?>

<h1 class="page-header">Payment Listing</h1>

<form method="post" action="index.php?page=listing_checkpayment">
<table class="table table-bordered">
<tr>
    <td>Student Name</td>
    <td><input type="text" name="txtStudentName" class="form-control" value='<?php echo $filterName; ?>'></td>
</tr>
<tr>
    <td>Payment Date</td>
    <td>
        <input type="date" name="txtPaymentDate" class="form-control" 
        value="<?php echo isset($_POST['txtPaymentDate']) ? $_POST['txtPaymentDate'] : date('Y-m-d'); ?>">
    </td>
</tr>
<tr>
    <td colspan="4"><input type="submit" name="btnSearch" value="Search" class="btn btn-success"></td>
</tr>
</table>
</form>

<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Student Name</th>
    <th>Amount</th>
    <th>PaymentStatus</th>
</tr>
</thead>
<tbody>
<?php
if ($rr > 0) {
    while ($row = mysqli_fetch_assoc($q)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['Name']}</td>
            <td>{$row['Amount']}</td>
            <td>{$row['PaymentStatus']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' style='color:red;'>No matches found</td></tr>";
}
?>
</tbody>
</table>

<script>
function DeletePayment(id) {
    if (confirm("Are you sure you want to delete this payment?")) {
        window.location.href = "index.php?page=delete_payment&id=" + id;
    }
}
</script>
