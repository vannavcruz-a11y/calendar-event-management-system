<?= $this->include('templates/header') ?>

<?php
// Month/year from query params or current date
$month = $_GET['month'] ?? date('n');
$year  = $_GET['year'] ?? date('Y');

$month = (int)$month;
$year  = (int)$year;

$firstDayOfMonth = strtotime("$year-$month-01");
$daysInMonth = date('t', $firstDayOfMonth);
$startDay = date('w', $firstDayOfMonth);

$prevMonth = $month - 1; $prevYear = $year;
if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

$nextMonth = $month + 1; $nextYear = $year;
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

$today = date('Y-m-d');

// Function to get events for a specific date
function eventsForDate($date, $all_events) {
    $events = [];
    foreach($all_events ?? [] as $ev) {
        if(isset($ev['date'])) {
            if($ev['date'] === $date) {
                $events[] = $ev;
            }
        }
    }
    return $events;
}
?>

<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; }
.calendar { width: 100%; max-width: 900px; margin: 30px auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);}
.calendar-header { display:flex; justify-content: space-between; align-items:center; margin-bottom: 15px; }
.calendar-header a { text-decoration:none; color:#007BFF; font-weight:bold; }
.calendar-grid { display:grid; grid-template-columns: repeat(7, 1fr); gap:1px; background:#ccc; }
.day { min-height:100px; background:#fff; padding:5px; position:relative; }
.day .date-number { font-weight:bold; margin-bottom:5px; }
.day.today { background:#e0f7fa; }
.event-badge { display:block; background:#28a745; color:#fff; padding:2px 4px; border-radius:4px; margin-bottom:2px; cursor:pointer; font-size:0.8em; }
.modal-bg { display:none; position:fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;}
.modal-content { background:#fff; padding:20px; border-radius:8px; max-width:400px; width:90%; position:relative; }
.modal-close { position:absolute; top:10px; right:15px; cursor:pointer; font-size:18px; }
.modal-row { margin:5px 0; }
</style>

<div class="calendar">
    <div class="calendar-header">
        <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">&lt; Previous</a>
        <h2><?= date('F Y', $firstDayOfMonth) ?></h2>
        <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">Next &gt;</a>
    </div>
    <div class="calendar-grid">
        <?php
        $weekdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        foreach($weekdays as $day) {
            echo "<div class='day' style='background:#007BFF;color:#fff;text-align:center;font-weight:bold;'>{$day}</div>";
        }

        // Empty cells before first day
        for($i=0; $i<$startDay; $i++) { echo "<div class='day'></div>"; }

        // Days of the month
        for($day=1; $day<=$daysInMonth; $day++){
            $dateStr = "$year-".str_pad($month,2,'0',STR_PAD_LEFT)."-".str_pad($day,2,'0',STR_PAD_LEFT);
            $dayEvents = eventsForDate($dateStr, $events ?? []);

            $todayClass = $dateStr === $today ? 'today' : '';
            echo "<div class='day $todayClass'>";
            echo "<div class='date-number'>{$day}</div>";

            foreach($dayEvents as $ev) {
                $title = htmlspecialchars($ev['title'] ?? 'Untitled Event');
                $desc = htmlspecialchars($ev['description'] ?? '');
                $start = $ev['date'] ?? '';
                $end = $ev['date'] ?? '';
                $location = htmlspecialchars($ev['location'] ?? '');
                $creator = htmlspecialchars($ev['created_by'] ?? '');

                echo "<span class='event-badge' onclick='showModal(\"$title\",\"$start\",\"$end\",\"$desc\",\"$location\",\"$creator\")'>{$title}</span>";
            }

            echo "</div>";
        }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal-bg" id="eventModal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle"></h3>
        <div class="modal-row"><strong>Start:</strong> <span id="modalStart"></span></div>
        <div class="modal-row"><strong>End:</strong> <span id="modalEnd"></span></div>
        <div class="modal-row"><strong>Description:</strong> <span id="modalDesc"></span></div>
        <div class="modal-row"><strong>Location:</strong> <span id="modalLocation"></span></div>
        <div class="modal-row"><strong>Created by:</strong> <span id="modalCreator"></span></div>
    </div>
</div>

<script>
function showModal(title,start,end,desc,location,creator){
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalStart').innerText = start || 'N/A';
    document.getElementById('modalEnd').innerText   = end || 'N/A';
    document.getElementById('modalDesc').innerText  = desc || 'N/A';
    document.getElementById('modalLocation').innerText = location || 'N/A';
    document.getElementById('modalCreator').innerText = creator || 'N/A';
    document.getElementById('eventModal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('eventModal').style.display = 'none';
}

document.getElementById('eventModal').addEventListener('click', function(e){
    if(e.target === this) closeModal();
});
document.addEventListener('keydown', function(e){
    if(e.key === "Escape") closeModal();
});
</script>


<?= $this->include('templates/footer') ?>
