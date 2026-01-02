<?= $this->include('templates/header') ?>

<style>
/* Page Container */
.student-list-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.section-header h2 {
    font-size: 28px;
    color: #2c3e50;
}

/* Search Input */
.search-input {
    padding: 10px 14px;
    width: 300px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

.search-input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
}

/* Card wrapper */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    padding: 12px 16px;
    text-align: left;
}

th {
    background: #f4f6f8;
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
}

tr {
    border-bottom: 1px solid #e0e0e0;
    transition: background 0.2s;
}

tr:hover {
    background: #f9f9f9;
}

.empty-row td {
    text-align: center;
    padding: 20px;
    font-style: italic;
    color: #888;
}

/* Event Card */
.event-card {
    padding: 20px;
    border-radius: 12px;
    background-color: #f8f9fa;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    margin-bottom: 10px;
}

.event-card h3 {
    margin-top: 0;
    margin-bottom: 10px;
    color: #2c3e50;
}

.event-card p {
    margin: 4px 0;
    font-size: 14px;
    color: #444;
}

.event-card img {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 10px;
}

/* Delete Button */
.delete-btn {
    padding: 6px 12px;
    background-color: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s;
}

.delete-btn:hover {
    background-color: #c0392b;
}
</style>

<div class="student-list-container">

    <!-- STUDENT LIST SECTION -->
    <div class="card">
        <div class="section-header">
            <h2><?= esc($campus['name']) ?> – Student List</h2>
            <input type="text" id="studentSearch" class="search-input" placeholder="Search student...">
        </div>
<?php if(session()->get('campus_id') == $campus['id'] && !empty($students)): ?>
    <button class="delete-btn" 
        onclick="confirmDeleteAllStudents(<?= $campus['id'] ?>)">
        Delete All Students
    </button>
<?php endif; ?>
        <table c
        lass="student-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <?php if(session()->get('campus_id') == $campus['id']): ?>
                        
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($students)): ?>
                    <tr class="empty-row">
                        <td colspan="6">No students found.</td>
                    </tr>
                <?php else: ?>
                   <?php foreach($students as $i => $s): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= esc($s['student_id']) ?></td>
        <td><?= esc($s['full_name']) ?></td>
        <td><?= esc($s['course']) ?></td>
        <td><?= esc($s['year_level']) ?></td>
        <?php if(session()->get('campus_id') == $campus['id']): ?>
            
        <?php endif; ?>
    </tr>
<?php endforeach; ?>

                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- EVENTS & ATTENDANCE SECTION -->
    <div class="card">
        <div class="section-header">
            <h2>Events & Attendance Records</h2>
            <input type="text" id="eventSearch" class="search-input" placeholder="Search event/attendance...">
        </div>

        <?php if(!empty($attendancePerEvent)): ?>
            <?php foreach($attendancePerEvent as $eventData): ?>
                <?php $event = $eventData['event']; ?>
                <?php $attendance = $eventData['attendance']; ?>

               <!-- Event Card -->
<div class="event-card">
    <?php if(!empty($event['poster'])): ?>
        <img src="<?= base_url('uploads/'.$event['poster']) ?>" alt="Event Poster">
    <?php endif; ?>
    <div style="display:flex; justify-content: space-between; align-items:center;">
        <h3><?= esc($event['title']) ?></h3>
        <?php if(session()->get('campus_id') == $campus['id']): ?>
            <button class="delete-btn" onclick="confirmDeleteAllAttendance(<?= $event['id'] ?>)">
                Delete All Attendance
            </button>
        <?php endif; ?>
    </div>
    <p><strong>Date:</strong> <?= date('M d, Y', strtotime($event['date'])) ?></p>
    <p><strong>Time:</strong> <?= date('h:i A', strtotime($event['time_in'])) ?> - <?= date('h:i A', strtotime($event['time_out'])) ?></p>
    <p><strong>Location:</strong> <?= esc($event['location']) ?></p>
    <p><strong>Created By:</strong> <?= esc($event['created_by']) ?></p>
</div>
                <!-- Attendance Table -->
                <div class="card">
                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Fine</th>
                                <?php if(session()->get('campus_id') == $campus['id']): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($attendance)): ?>
                                <tr>
                                    <td colspan="7" class="empty-row">No attendance records.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($attendance as $row): ?>
                                    <tr>
                                        <td><?= esc($row['student_id']) ?></td>
                                        <td><?= esc($row['student_name']) ?></td>
                                        <td><?= ucfirst($row['status']) ?></td>
                                        <td><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '-' ?></td>
                                        <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                                        <td><?= number_format($row['fine_amount'], 2) ?></td>
                                        <?php if(session()->get('campus_id') == $campus['id']): ?>
                                            <td>
                                                <button class="delete-btn" onclick="confirmDeleteAttendance(<?= $row['id'] ?>)">Delete</button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-row">No events found.</p>
        <?php endif; ?>
    </div>

</div>

<script>
/* SEARCH FUNCTIONALITY */
document.getElementById('studentSearch').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.student-table tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

document.getElementById('eventSearch').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    document.querySelectorAll('.event-card, .attendance-table tbody tr').forEach(el => {
        if(el.tagName === 'TR' && el.classList.contains('empty-row')) return;
        el.style.display = el.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

/* DELETE FUNCTIONS */

function confirmDeleteAttendance(attendanceId) {
    if(confirm('Are you sure you want to delete this attendance record?')) {
        window.location.href = "<?= base_url('attendance/delete') ?>/" + attendanceId;
    }

}function confirmDeleteAllStudents(campusId) {
    if(confirm('Are you sure you want to delete ALL students for this campus?')) {
        window.location.href = "<?= base_url('student/deleteAll') ?>/" + campusId;
    }
}

function confirmDeleteAllAttendance(eventId) {
    if(confirm('Are you sure you want to delete ALL attendance records for this event?')) {
        window.location.href = "<?= base_url('attendance/deleteAll') ?>/" + eventId;
    }
}

</script>

<?= $this->include('templates/footer') ?>
