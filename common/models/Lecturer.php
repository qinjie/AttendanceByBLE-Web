<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lecturer".
 *
 * @property integer $id
 * @property string $card
 * @property string $name
 * @property string $acad
 * @property string $email
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attendance[] $attendances
 * @property BeaconAttendanceLecturer[] $beaconAttendanceLecturers
 * @property User $user
 * @property LessonDate[] $lessonDates
 * @property LessonLecturer[] $lessonLecturers
 * @property Lesson[] $lessons
 */
class Lecturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['card', 'acad'], 'string', 'max' => 10],
            [['name', 'email'], 'string', 'max' => 255],
            [['card'], 'unique'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card' => 'Card',
            'name' => 'Name',
            'acad' => 'Acad',
            'email' => 'Email',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::className(), ['lecturer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceLecturers()
    {
        return $this->hasMany(BeaconAttendanceLecturer::className(), ['lecturer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonDates()
    {
        return $this->hasMany(LessonDate::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonLecturers()
    {
        return $this->hasMany(LessonLecturer::className(), ['lecturer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(), ['id' => 'lesson_id'])->viaTable('lesson_lecturer', ['lecturer_id' => 'id']);
    }

    public function getBeacon(){
        return $this->hasOne(BeaconUser::className(), ['user_id' => 'user_id']);
    }
}
