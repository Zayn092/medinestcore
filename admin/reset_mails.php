<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';

function generateResetToken() {
    $bytes = random_bytes(32); // 64 hex chars
    return bin2hex($bytes);
}

// Handle action: process a single pending request
if (isset($_GET['action']) && $_GET['action'] === 'process' && isset($_GET['email'])) {
    $email = mysqli_real_escape_string($con, $_GET['email']);

    // Verify request exists and is pending/wait
    $req = mysqli_query($con, "SELECT Email, Status FROM reset_mails WHERE Email = '$email' AND Status IN ('Wait','Pending') ORDER BY id DESC LIMIT 1");
    if ($req && mysqli_num_rows($req) === 1) {
        // Generate token and store on individual
        $token = generateResetToken();
        $updUser = mysqli_query($con, "UPDATE individual SET reset_token = '$token' WHERE Email = '$email' LIMIT 1");
        if ($updUser && mysqli_affected_rows($con) === 1) {
            // Mark reset_mails as complete
            mysqli_query($con, "UPDATE reset_mails SET Status = 'Complete' WHERE Email = '$email'");
            // Redirect to reset_email preview page
            header('Location: reset_email.php?email=' . urlencode($email) . '&token=' . urlencode($token));
            exit();
        }
    }

    // Fallback: go back to list if anything fails
    header('Location: reset_mails.php');
    exit();
}

include __DIR__ . '/header.php';
?>
<style>
.card-dark {
    background: #1a1a1a;
    border: 1px solid #2f2f2f;
    border-radius: 12px;
}
.status-pill {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
}
.status-wait { background: rgba(255,193,7,.15); color: #ffc107; border: 1px solid #ffc107; }
.status-complete { background: rgba(40,167,69,.15); color: #28a745; border: 1px solid #28a745; }
</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-body">
                    <h4 class="mb-0" style="color:#87ceeb"><i class="fas fa-envelope-open-text me-2"></i>Reset Password Requests</h4>
                    <small class="text-muted">Manage user password reset requests from the queue</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $res = mysqli_query($con, "SELECT Email, Status FROM reset_mails WHERE Status = 'Wait' ORDER BY id DESC LIMIT 500");
                                if ($res && mysqli_num_rows($res) > 0):
                                    while ($row = mysqli_fetch_assoc($res)):
                                        $st = strtolower($row['Status']);
                                        $isPending = in_array($st, ['wait','pending']);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                    <td>
                                        <?php if ($isPending): ?>
                                            <span class="status-pill status-wait">Pending</span>
                                        <?php else: ?>
                                            <span class="status-pill status-complete">Complete</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($isPending): ?>
                                            <a class="btn btn-sm btn-warning" href="?action=process&email=<?php echo urlencode($row['Email']); ?>">
                                                <i class="fas fa-hourglass-half me-1"></i>Pending
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-check me-1"></i>Completed
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No reset requests found</td>
                                </tr>
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


