<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Admin - MediNestCore</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://kit.fontawesome.com/6377024aba.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="icon" type="image/x-icon" href="../pics/logo.png" />
	<style>
		.admin-navbar {
			background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
			border-bottom: 2px solid #87ceeb;
			box-shadow: 0 2px 10px rgba(0,0,0,0.3);
		}
		.navbar-brand {
			font-weight: 700;
			font-size: 1.5rem;
			color: #87ceeb !important;
		}
		.nav-link {
			font-weight: 500;
			transition: all 0.3s ease;
			border-radius: 8px;
			margin: 0 5px;
		}
		.nav-link:hover {
			background-color: rgba(135, 206, 235, 0.1);
			color: #87ceeb !important;
		}
		.nav-link.active {
			background-color: rgba(135, 206, 235, 0.2);
			color: #87ceeb !important;
		}
		.admin-user-info {
			background: rgba(135, 206, 235, 0.1);
			border: 1px solid rgba(135, 206, 235, 0.3);
			border-radius: 20px;
			padding: 8px 15px;
			color: #87ceeb;
			font-weight: 500;
		}
		.logout-btn {
			background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
			border: none;
			border-radius: 20px;
			padding: 8px 20px;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		.logout-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
		}
	</style>
</head>
<body class="bg-dark text-light">
	<nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
		<div class="container-fluid">
			<a class="navbar-brand" href="dashboard.php">
				<i class="fas fa-shield-alt me-2"></i>MediNestCore Admin
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="adminNav">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
							<i class="fas fa-tachometer-alt me-2"></i>Dashboard
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
							<i class="fas fa-users me-2"></i>Users
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'prescriptions.php' ? 'active' : ''; ?>" href="prescriptions.php">
							<i class="fas fa-prescription-bottle-alt me-2"></i>Prescriptions
						</a>
					</li>
					<?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin'): ?>
					<li class="nav-item">
						<a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'admin_users.php' ? 'active' : ''; ?>" href="admin_users.php">
							<i class="fas fa-user-shield me-2"></i>Admin Access
						</a>
					</li>
					<?php endif; ?>
					<li class="nav-item">
						<a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'reset_mails.php' ? 'active' : ''; ?>" href="reset_mails.php">
							<i class="fas fa-envelope-open-text me-2"></i>Reset Mails
						</a>
					</li>
				</ul>
				<div class="d-flex align-items-center">
					<div class="admin-user-info me-3">
						<i class="fas fa-user-tie me-2"></i>
						<?php echo isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?>
					</div>
					<a href="logout.php" class="btn logout-btn">
						<i class="fas fa-sign-out-alt me-2"></i>Logout
					</a>
				</div>
			</div>
		</div>
	</nav>
	<div class="container-fluid py-4">
