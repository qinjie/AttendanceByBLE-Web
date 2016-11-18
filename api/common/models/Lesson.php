<?php
namespace api\common\models;

use Yii;

class Lesson extends \common\models\Lesson
{
    public function extraFields()
    {
        $more = ['lecturers', 'beaconLecturers'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
