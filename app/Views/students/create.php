<?= $this->include('templates/header') ?>

<style>
/* Container */
.student-form-wrapper {
    max-width: 700px;
    margin: 40px auto;
    padding: 0 15px;
}

/* Form Card */
.student-form-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-bottom: 40px;
    transition: 0.3s;
}

.student-form-card h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 25px;
}

/* Labels & Inputs */
.student-form-card label {
    display: block;
    font-weight: 600;
    color: #34495e;
    margin-top: 15px;
    margin-bottom: 6px;
}

.student-form-card input,
.student-form-card select {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: border .3s, box-shadow .3s;
}

.student-form-card input:focus,
.student-form-card select:focus {
    outline: none;
    border-color: #4a90e2;
    box-shadow: 0 0 0 2px rgba(74,144,226,0.15);
}

/* Buttons */
.student-form-card button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 25px;
    transition: transform .2s, box-shadow .2s;
}

.student-form-card button.save-btn {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: #fff;
}

.student-form-card button.upload-btn {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: #fff;
}

.student-form-card button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Small text / notes */
.student-form-card p.note {
    margin-top: 10px;
    font-size: 13px;
    color: #777;
}

/* Responsive */
@media (max-width: 768px) {
    .student-form-card {
        padding: 20px 15px;
    }
}
</style>

<div class="student-form-wrapper">

    <!-- Add Student Form -->
    <div class="student-form-card">
        <h2>Add Student</h2>
        <form method="post" action="<?= base_url('usg/students/store') ?>">
            <input type="hidden" name="campus_id" value="<?= $campus_id ?>">

            <label for="student_id">Student ID</label>
            <input id="student_id" type="text" name="student_id" required>

            <label for="full_name">Full Name</label>
            <input id="full_name" type="text" name="full_name" required>

            <label for="course">Course</label>
            <input id="course" type="text" name="course" required>

            <label for="year_level">Year Level</label>
            <select id="year_level" name="year_level">
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>

            <button type="submit" class="save-btn">
                <i class="fa-solid fa-save"></i> Save Student
            </button>
        </form>
    </div>

    <!-- Upload Students Form -->
    <div class="student-form-card">
        <h2>Upload Students (CSV)</h2>
        <form method="post"
              action="<?= base_url('usg/students/upload') ?>"
              enctype="multipart/form-data">

            <input type="hidden" name="campus_id" value="<?= $campus_id ?>">

            <label>CSV File (student_id, full_name, course, year_level)</label>
            <input type="file" name="csv_file" accept=".csv" required>

            <button type="submit" class="upload-btn">
                <i class="fa-solid fa-file-upload"></i> Upload Students
            </button>

            <p class="note">
                Allowed format: <strong>.csv</strong> only
            </p>
        </form>
    </div>

</div>

<?= $this->include('templates/footer') ?>
