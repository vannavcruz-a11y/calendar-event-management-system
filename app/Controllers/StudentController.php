<?php namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\CampusModel;
use App\Models\EventModel;
use App\Models\AttendanceDetailModel;

class StudentController extends BaseController
{
    public function index($campusId)
    {
        $studentModel    = new StudentModel();
        $campusModel     = new CampusModel();
        $eventModel      = new EventModel();
        $attendanceModel = new AttendanceDetailModel();

        // Students
        $students = $studentModel
            ->where('campus_id', $campusId)
            ->orderBy('full_name', 'ASC')
            ->findAll();

        // Campus
        $campus = $campusModel->find($campusId);

        // All events for this campus
        $events = $eventModel
            ->where('campus_id', $campusId)
            ->orderBy('date', 'DESC')
            ->findAll();

        $attendancePerEvent = [];

        foreach ($events as $event) {
            $attendance = $attendanceModel
                ->select('attendance_details.*')
                ->join(
                    'attendance_records',
                    'attendance_records.id = attendance_details.attendance_record_id'
                )
                ->where('attendance_records.event_id', $event['id'])
                ->orderBy('attendance_details.student_name', 'ASC')
                ->findAll();

            $attendancePerEvent[] = [
                'event'      => $event,
                'attendance' => $attendance
            ];
        }

        return view('students/index', [
            'students'           => $students,
            'campus'             => $campus,
            'attendancePerEvent' => $attendancePerEvent
        ]);
    }

    /* =============================
     * SHOW CREATE PAGE
     * Only campus users can add students
     * ============================= */
    public function create($campusId)
    {
        if (session()->get('role') !== 'org') {
            return redirect()->back()
                ->with('error', 'You are not authorized to add students.');
        }

        if ((int) session()->get('campus_id') !== (int) $campusId) {
            return redirect()->back()
                ->with('error', 'Unauthorized campus access.');
        }

        return view('students/create', [
            'campus_id' => $campusId
        ]);
    }

    /* =============================
     * MANUAL SAVE STUDENT
     * ============================= */
    public function store()
    {
        if (session()->get('role') !== 'org') {
            return redirect()->back()
                ->with('error', 'You are not authorized to add students.');
        }

        $studentModel = new StudentModel();
        $campusId     = (int) $this->request->getPost('campus_id');

        if ((int) session()->get('campus_id') !== $campusId) {
            return redirect()->back()
                ->with('error', 'Unauthorized campus access.');
        }

        $data = [
            'student_id' => trim($this->request->getPost('student_id')),
            'full_name'  => trim($this->request->getPost('full_name')),
            'course'     => trim($this->request->getPost('course')),
            'year_level' => $this->request->getPost('year_level'),
            'campus_id'  => $campusId
        ];

        $exists = $studentModel
            ->where('student_id', $data['student_id'])
            ->where('campus_id', $campusId)
            ->first();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Student ID already exists.');
        }

        $studentModel->insert($data);

        return redirect()->to(base_url('usg/students/' . $campusId))
            ->with('success', 'Student added successfully.');
    }

    /* =============================
     * CSV UPLOAD
     * ============================= */
    public function upload()
    {
        if (session()->get('role') !== 'org') {
            return redirect()->back()
                ->with('error', 'You are not authorized to upload students.');
        }

        $studentModel = new StudentModel();
        $file         = $this->request->getFile('csv_file');
        $campusId     = (int) $this->request->getPost('campus_id');

        if ((int) session()->get('campus_id') !== $campusId) {
            return redirect()->back()
                ->with('error', 'Unauthorized campus access.');
        }

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file.');
        }

        if ($file->getExtension() !== 'csv') {
            return redirect()->back()->with('error', 'CSV files only.');
        }

        $handle = fopen($file->getTempName(), 'r');
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 4) continue;

            [$studentId, $fullName, $course, $yearLevel] = $row;

            if (strtolower($studentId) === 'student_id') continue;

            $exists = $studentModel
                ->where('student_id', trim($studentId))
                ->where('campus_id', $campusId)
                ->first();

            if ($exists) continue;

            $studentModel->insert([
                'student_id' => trim($studentId),
                'full_name'  => trim($fullName),
                'course'     => trim($course),
                'year_level' => trim($yearLevel),
                'campus_id'  => $campusId
            ]);

            $count++;
        }

        fclose($handle);

        return redirect()->to(base_url('usg/students/' . $campusId))
            ->with('success', "$count students uploaded successfully.");
    }
public function deleteAll($campusId)
{
    $studentModel = new StudentModel();
    $session = session();

    // Only allow deletion if user belongs to the campus
    if ((int) $session->get('campus_id') !== (int) $campusId) {
        $session->setFlashdata('error', 'Unauthorized campus access.');
        return redirect()->back();
    }

    // Delete all students for this campus
    $studentModel->where('campus_id', $campusId)->delete();

    $session->setFlashdata('success', 'All students have been deleted successfully.');
    return redirect()->back();
}


}
