<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';
if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'admin') {
	header('Location: dashboard.php');
	exit();
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	if ($action === 'create') {
		$newUsername = isset($_POST['username']) ? trim($_POST['username']) : '';
		$newPassword = isset($_POST['password']) ? $_POST['password'] : '';
		if ($newUsername !== '' && $newPassword !== '') {
			$check = mysqli_prepare($con, "SELECT id FROM admin_users WHERE username = ? LIMIT 1");
			if ($check) {
				mysqli_stmt_bind_param($check, 's', $newUsername);
				mysqli_stmt_execute($check);
				$res = mysqli_stmt_get_result($check);
				$exists = $res && mysqli_fetch_assoc($res);
				mysqli_stmt_close($check);
				if ($exists) {
					$message = 'Username already exists';
				} else {
					$hash = password_hash($newPassword, PASSWORD_DEFAULT);
					$ins = mysqli_prepare($con, "INSERT INTO admin_users (username, password_hash, role) VALUES (?, ?, 'sub_admin')");
					if ($ins) {
						mysqli_stmt_bind_param($ins, 'ss', $newUsername, $hash);
						mysqli_stmt_execute($ins);
						mysqli_stmt_close($ins);
						$message = 'Secondary admin created';
					} else {
						$message = 'Failed to create secondary admin';
					}
				}
			} else {
				$message = 'Database error';
			}
		} else {
			$message = 'Username and password required';
		}
	} elseif ($action === 'reset') {
		$targetId = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$newPassword = isset($_POST['password']) ? $_POST['password'] : '';
		if ($targetId > 0 && $newPassword !== '') {
			$q = mysqli_prepare($con, "SELECT role FROM admin_users WHERE id = ? LIMIT 1");
			if ($q) {
				mysqli_stmt_bind_param($q, 'i', $targetId);
				mysqli_stmt_execute($q);
				$r = mysqli_stmt_get_result($q);
				$row = $r ? mysqli_fetch_assoc($r) : null;
				mysqli_stmt_close($q);
				if ($row && $row['role'] !== 'admin') {
					$hash = password_hash($newPassword, PASSWORD_DEFAULT);
					$up = mysqli_prepare($con, "UPDATE admin_users SET password_hash = ? WHERE id = ?");
					if ($up) {
						mysqli_stmt_bind_param($up, 'si', $hash, $targetId);
						mysqli_stmt_execute($up);
						mysqli_stmt_close($up);
						$message = 'Password reset';
					} else {
						$message = 'Failed to reset password';
					}
				} else {
					$message = 'Not allowed';
				}
			} else {
				$message = 'Database error';
			}
		} else {
			$message = 'Invalid input';
		}
	} elseif ($action === 'delete') {
		$targetId = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if ($targetId > 0) {
			$q = mysqli_prepare($con, "SELECT role FROM admin_users WHERE id = ? LIMIT 1");
			if ($q) {
				mysqli_stmt_bind_param($q, 'i', $targetId);
				mysqli_stmt_execute($q);
				$r = mysqli_stmt_get_result($q);
				$row = $r ? mysqli_fetch_assoc($r) : null;
				mysqli_stmt_close($q);
				if ($row && $row['role'] !== 'admin') {
					$d = mysqli_prepare($con, "DELETE FROM admin_users WHERE id = ?");
					if ($d) {
						mysqli_stmt_bind_param($d, 'i', $targetId);
						mysqli_stmt_execute($d);
						mysqli_stmt_close($d);
						$message = 'Secondary admin deleted';
					} else {
						$message = 'Failed to delete';
					}
				} else {
					$message = 'Not allowed';
				}
			} else {
				$message = 'Database error';
			}
		} else {
			$message = 'Invalid input';
		}
	}
}
$admins = mysqli_query($con, "SELECT id, username, role, created_at FROM admin_users ORDER BY id ASC");
include __DIR__ . '/header.php';
?>
<style>
.card-dark { background-color: #2d2d2d; border: 1px solid #404040; border-radius: 12px; }
.form-control-dark { background-color: #2d2d2d; border: 1px solid #404040; color: #ffffff; }
.form-control-dark:focus { background-color: #2d2d2d; border-color: #87ceeb; color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(135,206,235,.25); }
.btn-create { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: #fff; }
.badge-role { background: rgba(135, 206, 235, 0.15); color: #87ceeb; border: 1px solid rgba(135,206,235,.35); border-radius: 10px; padding: 6px 10px; }
.table-dark td, .table-dark th { border-color: #404040; vertical-align: middle; }
</style>
<div class="container-fluid">
	<div class="row mb-4">
		<div class="col-12">
			<div class="card card-dark">
				<div class="card-body">
					<h4 class="mb-0" style="color:#87ceeb"><i class="fas fa-user-shield me-2"></i>Admin Access</h4>
					<small class="text-muted">Grant and manage secondary admin access</small>
				</div>
			</div>
		</div>
	</div>
	<?php if ($message !== ''): ?>
	<div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-4">
			<div class="card card-dark">
				<div class="card-body">
					<h5 class="mb-3" style="color:#87ceeb"><i class="fas fa-user-plus me-2"></i>Create Secondary Admin</h5>
					<form method="post">
						<input type="hidden" name="action" value="create">
						<div class="mb-3">
							<label class="form-label">Username</label>
							<input type="text" name="username" class="form-control form-control-dark" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="password" class="form-control form-control-dark" required>
						</div>
						<button type="submit" class="btn btn-create w-100"><i class="fas fa-check me-2"></i>Create</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-dark">
				<div class="card-body">
					<h5 class="mb-3" style="color:#87ceeb"><i class="fas fa-users-cog me-2"></i>Admin Users</h5>
					<div class="table-responsive">
						<table class="table table-dark table-hover align-middle mb-0">
							<thead>
								<tr>
									<th>ID</th>
									<th>Username</th>
									<th>Role</th>
									<th>Created</th>
									<th class="text-end">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($admins && mysqli_num_rows($admins) > 0): ?>
									<?php while ($a = mysqli_fetch_assoc($admins)): ?>
									<tr>
										<td><?php echo (int)$a['id']; ?></td>
										<td><?php echo htmlspecialchars($a['username']); ?></td>
										<td><span class="badge-role"><?php echo htmlspecialchars($a['role']); ?></span></td>
										<td><small class="text-muted"><?php echo htmlspecialchars($a['created_at']); ?></small></td>
										<td class="text-end">
											<?php if ($a['role'] !== 'admin'): ?>
											<form method="post" class="d-inline">
												<input type="hidden" name="action" value="reset">
												<input type="hidden" name="id" value="<?php echo (int)$a['id']; ?>">
												<input type="password" name="password" class="form-control form-control-dark d-inline-block me-2" style="width:180px" placeholder="New password" required>
												<button type="submit" class="btn btn-sm btn-outline-info me-2"><i class="fas fa-key me-1"></i>Reset</button>
											</form>
											<form method="post" class="d-inline" onsubmit="return confirm('Delete this secondary admin?')">
												<input type="hidden" name="action" value="delete">
												<input type="hidden" name="id" value="<?php echo (int)$a['id']; ?>">
												<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt me-1"></i>Delete</button>
											</form>
											<?php else: ?>
											<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-lock me-1"></i>Main Admin</button>
											<?php endif; ?>
										</td>
									</tr>
									<?php endwhile; ?>
								<?php else: ?>
									<tr><td colspan="5" class="text-center text-muted py-4">No admin users</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
