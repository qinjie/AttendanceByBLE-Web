<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $card
 * @property string $name
 * @property string $gender
 * @property string $acad
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attendance[] $attendances
 * @property LessonDate[] $lessonDates
 * @property BeaconAttendanceLecturer[] $beaconAttendanceLecturers
 * @property BeaconAttendanceStudent[] $beaconAttendanceStudents
 * @property BeaconAttendanceStudent[] $beaconAttendanceStudents0
 * @property User $user
 * @property StudentLeave[] $studentLeaves
 * @property Timetable[] $timetables
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
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
            [['name'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 1],
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
            'gender' => 'Gender',
            'acad' => 'Acad',
            'uuid' => 'Uuid',
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
        return $this->hasMany(Attendance::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonDates()
    {
        return $this->hasMany(LessonDate::className(), ['id' => 'lesson_date_id'])->viaTable('attendance', ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceLecturers()
    {
        return $this->hasMany(BeaconAttendanceLecturer::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceStudents()
    {
        return $this->hasMany(BeaconAttendanceStudent::className(), ['student_id_1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeaconAttendanceStudents0()
    {
        return $this->hasMany(BeaconAttendanceStudent::className(), ['student_id_2' => 'id']);
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
    public function getStudentLeaves()
    {
        return $this->hasMany(StudentLeave::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['student_id' => 'id']);
    }

    public function getBeacon_user(){
        return $this->hasOne(BeaconUser::className(), ['user_id' => 'id'])
            ->viaTable('user', ['id' => 'user_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'beacon_user';
        return $fields;
    }
}
