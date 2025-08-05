<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Handle filters from GET
$filterCategory = isset($_GET['txtCategoryName']) ? $_GET['txtCategoryName'] : '';
$filterDescription = isset($_GET['txtDescription']) ? $_GET['txtDescription'] : '';
$filterMode = isset($_GET['ddlmode']) ? $_GET['ddlmode'] : '';
$filterAmount = isset($_GET['txtAmount']) ? $_GET['txtAmount'] : '';
$filterReference = isset($_GET['txtReference']) ? $_GET['txtReference'] : '';
$filterStatus = isset($_GET['ddlStatus']) ? $_GET['ddlStatus'] : '';
$filterDtFr = isset($_GET['txtDtFr']) ? $_GET['txtDtFr'] : '';
$filterDtTo = isset($_GET['txtDtTo']) ? $_GET['txtDtTo'] : '';


if (isset($_POST['btnSearch'])) {

    $filterCategory = $_POST['txtCategoryName'];
    $filterDescription = $_POST['txtDescription'];
    $filterMode = $_POST['ddlmode'];
    $filterAmount = $_POST['txtAmount'];
    $filterReference = $_POST['txtReference'];
    $filterStatus = $_POST['ddlStatus'];
    $filterDtFr = $_POST['txtDtFr'];
    $filterDtTo = $_POST['txtDtTo'];

    $appendSql = " WHERE 1=1";


    if ($filterCategory != '') {
        $appendSql .= " AND ifnull(category,'') LIKE '%$filterCategory%'";
    }
    if ($filterDescription != '') {
        $appendSql .= " AND ifnull(description,'') LIKE '%$filterDescription%'";
    }
    if ($filterMode != '') {
        $appendSql .= " AND ifnull(payment_method,'') = '$filterMode'";
    }
 
    if ($filterAmount != '') {
        $appendSql .= " AND CAST(IFNULL(amount, 0) AS DECIMAL(10,2)) = '$filterAmount'";
    }
    if ($filterReference != '') {
        $appendSql .= " AND ifnull(reference_no,'') LIKE '%$filterReference%'";
    }
    if ($filterStatus != '') {
        $appendSql .= " AND ifnull(status,'') = '$filterStatus'";
    }
 
    if ($filterDtFr != '') {
        $appendSql .= " AND CAST(ifnull(expense_date,'') AS Date) >= '$filterDtFr'";
    }
    if ($filterDtTo != '') {
        $appendSql .= " AND CAST(ifnull(expense_date,'') AS Date) <= '$filterDtTo'";
    }


} else {
    $appendSql = " WHERE 1=1";
}

$sql = "SELECT id , expense_date , category , description , amount , payment_method , reference_no  , created_at , updated_at , status FROM tblexpense $appendSql";


$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}

$rr = mysqli_num_rows($q);

?>


<h1 class="page-header">Expense Listing</h1>

<form method="post" action="index.php?page=listing_expense">
<table class="table table-bordered">
<tr>
    <td>Category</td>
    <td><input type="text" name="txtCategoryName" class="form-control" value='<?php echo $filterCategory; ?>'></td>

    <td>Description</td>
    <td><input type="text" name="txtDescription" class="form-control" value='<?php echo $filterDescription; ?>'></td>
</tr>
<tr>
    <td>From</td>
    <td><input type="date" name="txtDtFr" class="form-control" value='<?php echo $filterDateFr; ?>'></td>

    <td>To</td>
    <td><input type="date" name="txtDtTo" class="form-control" value='<?php echo $filterDateTo; ?>'></td>
</tr>
<tr>
    <td>Payment Mode</td>
            <td>
                <select name="ddlmode" class="form-control">
                    <option value="">Select</option>
                    <option value="Cash" <?php if ($filterMode == 'Cash') echo 'selected'; ?>>Cash</option>
                    <option value="Bank" <?php if ($filterMode == 'Bank') echo 'selected'; ?>>Bank</option>
                    <option value="Ewallet" <?php if ($filterMode == 'Ewallet') echo 'selected'; ?>>Ewallet</option>
                </select>
            </td>

    <td>Amount</td>
    <td><input type="number" name="txtAmount" class="form-control" value='<?php echo $filterAmount; ?>'></td>
</tr>
<tr>
    <td>Reference</td>
    <td><input type="text" name="txtReference" class="form-control" value='<?php echo $filterReference; ?>'></td>

    <td>Status</td>
    <td>
        <select name="ddlStatus" class="form-control">
            <option value="">Select</option>
            <option value="" <?php if ($filterStatus == '') echo 'selected'; ?>>All</option>
            <option value="A" <?php if ($filterStatus == 'A') echo 'selected'; ?>>Available</option>
            <option value="I" <?php if ($filterStatus == 'I') echo 'selected'; ?>>Unavailable</option>
        </select>
    </td>
</tr>
<tr>
    <td colspan="4"><input type="submit" name="btnSearch" value="Search" class="btn btn-success"></td>
</tr>
</table>
</form>

<table id="sortedtable" class="table table-bordered" cellspacing="0">
<thead>
<tr>
    <th id="headerSortUp">Id</th>
    <th id="headerSortUp">Payment Date</th>
    <th id="headerSortUp">Category</th>
    <th id="headerSortUp">Description</th>
    <th id="headerSortUp">Amount</th>
    <th id="headerSortUp">Payment Method </th>
    <th id="headerSortUp">Reference</th>
    <th id="headerSortUp">Created at</th>
    <th id="headerSortUp">Updated at</th>
    <th id="headerSortUp">Status</th>
    <th id="">Action</th>
</tr>
</thead>
<tbody>
<?php
if ($rr > 0) {
    while ($row = mysqli_fetch_assoc($q)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['expense_date']}</td>
            <td>{$row['category']}</td>
            <td>{$row['description']}</td>
            <td>{$row['amount']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['reference_no']}</td>
            <td>{$row['created_at']}</td>
            <td>{$row['updated_at']}</td>
            <td>{$row['status']}</td>
            <td>
                <a href='index.php?page=upd_expense&id={$row['id']}' class='btn btn-warning'>Edit</a>
                <a href='javascript:Delete({$row['id']})' class='btn btn-danger'>Delete</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='9' style='color:red;'>No matches found</td></tr>";
}
?>
</tbody>
</table>


<script>

 $(document).ready(function () {
  $('#sortedtable').DataTable({
    order: [[1, 'desc']],
    pageLength: 10 
    
  });
});

function Delete(id) {
    if (confirm("Are you sure you want to delete this expense?")) {
        window.location.href = "index.php?page=del_expense&id=" + id;
    }
}
</script>
