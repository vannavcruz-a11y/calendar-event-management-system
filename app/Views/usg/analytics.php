<?= $this->include('templates/header') ?>
<h2>USG Analytics</h2>

<h3>Attendance Summary</h3>
<ul>
    <li>Total Fines Collected: <?= number_format($total_fines,2) ?></li>
    <li>Overall Attendance Rate: <?= number_format($attendance_rate,2) ?>%</li>
</ul>

<h3>Events per Campus</h3>
<table>
    <tr>
        <th>Campus</th>
        <th>Total Events</th>
        <th>Total Attendance</th>
    </tr>
    <?php foreach($eventsPerCampus as $row): ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['events_count'] ?></td>
            <td><?= $row['attendance_count'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="<?= base_url('usg/dashboard') ?>" class="btn">Back to Dashboard</a>
<?= $this->include('templates/footer') ?>
