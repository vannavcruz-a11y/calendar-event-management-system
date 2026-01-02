<?php namespace App\Controllers;

use App\Models\AttendanceRecordModel;
use App\Models\AttendanceDetailModel;
use App\Models\EventModel;

class AttendanceController extends BaseController
{
    // ===== Event-level attendance =====

    public function upload($eventId)
    {
        $session = session();
        $role = $session->get('role');
        $userCampus = $session->get('campus_id');

        $event = (new EventModel())->find($eventId);
        if (!$event) return redirect()->back()->with('error', 'Event not found.');

        if ($role === 'org' && (int)$event['campus_id'] !== (int)$userCampus) {
            return redirect()->back()->with('error', 'You can only upload attendance for your own campus.');
        }

        return view('attendance/upload', ['event_id' => $eventId]);
    }

    public function store($eventId)
    {
        $session = session();
        $role = $session->get('role');
        $userCampus = $session->get('campus_id');

        $event = (new EventModel())->find($eventId);
        if (!$event) return redirect()->back()->with('error', 'Event not found.');

        if ($role === 'org' && (int)$event['campus_id'] !== (int)$userCampus) {
            return redirect()->back()->with('error', 'You can only upload attendance for your own campus.');
        }

        $file = $this->request->getFile('csv_file');
        if (!$file->isValid()) return redirect()->back()->with('error', 'Invalid file');

        $csv = array_map('str_getcsv', file($file->getTempName()));
        $header = array_shift($csv);

        $recordModel = new AttendanceRecordModel();
        $recordId = $recordModel->insert([
            'event_id' => $eventId,
            'recorded_at' => date('Y-m-d H:i:s')
        ], true);

        $detailModel = new AttendanceDetailModel();
        foreach ($csv as $row) {
            if (count($row) < 6) continue;
            $detailModel->insert([
                'attendance_record_id' => $recordId,
                'student_id' => $row[0],
                'student_name' => $row[1],
                'status' => $row[2],
                'time_in' => $row[3],
                'time_out' => $row[4],
                'fine_amount' => $row[5]
            ]);
        }

        return redirect()->back()->with('success', 'Attendance uploaded successfully!');
    }

    public function view($eventId)
    {
        $db = \Config\Database::connect();

        $event = (new EventModel())->find($eventId);
        if (!$event) return redirect()->back()->with('error', 'Event not found.');

        $builder = $db->table('attendance_records')
            ->select('attendance_records.id as record_id, attendance_details.id as detail_id, attendance_details.student_id, attendance_details.student_name, attendance_details.status, attendance_details.time_in, attendance_details.time_out, attendance_details.fine_amount, attendance_records.recorded_at')
            ->join('attendance_details', 'attendance_details.attendance_record_id = attendance_records.id')
            ->where('attendance_records.event_id', $eventId);

        $attendance = $builder->get()->getResultArray();

        return view('attendance/view', [
            'attendance' => $attendance,
            'event_id' => $eventId,
            'event' => $event
        ]);
    }

    public function export($eventId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('attendance_records')
            ->select('attendance_records.id as record_id, attendance_details.student_id, attendance_details.student_name, attendance_details.status, attendance_details.time_in, attendance_details.time_out, attendance_details.fine_amount, attendance_records.recorded_at')
            ->join('attendance_details', 'attendance_details.attendance_record_id = attendance_records.id')
            ->where('attendance_records.event_id', $eventId);

        $rows = $builder->get()->getResultArray();

        $filename = 'attendance_event_' . $eventId . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['record_id','student_id','student_name','status','time_in','time_out','fine_amount','recorded_at']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['record_id'],
                $r['student_id'],
                $r['student_name'],
                $r['status'],
                $r['time_in'],
                $r['time_out'],
                $r['fine_amount'],
                $r['recorded_at']
            ]);
        }
        fclose($out);
        exit;
    }

    // ===== Campus-level attendance =====

    public function campusView($campusId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('attendance_records')
            ->select('attendance_records.id as record_id, attendance_details.student_id, attendance_details.student_name, attendance_details.status, attendance_details.time_in, attendance_details.time_out, attendance_details.fine_amount, attendance_records.recorded_at, events.title as event_title')
            ->join('attendance_details', 'attendance_details.attendance_record_id = attendance_records.id')
            ->join('events', 'events.id = attendance_records.event_id')
            ->where('events.campus_id', $campusId);

        $attendance = $builder->get()->getResultArray();

        return view('attendance/view', [
            'attendance' => $attendance,
            'campus_id' => $campusId
        ]);
    }

    public function campusExport($campusId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('attendance_records')
            ->select('attendance_records.id as record_id, attendance_details.student_id, attendance_details.student_name, attendance_details.status, attendance_details.time_in, attendance_details.time_out, attendance_details.fine_amount, attendance_records.recorded_at, events.title as event_title')
            ->join('attendance_details', 'attendance_details.attendance_record_id = attendance_records.id')
            ->join('events', 'events.id = attendance_records.event_id')
            ->where('events.campus_id', $campusId);

        $rows = $builder->get()->getResultArray();

        $filename = 'attendance_campus_' . $campusId . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['record_id','student_id','student_name','status','time_in','time_out','fine_amount','recorded_at','event_title']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['record_id'],
                $r['student_id'],
                $r['student_name'],
                $r['status'],
                $r['time_in'],
                $r['time_out'],
                $r['fine_amount'],
                $r['recorded_at'],
                $r['event_title']
            ]);
        }
        fclose($out);
        exit;
    }

    // ===== DELETE ATTENDANCE =====

    // Delete single attendance detail
    public function delete($id)
    {
        $attendanceModel = new AttendanceDetailModel();
        $session = session();

        $record = $attendanceModel->find($id);

        if ($record) {
            $attendanceModel->delete($id);
            $session->setFlashdata('success', 'Attendance record deleted successfully.');
        } else {
            $session->setFlashdata('error', 'Attendance record not found.');
        }

        return redirect()->back();
    }

    public function deleteAll($eventId)
{
    $session = session();
    $campusId = $session->get('campus_id');

    $event = (new EventModel())->find($eventId);
    if (!$event || $event['campus_id'] != $campusId) {
        $session->setFlashdata('error', 'Unauthorized or event not found.');
        return redirect()->back();
    }

    $detailModel = new AttendanceDetailModel();
    $detailModel->whereIn('attendance_record_id', function($builder) use ($eventId) {
        $builder->select('id')
                ->from('attendance_records')
                ->where('event_id', $eventId);
    })->delete();

    $session->setFlashdata('success', 'All attendance records for this event have been deleted.');
    return redirect()->back();
}
public function manualStore($eventId)
{
    $session = session();
    $role = $session->get('role');
    $userCampus = $session->get('campus_id');

    $event = (new EventModel())->find($eventId);
    if (!$event) return redirect()->back()->with('error', 'Event not found.');

    if ($role === 'org' && (int)$event['campus_id'] !== (int)$userCampus) {
        return redirect()->back()->with('error', 'You can only add manual attendance for your own campus.');
    }

    $student_id   = $this->request->getPost('student_id');
    $student_name = $this->request->getPost('student_name');
    $status       = $this->request->getPost('status');
    $time_in      = $this->request->getPost('time_in');
    $time_out     = $this->request->getPost('time_out');
    $fine_amount  = $this->request->getPost('fine_amount') ?: 0;

    // Insert record
    $recordModel = new AttendanceRecordModel();
    $recordId = $recordModel->insert([
        'event_id' => $eventId,
        'recorded_at' => date('Y-m-d H:i:s')
    ], true);

    // Insert detail
    $detailModel = new AttendanceDetailModel();
    $detailModel->insert([
        'attendance_record_id' => $recordId,
        'student_id'           => $student_id,
        'student_name'         => $student_name,
        'status'               => $status,
        'time_in'              => $time_in,
        'time_out'             => $time_out,
        'fine_amount'          => $fine_amount
    ]);

    $session->setFlashdata('success', 'Manual attendance added successfully.');
    return redirect()->to(base_url('event/'.$eventId.'/attendance/view'));
}

}