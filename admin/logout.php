<?php 
session_start();
include '../connection.php';

if (isset($_SESSION['IPAid']) && is_numeric($_SESSION['IPAid'])) {
    $Aid = (int)$_SESSION['IPAid'];
    $currentDateTime = date('Y-m-d H:i:s');

    $upd = "UPDATE tblacesslog SET LogoutTime = '$currentDateTime' WHERE Aid = $Aid";
    mysqli_query($conn, $upd);
} else {
    error_log("Logout error: IPAid session variable is not set or invalid.");
}

// Clear session variables
unset($_SESSION['admin']);
unset($_SESSION['role']);
unset($_SESSION["dbCompany"]);
unset($_SESSION['IPAid']);

// Redirect to login page
header('Location: ../index.php');
exit;
?>
