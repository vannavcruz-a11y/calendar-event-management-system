<h2>Student Calendar</h2>
<p><a href="<?= base_url('student/dashboard') ?>">Back to Dashboard</a></p>

<div id="calendar">
    <?php if(!empty($events)): ?>
        <ul>
            <?php foreach($events as $event): ?>
                <li>
                    <strong><?= $event['title'] ?></strong> - <?= $event['date'] ?> <?= $event['time'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</div>
