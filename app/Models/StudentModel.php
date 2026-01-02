<?php namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'students';
    protected $primaryKey = 'student_id';
    protected $allowedFields = ['student_id', 'full_name', 'course', 'year_level', 'campus_id'];
}