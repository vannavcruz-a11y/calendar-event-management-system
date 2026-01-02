<?= $this->include('templates/header') ?>

<style>
.attendance-container {
    max-width: 1100px;
    margin: 30px auto;
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

.event-card {
    display: flex;
    gap: 20px;
    background-color: #f8f9fa;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.event-card img {
    max-width: 220px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.event-details {
    flex: 1;
}

.event-details h3 {
    margin-top: 0;
    color: #2c3e50;
}

.event-details p {
    margin: 5px 0;
}

.action-buttons {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
}

.btn-primary {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    background-color: #27ae60;
    color: #fff;
    font-weight: 500;
    text-decoration: none;
    transition: 0.3s;
    text-align: center;
}

.btn-primary:hover {
    background-color: #1e8449;
}

.table-container {
    overflow-x: auto;
    margin-top: 10px;
}

#attendanceSearch {
    margin-bottom: 10px;
    padding: 10px 15px;
    width: 300px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
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

<div class="attendance-container">
    <h2 class="page-title">Attendance for Event #<?= isset($event_id) ? $event_id : '' ?></h2>

    <!-- Event Details Card -->
    <?php if(isset($event) && !empty($event)): ?>
    <div class="event-card">
        <!-- Poster -->
       

        <!-- Details -->
        <div class="event-details">
            <h3><?= esc($event['title']) ?></h3>
            <p><strong>Campus ID:</strong> <?= esc($event['campus_id']) ?></p>
            <p><strong>Organization:</strong> <?= esc($event['org_name'] ?? $event['org_name'] ?? '-') ?></p>
            <p><strong>Description:</strong> <?= esc($event['description']) ?></p>
            <p><strong>Date:</strong> <?= date('M d, Y', strtotime($event['date'])) ?></p>
            <p><strong>Time:</strong> <?= date('h:i A', strtotime($event['time_in'])) ?> - <?= date('h:i A', strtotime($event['time_out'])) ?></p>
            <p><strong>Location:</strong> <?= esc($event['location']) ?></p>
            <p><strong>Created By:</strong> <?= esc($event['created_by']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Export Button -->
    <div class="action-buttons">
        <a href="<?= base_url('event/'.(isset($event_id) ? $event_id : '').'/attendance/export') ?>" class="btn-primary">
            Export CSV
        </a>
    </div>

    <!-- Search -->
    <input type="text" id="attendanceSearch" placeholder="Search attendance by student name...">

    <!-- Attendance Table -->
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
                <?php if(!empty($attendance) && isset($attendance)): ?>
                    <?php foreach($attendance as $row): ?>
                        <tr>
                            <td><?= $row['record_id'] ?></td>
                            <td><?= $row['student_id'] ?></td>
                            <td><?= $row['student_name'] ?></td>
                            <td><?= ucfirst($row['status']) ?></td>
                            <td><?= !empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : '-' ?></td>
                            <td><?= !empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                            <td><?= number_format($row['fine_amount'], 2) ?></td>
                            <td><?= !empty($row['recorded_at']) ? date('M d, Y h:i A', strtotime($row['recorded_at'])) : '-' ?></td>
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

<script>
// SEARCH FUNCTIONALITY
document.getElementById('attendanceSearch').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.attendance-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});
</script>

<?= $this->include('templates/footer') ?>
