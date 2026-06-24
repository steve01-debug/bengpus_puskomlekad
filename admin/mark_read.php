<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../entering.php');
    exit;
}
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn = getDB();
    $stmt = $conn->prepare("UPDATE feedback SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
header("Location: dashboard.php?filter=" . urlencode($filter));
exit;
?>
