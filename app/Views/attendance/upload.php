<?= $this->include('templates/header') ?>

<style>
/* Container */
.upload-attendance-container {
    max-width: 750px;
    margin: 50px auto 30px;
    padding: 30px 25px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: 0.3s;
}

/* Page Title */
.page-title {
    font-size: 28px;
    margin-bottom: 25px;
    color: #333;
    text-align: center;
    font-weight: 600;
}

/* Alerts */
.alert {
    padding: 12px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
    text-align: center;
}
.alert-error {
    background-color: #f8d7da;
    color: #842029;
}
.alert-success {
    background-color: #d1e7dd;
    color: #0f5132;
}

/* Form */
.attendance-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.attendance-form input[type="file"],
.attendance-form input[type="text"],
.attendance-form select,
.attendance-form input[type="time"],
.attendance-form input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: all 0.3s;
}

.attendance-form input:focus,
.attendance-form select:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
}

/* CSV Format Note */
.csv-format {
    font-size: 14px;
    color: #666;
    margin-bottom: 25px;
    text-align: center;
}

/* Form Buttons */
.form-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
    display: inline-block;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    text-align: center;
    cursor: pointer;
    min-width: 130px;
}

/* Primary Button */
.btn-primary {
    background-color: #27ae60;
    color: #fff;
    border: none;
}
.btn-primary:hover {
    background-color: #1e8449;
    transform: translateY(-2px);
}

/* Secondary Button */
.btn-secondary {
    background-color: #3498db;
    color: #fff;
    border: none;
}
.btn-secondary:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .upload-attendance-container {
        padding: 20px 15px;
        margin: 30px 10px;
    }
    .page-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    .btn-primary,
    .btn-secondary {
        width: 100%;
        min-width: auto;
    }
}
</style>

<div class="upload-attendance-container">
    <h2 class="page-title">Upload Attendance for Event #<?= $event_id ?></h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- CSV Upload Form -->
    <form method="post" action="<?= base_url('event/'.$event_id.'/attendance/store') ?>" enctype="multipart/form-data" class="attendance-form">
        <label for="csv_file">Select CSV File</label>
        <input type="file" id="csv_file" name="csv_file">

        <p class="csv-format">CSV format: <code>student_id,student_name,status,time_in,time_out,fine_amount</code></p>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Upload CSV</button>
            <a href="<?= base_url('event/'.$event_id.'/attendance/view') ?>" class="btn-secondary">View Attendance</a>
            <a href="<?= base_url('event/'.$event_id.'/attendance/export') ?>" class="btn-secondary">Export CSV</a>
        </div>
    </form>

    <hr style="margin: 40px 0;">

    <!-- Manual Attendance Form -->
    <form method="post" action="<?= base_url('event/'.$event_id.'/attendance/manual_store') ?>" class="attendance-form">
        <h3 style="text-align:center; margin-bottom: 20px;">Add Attendance Manually</h3>

        <label for="student_id">Student ID</label>
        <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required>

        <label for="student_name">Student Name</label>
        <input type="text" id="student_name" name="student_name" placeholder="Enter student name" required>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="present">Present</option>
            <option value="absent">Absent</option>
            <option value="late">Late</option>
        </select>

        <label for="time_in">Time In</label>
        <input type="time" id="time_in" name="time_in">

        <label for="time_out">Time Out</label>
        <input type="time" id="time_out" name="time_out">

        <label for="fine_amount">Fine Amount</label>
        <input type="number" step="0.01" id="fine_amount" name="fine_amount" placeholder="0.00">

        <div class="form-actions">
            <button type="submit" class="btn-primary">Add Attendance</button>
        </div>
    </form>
</div>

<?= $this->include('templates/footer') ?>
