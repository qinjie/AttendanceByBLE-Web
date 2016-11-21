<?php
namespace api\common\models;

use Yii;

class Timetable extends \common\models\Timetable
{
    public function extraFields()
    {
        $more = ['student', 'lesson', 'lessonDay', 'lessonThisWeek', 'lessonToday', 'lecturers', 'venue'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
