<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_leave".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $student_card
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 */
class StudentLeave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_leave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'student_card', 'start_date', 'end_date', 'remark'], 'required'],
            [['student_id', 'status'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['student_card'], 'string', 'max' => 10],
            [['remark'], 'string', 'max' => 100],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'student_card' => 'Student Card',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'remark' => 'Remark',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
