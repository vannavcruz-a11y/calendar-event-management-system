<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'SKSU Calendar Events Management System' ?></title>

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Reset */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background-color:#f8f9fa; color:#333; transition:.3s; display:flex; flex-direction:column; min-height:100vh; }

        /* Header */
        header { 
            background-color:#003366; 
            color:#fff; 
            padding:15px 20px; 
            position:fixed; top:0; 
            left:250px; right:0; z-index:1000;
            transition:.3s;
        }
        .header-container { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; }
        header h1 { font-size:1.6rem; }
        .user-info { font-size:0.95rem; }
        .user-info a { color:#ffd700; text-decoration:none; }
        .user-info a:hover { text-decoration:underline; }

        /* Layout */
        .layout { display:flex; width:100%; padding-top:80px; flex:1; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #003366;
            color: white;
            padding: 20px;
            height: 100vh;
            position:fixed;
            top:0;
            left:0;
            overflow-y:auto;
            transition: width .3s, padding .3s;
        }
        .sidebar h3 { margin-bottom: 10px; font-size: 1.1rem; }
        .sidebar a, .sidebar button {
            display: block;
            background: #0066cc;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: 0.3s;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        .sidebar a:hover,
        .sidebar button:hover { background: #004d99; }
        .back-btn { background: #ffd700 !important; color: #003366 !important; font-weight:bold; }
        .logout { background: #cc0000 !important; }
        .user-panel { margin-top: 20px; font-size: 0.9rem; }

        /* Content */
        .content {
            background: #fff;
            padding: 20px;
            flex: 1;
            margin-left: 250px;
            border-radius: 8px;
            transition:.3s;
        }

        /* Collapse Button */
        .collapse-btn {
            position: fixed;
            left: 10px;
            top: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            background: #0066cc;
            color: white;
            cursor: pointer;
            z-index: 1100;
            transition: .3s;
        }
        .collapse-btn:hover { background: #004d99; }

        /* Collapsed Sidebar */
        .sidebar.collapsed { width:0; padding:0; overflow:hidden; }
        .content.collapsed { margin-left:0; }
        header.collapsed { left:0; }
        footer.collapsed { margin-left:0; border-radius:0; }

        /* Footer */
        footer {
            width:100%;
            background:#003366;
            color:#fff;
            text-align:center;
            padding:15px 0;
            transition:.3s;
        }

        /* Dark Mode */
        body.dark-mode { background:#1e1e1e; color:#ddd; }
        body.dark-mode .content { background:#2d2d2d; color:#fff; }
        body.dark-mode .sidebar { background:#001a33; }
        body.dark-mode footer { background:#001a33; color:#ddd; }
        .darkmode-btn { background:#222 !important; }

        /* Scrollbar for sidebar */
        .sidebar::-webkit-scrollbar { width:6px; }
        .sidebar::-webkit-scrollbar-thumb { background:#004d99; border-radius:3px; }
        .sidebar::-webkit-scrollbar-track { background:transparent; }
    </style>
</head>
<body>

<!-- Collapse Button -->
<button id="collapseBtn" class="collapse-btn">
    ☰
</button>
<!-- Sidebar -->
<!-- Sidebar -->
<!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <!-- Back -->
    <a href="javascript:history.back()" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
<?php if(session()->get('role') === 'org'): ?>
    <?php $userCampusId = session()->get('campus_id'); ?>
    <a href="<?= base_url('campus/'.$userCampusId) ?>" class="btn-secondary">
        Back to My Campus
    </a>
<?php endif; ?>

    <!-- USG Section -->
    <?php if(in_array(session()->get('role'), ['admin','usg'])): ?>
        <h3><i class="fa-solid fa-users"></i> USG</h3>
        <a href="<?= base_url('usg/dashboard') ?>">
            <i class="fa-solid fa-tachometer-alt"></i> USG Dashboard
        </a>
    <?php endif; ?>

    <!-- View Event -->
    <?php if(isset($event_id) && !empty($event_id)): ?>
        <a href="<?= base_url('usg/event/'.$event_id) ?>" style="background:#3498db;">
            <i class="fa-solid fa-eye"></i> View Event
        </a>
    <?php endif; ?>

    <!-- Campuses -->
    <h3><i class="fa-solid fa-building-columns"></i> Campuses</h3>

    <?php if(isset($campuses) && count($campuses) > 0): ?>
        <?php foreach($campuses as $campus): 
            $campusId   = $campus['id'] ?? 0;
            $campusName = $campus['campus_name'] ?? $campus['name'] ?? 'Unnamed Campus';
        ?>
            <button class="campus-toggle">
                <i class="fa-solid fa-landmark"></i> <?= $campusName ?>
            </button>

            <div class="campus-links" style="display:none; margin-left:10px;">
                <a href="<?= base_url('campus/'.$campusId) ?>" style="background:#004d99;">
                    <i class="fa-solid fa-calendar-days"></i> View Events
                </a>

               <?php if(
                    session()->get('role') === 'org' &&
                    (int) session()->get('campus_id') === (int) $campusId
                ): ?>
                    <a href="<?= base_url('usg/students/add/'.$campusId) ?>" style="background:#f39c12;">
                        <i class="fa-solid fa-user-plus"></i> Add Student
                    </a>
                <?php endif; ?>

                <?php if(in_array(session()->get('role'), ['admin','usg','org'])): ?>
                    <a href="<?= base_url('usg/students/'.$campusId) ?>" style="background:#2ecc71;">
                        <i class="fa-solid fa-user-graduate"></i> View Students
                    </a>
                <?php endif; ?>

                <!-- Attendance Management -->
                <?php if(session()->get('role') === 'org'): ?>
                    <?php if((int)session()->get('campus_id') === (int)$campusId): ?>
                        <a href="<?= base_url('campus/'.$campusId.'/attendance/view') ?>" style="background:#8e44ad; margin-bottom:5px;">
                            <i class="fa-solid fa-eye"></i> View Attendance
                        </a>
                        <a href="<?= base_url('campus/'.$campusId.'/attendance/export') ?>" style="background:#7d3c98;">
                            <i class="fa-solid fa-file-csv"></i> Export CSV
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('campus/'.$campusId.'/attendance/view') ?>" style="background:#8e44ad; margin-bottom:5px;">
                            <i class="fa-solid fa-eye"></i> View Attendance
                        </a>
                    <?php endif; ?>
                <?php elseif(in_array(session()->get('role'), ['admin','usg'])): ?>
                    <a href="<?= base_url('campus/'.$campusId.'/attendance/view') ?>" style="background:#8e44ad; margin-bottom:5px;">
                        <i class="fa-solid fa-eye"></i> View Attendance
                    </a>
                    <a href="<?= base_url('campus/'.$campusId.'/attendance/export') ?>" style="background:#7d3c98;">
                        <i class="fa-solid fa-file-csv"></i> Export CSV
                    </a>
                <?php endif; ?>

                <!-- Accounts -->
                <?php if(in_array(session()->get('role'), ['admin','usg'])): ?>
                    <a href="<?= base_url('campus/'.$campusId.'/add-account') ?>" style="background:#28a745;">
                        <i class="fa-solid fa-user-plus"></i> Add Account
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No campuses available</p>
    <?php endif; ?>

    <!-- Calendar Button for Admin, USG, and Org -->
    <?php if(in_array(session()->get('role'), ['admin','usg','org'])): ?>
        <hr style="margin:15px 0; border-color:rgba(255,255,255,0.3);">
        <h3><i class="fa-solid fa-calendar-days"></i> Calendar</h3>
        
        <?php if(session()->get('role') === 'org'): ?>
            <a href="<?= base_url('campus/'.session()->get('campus_id').'/calendar') ?>" style="background:#e67e22;">
                <i class="fa-solid fa-calendar-alt"></i> My Campus Calendar
            </a>
        <?php else: ?>
            <a href="<?= base_url('calendar') ?>" style="background:#e67e22;">
                <i class="fa-solid fa-calendar-alt"></i> View Calendar
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <hr style="margin:15px 0; border-color:rgba(255,255,255,0.3);">

    <!-- Dark Mode -->
    <button class="darkmode-btn" id="darkToggle">
        <i class="fa-solid fa-moon"></i> Dark Mode
    </button>

    <!-- User Panel -->
    <?php if(session()->get('logged_in')): ?>
        <div class="user-panel">
            <small>Logged in as:</small><br>
            <b><?= session()->get('name') ?></b><br><br>
            <a href="<?= base_url('/logout') ?>" class="logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.campus-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const next = btn.nextElementSibling;
        next.style.display = (next.style.display === 'block') ? 'none' : 'block';
    });
});
</script>

