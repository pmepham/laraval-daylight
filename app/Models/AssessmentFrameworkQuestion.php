<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentFrameworkQuestion extends Model
{
    //
    protected $appends = ['encrypted_id'];
    //protected $hidden = ['id'];

    protected $fillable = ['company_id', 'user_id', 'assessment_framework_id', 'question_type', 'name'];


    public function getEncryptedIdAttribute(){
        return _encrypt($this->id);
    }
}
