<?php
namespace api\common\models;

use Yii;

class Lesson extends \common\models\Lesson
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
