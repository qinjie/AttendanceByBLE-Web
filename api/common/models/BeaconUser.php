<?php
/**
 * Created by PhpStorm.
 * User: tungphung
 * Date: 4/1/17
 * Time: 10:40 AM
 */
namespace api\common\models;
class BeaconUser extends \common\models\BeaconUser
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}