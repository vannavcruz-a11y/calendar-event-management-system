<?php namespace App\Models;

use CodeIgniter\Model;

class AttendanceRecordModel extends Model
{
    protected $table = 'attendance_records';
    protected $primaryKey = 'id';
    protected $allowedFields = ['event_id','recorded_at'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}
