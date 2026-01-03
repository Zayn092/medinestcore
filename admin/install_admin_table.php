<?php
require_once __DIR__ . '/../connection.php';

$sql = "CREATE TABLE IF NOT EXISTS admin_users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100) NOT NULL UNIQUE,
	password_hash VARCHAR(255) NOT NULL,
	role VARCHAR(50) NOT NULL DEFAULT 'admin',
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$ok = mysqli_query($con, $sql);
$msg = '';
if ($ok) {
	// create default admin if not exists
	$defaultUser = 'admin';
	$defaultPass = 'admin123';
	$hash = password_hash($defaultPass, PASSWORD_DEFAULT);
	$stmt = mysqli_prepare($con, "INSERT IGNORE INTO admin_users (username, password_hash, role) VALUES (?, ?, 'admin')");
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 'ss', $defaultUser, $hash);
		mysqli_stmt_execute($stmt);
		$msg = 'Admin table ensured. Default login: admin / admin123';
	} else {
		$msg = 'Admin table created, but failed to create default user.';
	}
} else {
	$msg = 'Failed to create admin table: ' . mysqli_error($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Install Admin Table</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-light">
	<div class="container py-5">
		<div class="card p-4" style="background-color:#1e1e1e;border:1px solid #404040;">
			<h4 class="mb-3">Install Admin Users Table</h4>
			<div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
			<a href="index.php" class="btn btn-primary">Back to Login</a>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
