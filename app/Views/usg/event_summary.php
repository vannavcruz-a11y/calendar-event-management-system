<style>
    .attendance-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 25px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.page-title {
    font-size: 26px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.analytics-card {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.analytics-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.analytics-list li {
    font-size: 16px;
    margin-bottom: 10px;
    color: #333;
}

.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

.attendance-table th,
.attendance-table td {
    padding: 12px 15px;
    text-align: left;
}

.attendance-table th {
    background-color: #f0f0f0;
    color: #333;
}

.attendance-table tr:nth-child(even) {
    background-color: #fafafa;
}

.attendance-table tr:hover {
    background-color: #f1f1f1;
}

.no-data {
    text-align: center;
    font-style: italic;
    color: #999;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-secondary {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
    background-color: #3498db;
    color: #fff;
    transition: 0.3s;
}

.btn-secondary:hover {
    background-color: #2980b9;
}

</style>
<?= $this->include('templates/header') ?>

<div class="attendance-container">
    <h2 class="page-title">Attendance for Event: <?= $event['title'] ?></h2>

    <!-- Analytics Section -->
    <div class="analytics-card">
        <ul class="analytics-list">
            <li><strong>Total Students Present:</strong> <?= $totalPresent ?></li>
            <li><strong>Total Students Absent:</strong> <?= $totalAbsent ?></li>
            <li><strong>Total Fines Collected:</strong> ₱<?= number_format($totalFines, 2) ?></li>
        </ul>
    </div>

    <!-- Attendance Table -->
    <div class="table-container">
        <table class="dashboard-table attendance-table">
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Fine Amount</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($attendance)): ?>
                    <?php foreach($attendance as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['student_id'] ?></td>
                            <td><?= $row['student_name'] ?></td>
                            <td><?= ucfirst($row['status']) ?></td>
                            <td><?= !empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : '-' ?></td>
                            <td><?= !empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                            <td>₱<?= number_format($row['fine_amount'],2) ?></td>
                          <td><?= !empty($row['recorded_at']) ? date('M d, Y h:i A', strtotime($row['recorded_at'])) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="no-data">No attendance records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="action-buttons">
        <a href="<?= base_url('campus/'.$campus_id) ?>" class="btn-secondary">Back to Campus Events</a>

    <?php if(session()->get('role') === 'usg'): ?>
        <a href="<?= base_url('usg') ?>" class="btn-secondary">Back to Dashboard</a>
    <?php endif; ?>
</div>

</div>

<?= $this->include('templates/footer') ?>
