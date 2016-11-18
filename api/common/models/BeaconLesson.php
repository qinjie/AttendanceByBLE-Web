<?php
namespace api\common\models;

use Yii;

class BeaconLesson extends \common\models\BeaconLesson
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
