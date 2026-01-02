<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Events List</h1>
    <a href="/events/create" class="btn btn-success mb-3">Create New Event</a>
    <a href="/" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($events) && count($events) > 0): ?>
            <?php foreach($events as $event): ?>
            <tr>
                <td><?= esc($event['event_name']) ?></td>
                <td><?= esc($event['event_date']) ?></td>
                <td><?= esc($event['event_time']) ?></td>
                <td><?= esc($event['location']) ?></td>
                <td>
                    <a href="/events/edit/<?= $event['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="/events/delete/<?= $event['id'] ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No events found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
