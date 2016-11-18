<?php
namespace api\common\models;

use Yii;

class Lecturer extends \common\models\Lecturer
{
    public function extraFields()
    {
        $more = ['beacon'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
