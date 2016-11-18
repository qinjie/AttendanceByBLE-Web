<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacon_attendance_student".
 *
 * @property integer $id
 * @property integer $lesson_date_id
 * @property integer $student_id_1
 * @property integer $student_id_2
 * @property integer $status
 * @property string $created_at
 *
 * @property LessonDate $lessonDate
 * @property Student $studentId1
 * @property Student $studentId2
 */
class BeaconAttendanceStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacon_attendance_student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_date_id', 'student_id_1', 'student_id_2'], 'required'],
            [['lesson_date_id', 'student_id_1', 'student_id_2', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['lesson_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => LessonDate::className(), 'targetAttribute' => ['lesson_date_id' => 'id']],
            [['student_id_1'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id_1' => 'id']],
            [['student_id_2'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id_2' => 'id']],
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
            'student_id_1' => 'Student Id 1',
            'student_id_2' => 'Student Id 2',
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
    public function getStudentId1()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentId2()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id_2']);
    }
}
