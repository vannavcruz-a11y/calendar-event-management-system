<style>
/* Dashboard container */
.dashboard-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Dashboard Welcome / Header spacing removed */
.dashboard-title {
    font-size: 28px;
    margin: 0 0 10px 0;
    color: #333;
}

/* Section Headings */
.campus-section h3,
.events-section h3 {
    font-size: 22px;
    margin: 0 0 10px 0;
    color: #444;
}

/* Campus Buttons */
.campus-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}
.campus-btn {
    padding: 8px 18px;
    background-color: #0066cc;
    color: #fff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.campus-btn:hover {
    background-color: #004d99;
    transform: translateY(-2px);
}

/* Create Event Button */
.btn-primary {
    background-color: #27ae60;
    color: #fff;
    padding: 8px 18px;
    border-radius: 12px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 20px;
    transition: 0.3s;
}
.btn-primary:hover {
    background-color: #1e8449;
}

/* Table */
.table-container {
    overflow-x: auto;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.dashboard-table {
    width: 100%;
    border-collapse: collapse;
}
.dashboard-table th,
.dashboard-table td {
    padding: 8px 10px;
    text-align: left;
}
.dashboard-table th {
    background-color: #f0f0f0;
    color: #333;
}
.dashboard-table tr:nth-child(even) {
    background-color: #fafafa;
}
.dashboard-table tr:hover {
    background-color: #f1f1f1;
}
.dashboard-table img {
    max-width: 70px;
    border-radius: 6px;
}

/* Actions Button */
.btn-secondary {
    background-color: #f39c12;
    color: #fff;
    padding: 5px 10px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}
.btn-secondary:hover {
    background-color: #d68910;
}

/* No Data */
.no-data {
    text-align: center;
    color: #999;
    font-style: italic;
}

/* Main Content */
.content {
    margin-left: 250px;
    padding: 15px 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .content {
        margin-left: 0;
        padding: 10px;
    }
    .dashboard-title {
        font-size: 24px;
    }
    .dashboard-table th, .dashboard-table td {
        padding: 6px 8px;
        font-size: 0.85rem;
    }
    .dashboard-table img {
        max-width: 50px;
    }
    .campus-btn, .btn-primary {
        padding: 6px 12px;
    }
}
</style>

<?= $this->include('templates/header') ?>

<div class="layout">
    <div class="content">
        <div class="dashboard-container">
            <h2 class="dashboard-title"><?= isset($campus['name']) ? $campus['name'] : 'Campus' ?> Dashboard</h2>

          
            <!-- Create Event (only for campus users) -->
            <?php if(session()->get('role') !== 'usg, org'): ?>
            <div style="text-align:right; margin-bottom:15px;">
                <a href="<?= base_url('campus/'.($campus['id'] ?? 0).'/events/create') ?>" class="btn-primary">+ Create Event</a>
            </div>
            <?php endif; ?>

            <!-- Events Table -->
            <section class="events-section">
                <h3>Upcoming Events</h3>
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Organisation</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Location</th>
                                <th></th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($events)): ?>
                                <?php foreach($events as $event): ?>
                                    <tr>
                                        <td><?= $event['org_name'] ?? '-' ?></td>
                                        <td><?= $event['title'] ?? '-' ?></td>
                                        <td><?= $event['description'] ?? '-' ?></td>
                                        <td><?= !empty($event['date']) ? date('M d, Y', strtotime($event['date'])) : '-' ?></td>
                                        <td><?= !empty($event['time_in']) ? date('h:i A', strtotime($event['time_in'])) : '-' ?></td>
                                        <td><?= !empty($event['time_out']) ? date('h:i A', strtotime($event['time_out'])) : '-' ?></td>
                                        <td><?= $event['location'] ?? '-' ?></td>
                                        <td>
                                            <?php if(!empty($event['poster'])): ?>
                                                
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $event['created_by'] ?? '-' ?></td>
                                       <td style="white-space: nowrap;">

    <!-- Upload Attendance -->
    <a class="btn-secondary"
       href="<?= base_url('event/'.($event['id'] ?? 0).'/attendance/upload') ?>">
        Attendance
    </a>

    <?php if(
        session()->get('role') === 'admin' ||
        session()->get('role') === 'usg' ||
        session()->get('role') === 'org'
    ): ?>

        <!-- Edit -->
        <a class="btn-secondary"
           style="background:#3498db;"
           href="<?= base_url('event/edit/'.$event['id']) ?>">
            Edit
        </a>

        <!-- Delete -->
        <form action="<?= base_url('event/delete/'.$event['id']) ?>"
              method="post"
              style="display:inline;"
              onsubmit="return confirm('Are you sure you want to delete this event?');">
            <?= csrf_field() ?>
            <button type="submit"
                    class="btn-secondary"
                    style="background:#e74c3c; border:none;">
                Delete
            </button>
        </form>

    <?php endif; ?>

</td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="10" class="no-data">No events found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>
