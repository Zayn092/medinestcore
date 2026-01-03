<?php
session_start();
require_once __DIR__ . '/../connection.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
	header('Location: index.php?e=1');
	exit();
}

// Prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, "SELECT id, username, password_hash, role FROM admin_users WHERE username = ? LIMIT 1");
if (!$stmt) {
	header('Location: index.php?e=1');
	exit();
}
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = $result ? mysqli_fetch_assoc($result) : null;

if ($user && password_verify($password, $user['password_hash'])) {
	$_SESSION['admin_logged_in'] = true;
	$_SESSION['admin_username'] = $user['username'];
	$_SESSION['admin_role'] = $user['role'];
	header('Location: dashboard.php');
	exit();
}

	header('Location: index.php?e=1');
	exit();
