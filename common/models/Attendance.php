<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $lesson_date_id
 * @property string $recorded_time
 * @property integer $status
 * @property integer $lecturer_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 * @property Lecturer $lecturer
 * @property LessonDate $lessonDate
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance';
    }

    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'lesson_date_id'], 'required'],
            [['student_id', 'lesson_date_id', 'status', 'lecturer_id'], 'integer'],
            [['recorded_time', 'created_at', 'updated_at'], 'safe'],
            [['student_id', 'lesson_date_id'], 'unique', 'targetAttribute' => ['student_id', 'lesson_date_id'], 'message' => 'The combination of Student ID and Lesson Date ID has already been taken.'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['lecturer_id' => 'id']],
            [['lesson_date_id'], 'exist', 'skipOnError' => true, 'targetClass' => LessonDate::className(), 'targetAttribute' => ['lesson_date_id' => 'id']],
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
            'lesson_date_id' => 'Lesson Date ID',
            'recorded_time' => 'Recorded Time',
            'status' => 'Status',
            'lecturer_id' => 'Lecturer ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturer()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonDate()
    {
        return $this->hasOne(LessonDate::className(), ['id' => 'lesson_date_id']);
    }

    public function getLesson()
    {
        return $this->hasMany(Lesson::className(), ['id' => 'lesson_id'])->viaTable('lesson_date', ['id' => 'lesson_date_id']);
    }
}
