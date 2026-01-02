<h2>Welcome, <?= session()->get('name') ?></h2>
<p>Your Campus ID: <?= session()->get('campus_id') ?></p>
<p>Role: <?= session()->get('role') ?></p>
<h2>Welcome, <?= session()->get('name') ?>!</h2>

<p>
    <a href="<?= base_url('student/calendar') ?>">View Calendar</a>
</p>
