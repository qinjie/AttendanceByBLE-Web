<?php
namespace api\common\models;

use Yii;

class Venue extends \common\models\Venue
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
