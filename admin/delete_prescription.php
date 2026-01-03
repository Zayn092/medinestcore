<?php
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/auth.php'; // optional, if you want only logged-in admins to delete

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $con->prepare("DELETE FROM ind_prescription WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}
