<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Handle filters from GET
$filterName = isset($_GET['name']) ? $_GET['name'] : '';
$filterAmount = isset($_GET['amount']) ? $_GET['amount'] : '';
$filterDate = isset($_GET['date']) ? $_GET['date'] : '';
$filterMode = isset($_GET['mode']) ? $_GET['mode'] : '';

// Build WHERE clause
$appendSql = " WHERE 1=1";
if ($filterName != '') {
    $appendSql .= " AND IFNULL(B.Name,'') LIKE '%$filterName%'";
}
if ($filterAmount != '') {
    $appendSql .= " AND CAST(IFNULL(A.amount, 0) AS DECIMAL(10,2)) = '$filterAmount'";
}
if ($filterDate != '') {
    $appendSql .= " AND CAST(IFNULL(A.payment_date,'') AS Date) = '$filterDate'";
}
if ($filterMode != '') {
    $appendSql .= " AND IFNULL(A.mode,'') = '$filterMode'";
}


// Fetch limited records
$sql = "SELECT A.id, B.Name AS StudentName, A.amount, A.payment_date, A.mode, A.created_at, A.status
        FROM tblpayments A 
        LEFT JOIN tblstudent B ON A.student_id = B.Id 
        $appendSql 
        "; 
        

$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}
$rr = mysqli_num_rows($q);


?>

<h1 class="page-header">Payment Listing</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="listing_payment">
    <table class="table table-bordered">
        <tr>
            <td>Student Name</td>
            <td><input type="text" name="name" class="form-control" value='<?php echo htmlspecialchars($filterName); ?>'></td>
            <td>Amount</td>
            <td><input type="number" name="amount" class="form-control" value='<?php echo htmlspecialchars($filterAmount); ?>'></td>
        </tr>
        <tr>
            <td>Payment Date</td>
            <td><input type="date" name="date" class="form-control" value='<?php echo htmlspecialchars($filterDate); ?>'></td>
            <td>Payment Mode</td>
            <td>
                <select name="mode" class="form-control">
                    <option value="">Select</option>
                    <option value="Cash" <?php if ($filterMode == 'Cash') echo 'selected'; ?>>Cash</option>
                    <option value="Bank" <?php if ($filterMode == 'Bank') echo 'selected'; ?>>Bank</option>
                    <option value="Ewallet" <?php if ($filterMode == 'Ewallet') echo 'selected'; ?>>Ewallet</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4"><input type="submit" value="Search" class="btn btn-success"></td>
        </tr>
    </table>
</form>

<table id="sortedtable" class="table table-bordered" cellspacing="0">
    <thead>
        <tr>
            <th id="headerSortUp">ID</th>
            <th id="headerSortUp">Student Name</th>
            <th id="headerSortUp">Amount</th>
            <th id="headerSortUp">Payment Date</th>
            <th id="headerSortUp">Mode</th>
            <th id="headerSortUp">Status</th>
            <th id="headerSortUp">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($rr > 0) {
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['StudentName']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['payment_date']}</td>
                <td>{$row['mode']}</td>
                <td>{$row['status']}</td>
                <td>
                    <a href='index.php?page=upd_payment&payment_id={$row['id']}' class='btn btn-warning'>Edit</a>
                    <a href='javascript:DeletePayment({$row['id']})' class='btn btn-danger'>Delete</a>
                    <a href='index.php?page=print_invoice&paymentId={$row['id']}' class='btn btn-info'>Print Invoice</a>
		    <a href='index.php?page=print_receipt&paymentId={$row['id']}' class='btn btn-info'>Print Receipt</a>

                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7' style='color:red;'>No matches found</td></tr>";
    }
    ?>
    </tbody>
</table>


<script>
 $(document).ready(function () {
  $('#sortedtable').DataTable({
    order: [[3, 'desc']],
    pageLength: 10 
    
  });
});

function DeletePayment(id) {
    if (confirm("Are you sure you want to delete this payment?")) {
        window.location.href = "index.php?page=del_payment&id=" + id;
    }
}
</script>
