<style>
    .events-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.page-title {
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
}

.table-container {
    overflow-x: auto;
}

.events-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border-radius: 10px;
    overflow: hidden;
}

.events-table th,
.events-table td {
    padding: 12px 15px;
    text-align: left;
}

.events-table th {
    background-color: #f0f0f0;
    color: #333;
}

.events-table tr:nth-child(even) {
    background-color: #fafafa;
}

.events-table tr:hover {
    background-color: #f1f1f1;
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

.back-btn {
    margin-top: 20px;
}

.no-data {
    text-align: center;
    color: #999;
    font-style: italic;
}

</style>
<?= $this->include('templates/header') ?>

<div class="events-container">
    <h2 class="page-title">Events for Campus: <?= $campus['name'] ?></h2>

    <div class="table-container">
        <table class="events-table">
            <thead>
                <tr>
                    <th>Organisation</th>
                    <th>Event Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Location</th>
                    <th>Poster</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($events)): ?>
                    <?php foreach($events as $event): ?>
                        <tr>
                            <td><?= $event['org_name'] ?></td>
                            <td><?= $event['title'] ?></td>
                            <td><?= $event['description'] ?></td>
                            <td><?= date('M d, Y', strtotime($event['date'])) ?></td>
                            <td><?= !empty($event['time_in']) ? date('h:i A', strtotime($event['time_in'])) : '-' ?></td>
                            <td><?= !empty($event['time_out']) ? date('h:i A', strtotime($event['time_out'])) : '-' ?></td>
                            <td><?= $event['location'] ?></td>
                            <td>
                                <?php if(!empty($event['poster'])): ?>
                                    <img src="<?= base_url('uploads/'.$event['poster']) ?>" alt="Poster" style="max-width:100px;">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn-secondary" href="<?= base_url('usg/event/' . $event['id']) ?>">View Event</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">No events available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= base_url('usg') ?>" class="btn-primary back-btn">Back to Dashboard</a>
</div>

<?= $this->include('templates/footer') ?>
