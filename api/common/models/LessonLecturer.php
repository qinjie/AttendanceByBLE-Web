<?php
namespace api\common\models;

use Yii;

class LessonLecturer extends \common\models\LessonLecturer
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
