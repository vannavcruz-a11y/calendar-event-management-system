<style>
    .attendance-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.page-title {
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
}

.action-buttons {
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
}

.btn-primary,
.btn-secondary {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}

.btn-primary {
    background-color: #27ae60;
    color: #fff;
}

.btn-primary:hover {
    background-color: #1e8449;
}

.btn-secondary {
    background-color: #3498db;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #2980b9;
}

.table-container {
    overflow-x: auto;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border-radius: 10px;
    overflow: hidden;
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
    color: #999;
    font-style: italic;
}

</style>
<?=  $this->include('templates/header') ?>

<div class="attendance-container">
    <h2 class="page-title">Attendance for Event: <?= $event['title'] ?></h2>

    <div class="action-buttons">
        <a href="<?= base_url('event/'.$event['id'].'/attendance/export') ?>" class="btn-primary">
            Export CSV
        </a>
        <a href="<?= base_url('usg/campus/'.$event['campus_id']) ?>" class="btn-secondary">
            Back to Campus Events
        </a>
    </div>

    <div class="table-container">
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Fine Amount</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($attendance)): ?>
                    <?php foreach($attendance as $row): ?>
                        <tr>
                            <td><?= $row['record_id'] ?></td>
                            <td><?= $row['student_id'] ?></td>
                            <td><?= $row['student_name'] ?></td>
                            <td><?= ucfirst($row['status']) ?></td>
                            <td><?= !empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : '-' ?></td>
                            <td><?= !empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                            <td><?= number_format($row['fine_amount'],2) ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($row['recorded_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="no-data">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('templates/footer') ?>
