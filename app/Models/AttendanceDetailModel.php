<?php namespace App\Models;

use CodeIgniter\Model;

class AttendanceDetailModel extends Model
{
    protected $table = 'attendance_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['attendance_record_id','student_id','student_name','status','time_in','time_out','fine_amount','event_id','recorded_at'];
    protected $useTimestamps = false;
}
