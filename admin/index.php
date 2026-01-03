<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
	header('Location: dashboard.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Admin Login - MediNestCore" />
    <meta name="keywords" content="Admin, Login, Healthcare, Medical" />
    <meta name="author" content="MediNestCore" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - MediNestCore</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous" />
    <script
      src="https://kit.fontawesome.com/6377024aba.js"
      crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" type="image/x-icon" href="../pics/logo.png" />
    <style>
<?PHP include ("../css/log.css"); ?> 
.logo-icon img {
  width: 60px;      /* adjust to your design */
  height: auto;
  display: block;
}

</style>
</head>
<body>
<!-----------------------------------------  BODY START  -------------------------------------------------------->
    
    <!-------------------------------- FORM --------------------------------------------------------->

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
      <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <!-- Logo Section -->
          <div class="logo-section">
            <div class="logo-icon">
  <img src="pics/logo.png" alt="Logo">
</div>

            <div class="logo-text">MediNestCore</div>
            <div class="logo-subtitle">Admin Portal Access</div>
            <div class="status-badges">
              <div class="status-badge">
                <i class="fas fa-cog"></i>
                <span>Administrative</span>
              </div>
              <div class="status-badge">
                <i class="fas fa-lock"></i>
                <span>Secure</span>
              </div>
            </div>
          </div>
          
          <!-- Login Form -->
          <div class="login-form">
            <div class="text">Admin Login</div>
            <div class="subtitle">Access administrative dashboard</div>
            
            <?php if (isset($_GET['e'])): ?>
            <div class="alert alert-danger py-2 mb-3" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545;">
                <i class="fas fa-exclamation-triangle me-2"></i>Invalid credentials
            </div>
            <?php endif; ?>
            
            <form method="post" action="login.php" class="MainForm" id="AdminLog">
              <div class="field mb-3">
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-0">
                    <i class="fas fa-user-tie"></i>
                  </span>
                  <input type="text" name="username" placeholder="Enter admin username" class="form-control border-0" required>
                </div>
              </div>
              <div class="field mb-4">
                <div class="input-group">
                  <span class="input-group-text bg-transparent border-0">
                    <i class="fas fa-key"></i>
                  </span>
                  <input type="password" name="password" placeholder="Enter admin password" class="form-control border-0" required>
                </div>
              </div>
              
              <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>Admin Sign In
              </button>
              
              <div class="text-center mb-3">
                <span class="text-divider">OR</span>
              </div>
            </form>
            
            <button type="button" class="btn btn-outline-secondary w-100 mb-3" onclick="window.location.href='../index.php'">
              <i class="fas fa-arrow-left me-2"></i>Back to Patient Login
            </button>
            
            
          </div>
          
          
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
</body>
</html>
