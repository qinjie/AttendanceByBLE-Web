<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "semester_date".
 *
 * @property integer $id
 * @property integer $semester_id
 * @property string $tdate
 * @property integer $week_num
 * @property integer $weekday
 * @property integer $is_holiday
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SemesterInfo $semester
 */
class SemesterDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_id', 'tdate', 'week_num', 'weekday'], 'required'],
            [['semester_id', 'week_num', 'weekday', 'is_holiday'], 'integer'],
            [['tdate', 'created_at', 'updated_at'], 'safe'],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => SemesterInfo::className(), 'targetAttribute' => ['semester_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester ID',
            'tdate' => 'Tdate',
            'week_num' => 'Week Num',
            'weekday' => 'Weekday',
            'is_holiday' => 'Is Holiday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(SemesterInfo::className(), ['id' => 'semester_id']);
    }
}
