<?php
namespace api\common\models;

use Yii;

class Attendance extends \common\models\Attendance
{
    public function extraFields()
    {
        $more = ['lecturer', 'lesson', 'lessonDate'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

    public function fields()
    {
        $fields=parent::fields();
        unset($fields['lecturer_id']);
        unset($fields['student_id']);
        unset($fields['lesson_date_id']);
        unset($fields['created_at']);
        unset($fields['updated_at']);
        return $fields;
    }
}
