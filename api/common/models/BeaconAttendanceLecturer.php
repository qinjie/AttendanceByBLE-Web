<?php
namespace api\common\models;

use Yii;

class BeaconAttendanceLecturer extends \common\models\BeaconAttendanceLecturer
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
