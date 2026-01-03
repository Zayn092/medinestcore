<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../connection.php';

// Search and filter functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$searchQuery = '';
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(Doctor_Name LIKE '%".mysqli_real_escape_string($con, $search)."%' 
                     OR Pateint_Username LIKE '%".mysqli_real_escape_string($con, $search)."%' 
                     OR Pateint_id LIKE '%".mysqli_real_escape_string($con, $search)."%')";
}

if (!empty($statusFilter)) {
    $conditions[] = "Status = '".mysqli_real_escape_string($con, $statusFilter)."'";
}

if (!empty($conditions)) {
    $searchQuery = " WHERE " . implode(" AND ", $conditions);
}

$query = "SELECT id, Doctor_Name, Pateint_Username, Pateint_id, Status, Time, Medicine_Name, Notes FROM ind_prescription $searchQuery ORDER BY id ASC LIMIT 200";
$result = mysqli_query($con, $query);

$totalPresc = mysqli_query($con, "SELECT COUNT(*) as c FROM ind_prescription $searchQuery");
$totalCount = $totalPresc ? mysqli_fetch_assoc($totalPresc)['c'] : 0;

include __DIR__ . '/header.php';
?>
<style>
.prescriptions-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid #404040;
}

.search-box, .filter-select {
    background-color: #2d2d2d;
    border: 1px solid #404040;
    border-radius: 10px;
    color: #ffffff;
}

.search-box:focus, .filter-select:focus {
    background-color: #2d2d2d;
    border-color: #87ceeb;
    box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
    color: #ffffff;
}

.filter-select option {
    background-color: #2d2d2d;
    color: #ffffff;
}

.prescriptions-table {
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

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background-color: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 1px solid #ffc107;
}

.status-completed {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid #28a745;
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

.view-btn {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 0.8rem;
    padding: 4px 8px;
    transition: all 0.3s ease;
}

.view-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    color: white;
}
</style>

<!-- Prescriptions Header -->
<div class="prescriptions-header">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="mb-2" style="color: #87ceeb;">
                <i class="fas fa-prescription-bottle-alt me-3"></i>Prescriptions Management
            </h2>
            <p class="mb-0" style="color: #b0b0b0;">
                Monitor and manage all medical prescriptions in the system
            </p>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <h4 class="mb-1" style="color: #87ceeb;"><?php echo number_format($totalCount); ?></h4>
                <small class="text-muted">Total Prescriptions<?php echo (!empty($search) || !empty($statusFilter)) ? ' (Filtered)' : ''; ?></small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-md-10">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control search-box" 
                   placeholder="Search by doctor, patient username, or patient ID..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <select name="status" class="form-select filter-select" style="max-width: 150px;">
                <option value="">All Status</option>
                <option value="Active" <?php echo $statusFilter === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Completed" <?php echo $statusFilter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
            <button type="submit" class="btn btn-outline-info">
                <i class="fas fa-search"></i>
            </button>
            <?php if (!empty($search) || !empty($statusFilter)): ?>
            <a href="prescriptions.php" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-2 text-end">
        <button class="btn export-btn w-100" onclick="exportToCSV()">
            <i class="fas fa-download me-2"></i>Export
        </button>
    </div>
</div>

<!-- Prescriptions Table -->
<div class="prescriptions-table">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" id="prescriptionsTable">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-2"></i>No</th>
                    <th><i class="fas fa-user-md me-2"></i>Doctor</th>
                    <th><i class="fas fa-user me-2"></i>Patient</th>
                    <th><i class="fas fa-id-card me-2"></i>Patient ID</th>
                    <th><i class="fas fa-pills me-2"></i>Medicine</th>
                    <th><i class="fas fa-flag me-2"></i>Status</th>
                    <th><i class="fas fa-calendar me-2"></i>Date</th>
                    <th><i class="fas fa-eye me-2"></i>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><strong><?php echo (int)$row['id']; ?></strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2" style="width:35px;height:35px;background:#28a745;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div>
                                    <strong>Dr. <?php echo htmlspecialchars($row['Doctor_Name']); ?></strong>
                                </div>
                            </div>
                        </td>
                        <td><code>@<?php echo htmlspecialchars($row['Pateint_Username']); ?></code></td>
                        <td><strong><?php echo htmlspecialchars($row['Pateint_id']); ?></strong></td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($row['Medicine_Name']); ?>">
                                <i class="fas fa-pills me-1 text-info"></i>
                                <?php echo htmlspecialchars($row['Medicine_Name']); ?>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $row['Status'] === 'Active' ? 'status-active' : 'status-completed'; ?>">
                                <i class="fas <?php echo $row['Status'] === 'Active' ? 'fa-clock' : 'fa-check-circle'; ?> me-1"></i>
                                <?php echo htmlspecialchars($row['Status']); ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?php echo date('M j, Y g:i A', strtotime($row['Time'])); ?>
                            </small>
                        </td>
                        <td>
                            <a href="../ind_Details.php?extend=<?php echo $row['id']; ?>" class="btn view-btn" target="_blank" title="View Full Prescription">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <button class="btn btn-danger btn-sm delete-prescription-btn ms-2" 
                                    data-id="<?php echo $row['id']; ?>" 
                                    title="Delete Prescription"
                                    onclick="deletePrescription(this)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-prescription-bottle-alt fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No prescriptions found</h5>
                            <?php if (!empty($search) || !empty($statusFilter)): ?>
                            <p class="text-muted">Try adjusting your search criteria or filters</p>
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
    const table = document.getElementById('prescriptionsTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    for (let i = 0; i < rows.length; i++) {
        const row = [];
        const cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length - 1; j++) { // Exclude action column
            let text = cols[j].innerText.replace(/"/g, '""');
            row.push('"' + text + '"');
        }
        csv.push(row.join(','));
    }
    
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = 'prescriptions_export_' + new Date().toISOString().slice(0,10) + '.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
<script>
function deletePrescription(button) {
    const id = button.getAttribute('data-id');

    if (!confirm("Are you sure you want to delete this prescription?")) {
        return;
    }

    // Send AJAX request to delete the record
    fetch('delete_prescription.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(id)
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'success') {
            // Remove the row from the table
            const row = button.closest('tr');
            row.remove();
            alert('Prescription deleted successfully!');
        } else {
            alert('Error: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    });
}
</script>

<?php include __DIR__ . '/footer.php'; ?>
