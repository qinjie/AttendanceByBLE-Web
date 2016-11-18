<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacon_attendance_lecturer".
 *
 * @property integer $id
 * @property integer $lesson_date_id
 * @property integer $student_id
 * @property integer $lecturer_id
 * @property integer $status
 * @property string $created_at
 *
 * @property LessonDate $lessonDate
 * @property Student $student
 * @property Lecturer $lecturer
 */
class BeaconAttendanceLecturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacon_attendance_lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_date_id', 'student_id', 'lecturer_id'], 'required'],
            [['lesson_date_id', 'student_id', 'lecturer_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['lesson_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => LessonDate::className(), 'targetAttribute' => ['lesson_date_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['lecturer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lesson_date_id' => 'Lesson Date ID',
            'student_id' => 'Student ID',
            'lecturer_id' => 'Lecturer ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonDate()
    {
        return $this->hasOne(LessonDate::className(), ['id' => 'lesson_date_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturer()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id']);
    }
}
