<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOld extends Model
{
    
    use HasFactory;
 
    protected $table = 'student_olds';
 
    protected $fillable = [
       'unified_number', 'contact_id', 'first_name_ar', 'first_name_en',
    'family_name_ar', 'last_name_en', 'previous_grade', 'current_grade',
    'previous_result', 'date_of_birth', 'place_of_birth', 'gender',
    'id_card_type', 'id_card_number', 'contact_location', 'nationality',
    'father_name_ar', 'father_name_en', 'guardian_phone', 'father_work_sector',
    'father_job_type', 'mother_first_name_ar', 'mother_name_en',
    'mother_family_name_ar', 'mother_family_name_ar_alt', 'mother_family_name_en',
    'mother_work_sector', 'mother_job_type', 'mother_nationality', 'is_enable'
    ];
 
    protected $casts = [
        'date_of_birth' => 'date',
        'is_enable' => 'boolean',
    ];
}
