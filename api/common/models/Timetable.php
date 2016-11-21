<?php
namespace api\common\models;

use Yii;

class Timetable extends \common\models\Timetable
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
