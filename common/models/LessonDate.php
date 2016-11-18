<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lesson_date".
 *
 * @property integer $id
 * @property integer $lesson_id
 * @property string $ldate
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attendance[] $attendances
 * @property Student[] $students
 * @property BeaconAttendanceLecturer[] $beaconAttendanceLecturers
 * @property BeaconAttendanceStudent[] $beaconAttendanceStudents
 * @property Lesson $lesson
 * @property Lecturer $updatedBy
 */
class LessonDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'ldate'], 'required'],
            [['lesson_id', 'updated_by'], 'integer'],
            [['ldate', 'created_at', 'updated_at'], 'safe'],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Lecturer::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'ldate' => 'Ldate',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::className(), ['lesson_date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['id' => 'student_id'])->viaTable('attendance', ['lesson_date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceLecturers()
    {
        return $this->hasMany(BeaconAttendanceLecturer::className(), ['lesson_date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceStudents()
    {
        return $this->hasMany(BeaconAttendanceStudent::className(), ['lesson_date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'updated_by']);
    }
}
