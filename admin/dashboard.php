<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';

// Get statistics
$usersCount = 0;
$prescCount = 0;
$activePresc = 0;
$completedPresc = 0;
$todayUsers = 0;
$todayPresc = 0;

$res1 = mysqli_query($con, "SELECT COUNT(*) as c FROM individual");
if ($res1) { $row = mysqli_fetch_assoc($res1); $usersCount = (int)$row['c']; }

$res2 = mysqli_query($con, "SELECT COUNT(*) as c FROM ind_prescription");
if ($res2) { $row = mysqli_fetch_assoc($res2); $prescCount = (int)$row['c']; }

$res3 = mysqli_query($con, "SELECT COUNT(*) as c FROM ind_prescription WHERE Status = 'Active'");
if ($res3) { $row = mysqli_fetch_assoc($res3); $activePresc = (int)$row['c']; }

$res4 = mysqli_query($con, "SELECT COUNT(*) as c FROM ind_prescription WHERE Status = 'Completed'");
if ($res4) { $row = mysqli_fetch_assoc($res4); $completedPresc = (int)$row['c']; }

$res5 = mysqli_query($con, "SELECT COUNT(*) as c FROM individual WHERE DATE(Time) = CURDATE()");
if ($res5) { $row = mysqli_fetch_assoc($res5); $todayUsers = (int)$row['c']; }

$res6 = mysqli_query($con, "SELECT COUNT(*) as c FROM ind_prescription WHERE DATE(Time) = CURDATE()");
if ($res6) { $row = mysqli_fetch_assoc($res6); $todayPresc = (int)$row['c']; }

// Get recent users
$recentUsers = mysqli_query($con, "SELECT Name, Username, Time FROM individual ORDER BY id DESC LIMIT 5");

// Get recent prescriptions
$recentPresc = mysqli_query($con, "SELECT Doctor_Name, Pateint_Username, Status, Time FROM ind_prescription ORDER BY id DESC LIMIT 5");

include __DIR__ . '/header.php';
?>
<style>
.dashboard-card {
    background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
    border: 1px solid #404040;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    border-color: #87ceeb;
}

.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #87ceeb, #4a90e2);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 15px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #87ceeb;
    margin-bottom: 5px;
}

.stat-label {
    color: #b0b0b0;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.activity-card {
    background-color: #2d2d2d;
    border: 1px solid #404040;
    border-radius: 15px;
    height: 400px;
}

.activity-item {
    padding: 12px 0;
    border-bottom: 1px solid #404040;
}

.activity-item:last-child {
    border-bottom: none;
}

.quick-action-btn {
    background: linear-gradient(135deg, #87ceeb 0%, #4a90e2 100%);
    border: none;
    border-radius: 10px;
    color: #1a1a1a;
    font-weight: 600;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(135, 206, 235, 0.3);
    color: #1a1a1a;
}

.welcome-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    border: 1px solid #404040;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-active {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid #28a745;
}

.status-completed {
    background-color: rgba(135, 206, 235, 0.2);
    color: #87ceeb;
    border: 1px solid #87ceeb;
}
</style>

<!-- Welcome Header -->
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="mb-2" style="color: #87ceeb;">
                <i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard
            </h2>
            <p class="mb-0" style="color: #b0b0b0;">
                Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>! 
                Here's what's happening with your medical platform today.
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="text-muted">
                <i class="fas fa-calendar-alt me-2"></i><?php echo date('F j, Y'); ?>
            </div>
            <div class="text-muted">
                <i class="fas fa-clock me-2"></i><?php echo date('g:i A'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card">
            <div class="card-body text-center p-4">
                <div class="stat-icon mx-auto" style="background: rgba(135, 206, 235, 0.2); color: #87ceeb;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number"><?php echo number_format($usersCount); ?></div>
                <div class="stat-label">Total Users</div>
                <small class="text-success">
                    <i class="fas fa-arrow-up me-1"></i>+<?php echo $todayUsers; ?> today
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card">
            <div class="card-body text-center p-4">
                <div class="stat-icon mx-auto" style="background: rgba(40, 167, 69, 0.2); color: #28a745;">
                    <i class="fas fa-prescription-bottle-alt"></i>
                </div>
                <div class="stat-number"><?php echo number_format($prescCount); ?></div>
                <div class="stat-label">Total Prescriptions</div>
                <small class="text-success">
                    <i class="fas fa-arrow-up me-1"></i>+<?php echo $todayPresc; ?> today
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card">
            <div class="card-body text-center p-4">
                <div class="stat-icon mx-auto" style="background: rgba(255, 193, 7, 0.2); color: #ffc107;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number"><?php echo number_format($activePresc); ?></div>
                <div class="stat-label">Active Prescriptions</div>
                <small class="text-warning">
                    <i class="fas fa-exclamation-circle me-1"></i>Pending
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card">
            <div class="card-body text-center p-4">
                <div class="stat-icon mx-auto" style="background: rgba(108, 117, 125, 0.2); color: #6c757d;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number"><?php echo number_format($completedPresc); ?></div>
                <div class="stat-label">Completed</div>
                <small class="text-muted">
                    <i class="fas fa-check me-1"></i>Finished
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-body p-4">
                <h5 class="mb-3" style="color: #87ceeb;">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="users.php" class="btn quick-action-btn w-100">
                            <i class="fas fa-users me-2"></i>View All Users
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="prescriptions.php" class="btn quick-action-btn w-100">
                            <i class="fas fa-prescription-bottle-alt me-2"></i>View Prescriptions
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button class="btn quick-action-btn w-100" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Data
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="../index.php" class="btn quick-action-btn w-100">
                            <i class="fas fa-external-link-alt me-2"></i>View Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="activity-card">
            <div class="card-body p-4">
                <h5 class="mb-3" style="color: #87ceeb;">
                    <i class="fas fa-user-plus me-2"></i>Recent Users
                </h5>
                <div style="max-height: 300px; overflow-y: auto;">
                    <?php if ($recentUsers && mysqli_num_rows($recentUsers) > 0): ?>
                        <?php while ($user = mysqli_fetch_assoc($recentUsers)): ?>
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong style="color: #ffffff;"><?php echo htmlspecialchars($user['Name']); ?></strong>
                                    <div class="text-muted small">@<?php echo htmlspecialchars($user['Username']); ?></div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($user['Time'])); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-users fa-2x mb-3"></i>
                            <p>No recent users</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="activity-card">
            <div class="card-body p-4">
                <h5 class="mb-3" style="color: #87ceeb;">
                    <i class="fas fa-prescription-bottle-alt me-2"></i>Recent Prescriptions
                </h5>
                <div style="max-height: 300px; overflow-y: auto;">
                    <?php if ($recentPresc && mysqli_num_rows($recentPresc) > 0): ?>
                        <?php while ($presc = mysqli_fetch_assoc($recentPresc)): ?>
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong style="color: #ffffff;">Dr. <?php echo htmlspecialchars($presc['Doctor_Name']); ?></strong>
                                    <div class="text-muted small">Patient: <?php echo htmlspecialchars($presc['Pateint_Username']); ?></div>
                                    <span class="status-badge <?php echo $presc['Status'] === 'Active' ? 'status-active' : 'status-completed'; ?>">
                                        <?php echo htmlspecialchars($presc['Status']); ?>
                                    </span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted"><?php echo date('M j, g:i A', strtotime($presc['Time'])); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-prescription-bottle-alt fa-2x mb-3"></i>
                            <p>No recent prescriptions</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
