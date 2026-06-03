<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentFrameworkOption extends Model
{
    //

    protected $appends = ['encrypted_id'];


    protected $fillable = ['company_id', 'user_id', 'assessment_framework_id', 'assessment_framework_question_id', 'name', 'weight'];


    public function getEncryptedIdAttribute(){
        return _encrypt($this->id);
    }

}
