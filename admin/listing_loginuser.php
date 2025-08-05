<?php

if($UserRole != 'Adm' )
{
 echo "<script>window.location.replace('index.php');</script>";
}


error_reporting(E_ALL);
ini_set('display_errors', 1);


// Handle filters from GET
$filterName = isset($_GET['txtUserName']) ? $_GET['txtUserName'] : '';
$filterEmail = isset($_GET['txtEmail']) ? $_GET['txtEmail'] : '';


// Build WHERE clause
$appendSql = " WHERE 1=1";
if ($filterName != '') {
    $appendSql .= " AND IFNULL(Name,'') LIKE '%$filterName%'";
}
if ($filterEmail != '') {
    $appendSql .= "  AND IFNULL(Email,'') LIKE '%$filterEmail%'";
}


// Pagination setup
$limit = 10;
$page = isset($_GET['pg']) && is_numeric($_GET['pg']) ? $_GET['pg'] : 1;
$start = ($page - 1) * $limit;

// Count total records
$sqlCount = "SELECT COUNT(*) as total FROM tbllogin A $appendSql";
$resultCount = mysqli_query($conn, $sqlCount);
$totalRow = mysqli_fetch_assoc($resultCount)['total'];
$totalPages = ceil($totalRow / $limit);

// Fetch limited records
$sql = "SELECT Id, UserName, Email, Counsellor,
case when isActive  = '1' then 'Active'  when isActive  = '0' then 'Deactived'  else '' end as 'isActive'
FROM tbllogin  
$appendSql 
ORDER BY Id DESC 
LIMIT $start, $limit";

$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}
$rr = mysqli_num_rows($q);

// Build base URL for pagination
$baseUrl = "index.php?page=listing_loginuser";
$baseUrl .= "&txtUserName=" . urlencode($filterName);
$baseUrl .= "&txtEmail=" . urlencode($filterEmail);

?>

<h1 class="page-header">User Listing</h1>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="listing_loginuser">
    <table class="table table-bordered">
        <tr>
            <td>Login Name</td>
            <td><input type="text" name="txtUserName" class="form-control" value='<?php echo htmlspecialchars($filterName); ?>'></td>
            <td>Email</td>
            <td><input type="text" name="txtEmail" class="form-control" value='<?php echo htmlspecialchars($filterEmail); ?>'></td>
        </tr>
        <tr>
            <td colspan="4"><input type="submit" value="Search" class="btn btn-success"></td>
        </tr>
    </table>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Counsellor</th>
            <th>Email</th>
            <th>Status</th>
         
        </tr>
    </thead>
    <tbody>

    <?php
    if ($rr > 0) {
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>
                <td>{$row['Id']}</td>
                <td>{$row['UserName']}</td>
                <td>{$row['Counsellor']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['isActive']}</td>
                <td>
                    <a href='index.php?page=upd_loginuser&id={$row['Id']}&mode=view' class='btn btn-info'>View</a>
                    <a href='index.php?page=upd_loginuser&id={$row['Id']}' class='btn btn-warning'>Edit</a>
                    <a href='javascript:DeleteUser({$row['Id']})' class='btn btn-danger'>Delete</a>

                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='color:red;'>No matches found</td></tr>";
    }
    ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
<nav>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li><a class="page-link" href="<?php echo $baseUrl . "&pg=" . ($page - 1); ?>">&laquo; Prev</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="<?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="<?php echo $baseUrl . "&pg=$i"; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li><a class="page-link" href="<?php echo $baseUrl . "&pg=" . ($page + 1); ?>">Next &raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>

<script>
function DeleteUser(id) {
    if (confirm("Are you sure you want to delete this ?")) {
        window.location.href = "index.php?page=del_loginuser&id=" + id;
    }
}
</script>
