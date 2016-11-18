<?php
namespace api\common\models;

use Yii;

class Student extends \common\models\Student
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
