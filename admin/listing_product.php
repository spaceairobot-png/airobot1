<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Handle filters from GET
$filterName = isset($_GET['txtProductName']) ? $_GET['txtProductName'] : '';
$filterStatus = isset($_GET['txtStatus']) ? $_GET['txtStatus'] : '';
$filterDate = isset($_GET['txtCreatedDate']) ? $_GET['txtCreatedDate'] : '';


if (isset($_POST['btnSearch'])) {
    $filterName = $_POST['txtProductName'];
    $filterStatus = $_POST['txtStatus'];
    $filterDate = $_POST['txtCreatedDate'];


    $appendSql = " WHERE 1=1";

    if ($filterName != '') {
        $appendSql .= " AND ifnull(product_name,'') LIKE '%$filterName%'";
    }
    if ($filterStatus != '') {
        $appendSql .= " AND ifnull(status,'') = '$filterStatus'";
    }
    if ($filterDate != '') {
        $appendSql .= " AND ifnull(created_at,'') >= '$filterDate'";
    }
 
} else {
    $appendSql = " WHERE 1=1";
}


$sql = "SELECT id , product_name , list_price , selling_price , quantity , created_at , updated_at , status FROM tblproduct $appendSql ";

$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}

$rr = mysqli_num_rows($q);


?>


<h1 class="page-header">Product Listing</h1>

<form method="post" action="index.php?page=listing_product">
<table class="table table-bordered">
<tr>
    <td>Product Name</td>
    <td><input type="text" name="txtProductName" class="form-control" value='<?php echo $filterName; ?>'></td>
    <td>Created Date</td>
    <td><input type="date" name="txtCreatedDate" class="form-control" value='<?php echo $filterDate; ?>'></td>
</tr>
<tr>
    <td>Status</td>
    <td>
        <select name="txtStatus" class="form-control">
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
    <th id="headerSortUp">Product Name</th>
    <th id="headerSortUp">List Price</th>
    <th id="headerSortUp">Selling Price</th>
    <th id="headerSortUp">Quantity</th>
    <th id="headerSortUp">Created at</th>
    <th id="headerSortUp">Updated at</th>
    <th id="headerSortUp">status</th>
    <th id="">Action</th>
</tr>
</thead>
<tbody>
<?php
if ($rr > 0) {
    while ($row = mysqli_fetch_assoc($q)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['list_price']}</td>
            <td>{$row['selling_price']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['created_at']}</td>
            <td>{$row['updated_at']}</td>
            <td>{$row['status']}</td>
            <td>
                <a href='index.php?page=upd_product&id={$row['id']}' class='btn btn-warning'>Edit</a>
                <a href='javascript:Delete({$row['id']})' class='btn btn-danger'>Delete</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='8' style='color:red;'>No matches found</td></tr>";
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


function Delete(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = "index.php?page=del_product&id=" + id;
    }
}
</script>
