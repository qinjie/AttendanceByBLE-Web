<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "timetable".
 *
 * @property integer $id
 * @property integer $lesson_id
 * @property integer $student_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 * @property Lesson $lesson
 */
class Timetable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timetable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id'], 'required'],
            [['lesson_id', 'student_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lesson_id' => 'Lesson ID',
            'student_id' => 'Student ID',
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
    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }

    public function getLessonDay(){
        return $this->hasMany(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);//->where(['<', 'ldate', '2016-09-26']);
    }

    public function getLessonThisWeek(){
        return $this->hasOne(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id'])->where(['>=', 'ldate', date('Y-m-d', strtotime('monday this week'))])->andWhere(['<=', 'ldate', date('Y-m-d', strtotime('sunday this week'))]);
    }

    public function getLessonToday(){
        return $this->hasOne(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id'])->where(['ldate' => date("Y-m-d")]);
    }

    public function getLecturers(){
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id'])
        ->viaTable('lesson_lecturer', ['lesson_id' => 'lesson_id']);
    }

    public function getVenue(){
        return $this->hasOne(Venue::className(), ['id' => 'venue_id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);
    }
}
