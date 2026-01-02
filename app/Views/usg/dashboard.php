<?= $this->include('templates/header') ?>

<style>
/* Body & Container */
.dashboard-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 30px 25px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

.dashboard-container h2 {
    font-size: 34px;
    text-align: center;
    color: #2c3e50;
    margin-bottom: 40px;
}

.dashboard-container h3 {
    font-size: 22px;
    color: #34495e;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 5px;
    margin-top: 40px;
    margin-bottom: 25px;
}

/* Campus Buttons */
.campus-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-bottom: 35px;
}

.campus-btn {
    display: inline-block;
    padding: 12px 24px;
    background-color: #4a90e2;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.campus-btn:hover {
    background-color: #357ab8;
    transform: translateY(-2px);
}

/* Analytics Cards */
.analytics-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-bottom: 50px;
}

.analytics-card {
    flex: 1 1 220px;
    max-width: 260px;
    background: linear-gradient(135deg, #4a90e2, #357ab8);
    color: #fff;
    padding: 25px 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.analytics-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.analytics-card h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
    font-weight: 500;
}

.analytics-card p {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
}

/* Charts Container */
.charts-container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    margin-bottom: 50px;
}

.charts-container canvas {
    max-width: 450px;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

/* Table */
.dashboard-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    margin-bottom: 50px;
}

.dashboard-table th,
.dashboard-table td {
    padding: 14px 18px;
    text-align: center;
}

.dashboard-table th {
    background-color: #4a90e2;
    color: #fff;
    font-weight: 600;
}

.dashboard-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.dashboard-table tr:hover {
    background-color: #e8f0fe;
    transition: background 0.3s;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .analytics-cards {
        gap: 15px;
    }
    .charts-container canvas {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 20px 15px;
    }
    .dashboard-container h2 {
        font-size: 28px;
    }
    .dashboard-container h3 {
        font-size: 20px;
    }
    .campus-btn {
        padding: 8px 16px;
        font-size: 14px;
    }
    .dashboard-table th, .dashboard-table td {
        padding: 8px 10px;
        font-size: 13px;
    }
}
</style>

<?php
// Initialize attendance safely
$totalPresent = 0;
$totalAbsent = 0;
$totalFinesEvent = 0;

if(isset($attendance) && !empty($attendance)){
    foreach($attendance as $row){
        $totalFinesEvent += $row['fine_amount'];
        if(strtolower($row['status']) === 'present') $totalPresent++;
        elseif(strtolower($row['status']) === 'absent') $totalAbsent++;
    }
}
?>

<div class="dashboard-container">
    <h2>USG Dashboard</h2>

    <h3>Campuses</h3>
    <div class="campus-buttons">
        <?php foreach($campuses as $campus): ?>
            <a class="campus-btn" href="<?= base_url('usg/campus/'.$campus['id']) ?>">
                <?= $campus['name'] ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- KPI Cards -->
    <h3>Key Metrics</h3>
    <div class="analytics-cards">
        <div class="analytics-card">
            <h4>Total Fines Collected</h4>
            <p>₱<?= number_format($total_fines,2) ?></p>
        </div>
        <div class="analytics-card">
            <h4>Attendance Rate</h4>
            <p><?= number_format($attendance_rate,2) ?>%</p>
        </div>
        <div class="analytics-card">
            <h4>Total Events</h4>
            <p><?= array_sum(array_column($eventsPerCampus,'events_count')) ?></p>
        </div>
    </div>

    <!-- Charts -->
    <?php if($totalPresent + $totalAbsent > 0 || !empty($eventsPerCampus)): ?>
    <h3>Visual Analytics</h3>
    <div class="charts-container">
        <?php if($totalPresent + $totalAbsent > 0): ?>
            <canvas id="attendanceChart"></canvas>
        <?php endif; ?>
        <canvas id="finesChart"></canvas>
        <canvas id="eventsChart"></canvas>
    </div>
    <?php endif; ?>

    <!-- Events Table -->
    <h3>Events per Campus</h3>
    <table class="dashboard-table">
        <tr>
            <th>Campus</th>
            <th>Events Count</th>
        </tr>
        <?php foreach($eventsPerCampus as $row): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['events_count'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if($totalPresent + $totalAbsent > 0): ?>
        <h3>Attendance Summary: <?= $event['title'] ?? '' ?></h3>
        <div class="analytics-cards">
            <div class="analytics-card">
                <h4>Total Students Present</h4>
                <p><?= $totalPresent ?></p>
            </div>
            <div class="analytics-card">
                <h4>Total Students Absent</h4>
                <p><?= $totalAbsent ?></p>
            </div>
            <div class="analytics-card">
                <h4>Total Fines Collected</h4>
                <p>₱<?= number_format($totalFinesEvent, 2) ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if($totalPresent + $totalAbsent > 0): ?>
// Attendance Pie Chart
new Chart(document.getElementById('attendanceChart'), {
    type: 'pie',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [<?= $totalPresent ?>, <?= $totalAbsent ?>],
            backgroundColor: ['#4a90e2', '#e74c3c']
        }]
    },
    options: { plugins: { title: { display: true, text: 'Attendance Distribution' } } }
});
<?php endif; ?>

// Fines per Campus Bar Chart
new Chart(document.getElementById('finesChart'), {
    type: 'bar',
    data: {
        labels: [<?php foreach($eventsPerCampus as $row) echo "'".$row['name']."',"; ?>],
        datasets: [{
            label: 'Fines Collected (₱)',
            data: [<?php foreach($eventsPerCampus as $row) echo ($row['fines_collected'] ?? 0).','; ?>],
            backgroundColor: '#f39c12'
        }]
    },
    options: {
        responsive: true,
        plugins: { title: { display: true, text: 'Fines Collected per Campus' } },
        scales: { y: { beginAtZero: true } }
    }
});

// Events per Campus Bar Chart
new Chart(document.getElementById('eventsChart'), {
    type: 'bar',
    data: {
        labels: [<?php foreach($eventsPerCampus as $row) echo "'".$row['name']."',"; ?>],
        datasets: [{
            label: 'Events Count',
            data: [<?php foreach($eventsPerCampus as $row) echo $row['events_count'].','; ?>],
            backgroundColor: '#2ecc71'
        }]
    },
    options: {
        responsive: true,
        plugins: { title: { display: true, text: 'Events per Campus' } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<?= $this->include('templates/footer') ?>
