<?php
namespace api\common\models;

use Yii;

class BeaconAttendanceStudent extends \common\models\BeaconAttendanceStudent
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
