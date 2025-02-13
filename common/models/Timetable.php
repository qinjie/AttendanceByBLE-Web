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

    public function getLessonThisWeek(){
        return $this->hasOne(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id'])->where(['>=', 'ldate', date('Y-m-d', strtotime('monday this week'))]);
    }

    public function getLecturers(){
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id'])
        ->viaTable('lesson_lecturer', ['lesson_id' => 'lesson_id']);
    }

    public function getVenue(){
        return $this->hasOne(Venue::className(), ['id' => 'venue_id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);
    }

    public function getLesson_date(){
        return $this->hasOne(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id'])->andWhere(['>=', 'lesson_date.ldate', date('Y-m-d', strtotime('monday this week'))])->andWhere(['<=', 'lesson_date.ldate', date('Y-m-d', strtotime('sunday this week'))]);
    }

    public function getLessondate(){
        return $this->hasOne(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);
    }

    public function getBeaconLesson(){
        return $this->hasOne(BeaconLesson::className(), ['lesson_id' => 'lesson_id']);

    }

    public function getStudents(){
        $timetable = Timetable::find()->where(['lesson_id' => $this->lesson_id])->all();
        $listStudent = [];
        foreach ($timetable as $item){
            $listStudent[] =  $item->student;
        }
        return $listStudent;
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'lesson';
        $fields[] = 'lesson_date';
        $fields[] = 'venue';
        $fields[] = 'lecturers';
        $fields[] = 'beaconLesson';
        $fields[] = 'students';
//        unset($fields['created_at']);
//        unset($fields['updated_at']);
//        unset($fields['lesson_id']);
//        unset($fields['student_id']);
        return $fields;
    }

//    public function extraFields()
//    {
//        $more = ['lesson', 'lesson_date', 'venue', 'lecturers'];
//        $fields = array_merge(parent::fields(), $more);
//        return $fields;
//    }
}
