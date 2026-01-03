<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$emailEsc = mysqli_real_escape_string($con, $email);

// Try to fetch token from DB if not provided
if (!$token && $email) {
    $q = mysqli_query($con, "SELECT reset_token FROM individual WHERE Email='$emailEsc' LIMIT 1");
    if ($q && mysqli_num_rows($q) === 1) {
        $row = mysqli_fetch_assoc($q);
        $token = $row['reset_token'] ?? '';
    }
}

// Public reset URL for the user
$baseUrl = dirname(dirname($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
// Ensure it points to project root and then to reset_password.php
$resetUrl = $baseUrl . '/reset_password.php?email=' . urlencode($email) . '&token=' . urlencode($token);

include __DIR__ . '/header.php';
?>
<style>
.card-dark { background:#1a1a1a; border:1px solid #2f2f2f; border-radius:12px; }
.copy-input { background:#ffffff; color:#000000; border:1px solid #87ceeb; box-shadow: inset 0 0 0 1px rgba(135,206,235,0.15); }
.copy-input::placeholder { color:#6b7280; }
label.form-label { color:#d1d5db; }
.email-preview { background:#0f0f0f; border:1px solid #333; border-radius:12px; padding:20px; }
</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-dark">
                <div class="card-body">
                    <h4 class="mb-0" style="color:#87ceeb"><i class="fas fa-paper-plane me-2"></i>Reset Email Preview</h4>
                    <small class="text-muted">Copy and send this email to the user</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card card-dark">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Recipient Email</label>
                        <input type="text" class="form-control copy-input" value="<?php echo htmlspecialchars($email); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reset URL</label>
                        <input type="text" class="form-control copy-input" value="<?php echo htmlspecialchars($resetUrl); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Token</label>
                        <input type="text" class="form-control copy-input" value="<?php echo htmlspecialchars($token); ?>" readonly>
                    </div>
                    <a href="reset_mails.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back to Requests</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="email-preview">
                <h5 style="color:#87ceeb">Password Reset Request - MediNestCore</h5>
                <p>Dear User,</p>
                <p>We received a request to reset the password for the MediNestCore account associated with <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
                <p>To reset your password, click the secure link below or paste it into your browser:</p>
                <p><a href="<?php echo htmlspecialchars($resetUrl); ?>" target="_blank"><?php echo htmlspecialchars($resetUrl); ?></a></p>
                <p>Your reset token is:</p>
                <pre style="background:#111;padding:10px;border-radius:8px;border:1px solid #333; color:#87ceeb;"><?php echo htmlspecialchars($token); ?></pre>
                <p>If you did not request this change, you can safely ignore this email.</p>
                <p>Best regards,<br/>MediNestCore Support</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>


