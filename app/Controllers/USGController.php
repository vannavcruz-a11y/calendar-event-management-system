<?php namespace App\Controllers;

use App\Models\CampusModel;
use App\Models\EventModel;
use App\Models\AttendanceRecordModel;
use App\Models\AttendanceDetailModel;

class USGController extends BaseController
{
    public function dashboard()
    {
        $campusModel = new CampusModel();
        $campuses = $campusModel->findAll();

        // Analytics
        $db = \Config\Database::connect();

        // Total fines collected overall
        $totals = $db->query('SELECT SUM(fine_amount) as total_fines FROM attendance_details')->getRowArray();

        // Events per campus with fines collected per campus
        $eventsPerCampus = $db->query(
    'SELECT 
        campuses.id, 
        campuses.name, 
        COUNT(DISTINCT events.id) as events_count,
        COALESCE(SUM(attendance_details.fine_amount), 0) as fines_collected
    FROM campuses
    LEFT JOIN events ON events.campus_id = campuses.id
    LEFT JOIN attendance_records ON attendance_records.event_id = events.id
    LEFT JOIN attendance_details ON attendance_details.attendance_record_id = attendance_records.id
    GROUP BY campuses.id'
)->getResultArray();


        // Attendance summary
        $attendanceSummary = $db->query(
            'SELECT 
                SUM(CASE WHEN status="present" THEN 1 ELSE 0 END) as total_present,
                SUM(CASE WHEN status="absent" THEN 1 ELSE 0 END) as total_absent
            FROM attendance_details'
        )->getRowArray();

        // Attendance rate
        $attendance_rate = 0;
        $total = ($attendanceSummary['total_present'] ?? 0) + ($attendanceSummary['total_absent'] ?? 0);
        if($total > 0){
            $attendance_rate = ($attendanceSummary['total_present'] / $total) * 100;
        }

        return view('usg/dashboard', [
            'campuses' => $campuses,
            'total_fines' => $totals['total_fines'] ?? 0,
            'eventsPerCampus' => $eventsPerCampus,
            'attendance_rate' => $attendance_rate
        ]);
    }

    public function campusEvents($campusId)
    {
        $campusModel = new CampusModel();
        $campus = $campusModel->find($campusId); // fetch campus details

        $eventModel = new EventModel();
        $events = $eventModel->where('campus_id', $campusId)->findAll();

        return view('usg/campus_events', [
            'events' => $events,
            'campus' => $campus,   // <--- send full campus info
            'campus_id' => $campusId
        ]);
    }

    public function eventSummary($eventId)
    {
        $eventModel = new EventModel();
        $event = $eventModel->find($eventId);

        if(!$event){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Event not found');
        }

        $db = \Config\Database::connect();

        // Get attendance details for this event
        $builder = $db->table('attendance_details')
            ->whereIn('attendance_record_id', function($subQuery) use ($eventId){
                $subQuery->select('id')->from('attendance_records')->where('event_id', $eventId);
            });
        $attendance = $builder->get()->getResultArray();

        // Calculate analytics
        $totalFines = 0;
        $totalPresent = 0;
        $totalAbsent = 0;
        foreach($attendance as $row){
            $totalFines += $row['fine_amount'];
            if(strtolower($row['status']) === 'present') $totalPresent++;
            elseif(strtolower($row['status']) === 'absent') $totalAbsent++;
        }

        return view('usg/event_summary', [
            'attendance' => $attendance,
            'event' => $event,
            'campus_id' => $event['campus_id'],
            'totalFines' => $totalFines,
            'totalPresent' => $totalPresent,
            'totalAbsent' => $totalAbsent
        ]);
    }
}
