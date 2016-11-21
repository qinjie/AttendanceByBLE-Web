<?php
namespace api\common\models;

use Yii;

class LessonDate extends \common\models\LessonDate
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
