<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $fillable = ['company_id', 'user_id', 'assessment_framework_id', 'client_id', 'is_public', 'assessment_snapshot', 'completed_at', 'closed_at'];

    


}
