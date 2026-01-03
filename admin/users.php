<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchQuery = '';
if (!empty($search)) {
    $searchQuery = " WHERE Name LIKE '%".mysqli_real_escape_string($con, $search)."%' 
                     OR Username LIKE '%".mysqli_real_escape_string($con, $search)."%' 
                     OR Email LIKE '%".mysqli_real_escape_string($con, $search)."%'
                     OR Blood_Type LIKE '%".mysqli_real_escape_string($con, $search)."%'
                     OR City LIKE '%".mysqli_real_escape_string($con, $search)."%'";
}

$result = mysqli_query($con, "SELECT id, Name, Username, Email, Phone, City, Blood_Type, Time FROM individual $searchQuery ORDER BY id ASC LIMIT 200");
$totalUsers = mysqli_query($con, "SELECT COUNT(*) as c FROM individual $searchQuery");
$totalCount = $totalUsers ? mysqli_fetch_assoc($totalUsers)['c'] : 0;

include __DIR__ . '/header.php';
?>
<style>
.users-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid #404040;
}

.search-box {
    background-color: #2d2d2d;
    border: 1px solid #404040;
    border-radius: 10px;
    color: #ffffff;
}

.search-box:focus {
    background-color: #2d2d2d;
    border-color: #87ceeb;
    box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
    color: #ffffff;
}

.users-table {
    background-color: #2d2d2d;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.table-dark th {
    background-color: #1a1a1a;
    border-color: #404040;
    color: #87ceeb;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table-dark td {
    border-color: #404040;
    vertical-align: middle;
}

.table-dark tbody tr:hover {
    background-color: rgba(135, 206, 235, 0.1);
}

.blood-type-badge {
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stats-card {
    background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
    border: 1px solid #404040;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
}

.export-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.export-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    color: white;
}
</style>

<!-- Users Header -->
<div class="users-header">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="mb-2" style="color: #87ceeb;">
                <i class="fas fa-users me-3"></i>Users Management
            </h2>
            <p class="mb-0" style="color: #b0b0b0;">
                Manage and monitor all registered users in the system
            </p>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <h4 class="mb-1" style="color: #87ceeb;"><?php echo number_format($totalCount); ?></h4>
                <small class="text-muted">Total Users<?php echo !empty($search) ? ' (Filtered)' : ''; ?></small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Actions -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control search-box me-2" 
                   placeholder="Search users by name, username, email, or city..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-info">
                <i class="fas fa-search"></i>
            </button>
            <?php if (!empty($search)): ?>
            <a href="users.php" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-times"></i>
            </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn export-btn" onclick="exportToCSV()">
            <i class="fas fa-download me-2"></i>Export CSV
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="users-table">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" id="usersTable">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-2"></i>NO</th>
                    <th><i class="fas fa-user me-2"></i>Name</th>
                    <th><i class="fas fa-at me-2"></i>Username</th>
                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                    <th><i class="fas fa-phone me-2"></i>Phone</th>
                    <th><i class="fas fa-map-marker-alt me-2"></i>City</th>
                    <th><i class="fas fa-tint me-2"></i>Blood Type</th>
                    <th><i class="fas fa-calendar me-2"></i>Registered</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><strong><?php echo (int)$row['id']; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2" style="width:35px;height:35px;background:#87ceeb;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#1a1a1a;font-weight:bold;">
                                    <?php echo strtoupper(substr($row['Name'], 0, 1)); ?>
                                </div>
                                <strong><?php echo htmlspecialchars($row['Name']); ?></strong>
                            </div>
                        </td>
                        <td><code>@<?php echo htmlspecialchars($row['Username']); ?></code></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                        <td>
                            <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                            <?php echo htmlspecialchars($row['City']); ?>
                        </td>
                        <td>
                            <span class="blood-type-badge" style="background-color: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545;">
                                <?php echo htmlspecialchars($row['Blood_Type']); ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?php echo date('M j, Y g:i A', strtotime($row['Time'])); ?>
                            </small>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No users found</h5>
                            <?php if (!empty($search)): ?>
                            <p class="text-muted">Try adjusting your search criteria</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.getElementById('usersTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    for (let i = 0; i < rows.length; i++) {
        const row = [];
        const cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            let text = cols[j].innerText.replace(/"/g, '""');
            row.push('"' + text + '"');
        }
        csv.push(row.join(','));
    }
    
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = 'users_export_' + new Date().toISOString().slice(0,10) + '.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<?php include __DIR__ . '/footer.php'; ?>
