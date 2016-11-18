<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "public_holiday".
 *
 * @property integer $id
 * @property integer $year
 * @property string $name
 * @property string $hdate
 * @property string $created_at
 * @property string $updated_at
 */
class PublicHoliday extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public_holiday';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'name', 'hdate'], 'required'],
            [['year'], 'integer'],
            [['hdate', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'name' => 'Name',
            'hdate' => 'Hdate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
