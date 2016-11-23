<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lesson_lecturer".
 *
 * @property integer $id
 * @property integer $lesson_id
 * @property integer $lecturer_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lesson $lesson
 * @property Lecturer $lecturer
 */
class LessonLecturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'lecturer_id'], 'required'],
            [['lesson_id', 'lecturer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lesson_id', 'lecturer_id'], 'unique', 'targetAttribute' => ['lesson_id', 'lecturer_id'], 'message' => 'The combination of Lesson ID and Lecturer ID has already been taken.'],
            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
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
            'lesson_id' => 'Lesson ID',
            'lecturer_id' => 'Lecturer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getLecturer()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'lecturer_id']);
    }

    public function getVenue(){
        return $this->hasOne(Venue::className(), ['id' => 'venue_id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);
    }

    public function getLesson_date(){
        return $this->hasMany(LessonDate::className(), ['lesson_id' => 'id'])
            ->viaTable('lesson', ['id' => 'lesson_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        return $fields;
    }

    public function extraFields()
    {
        $fields = parent::fields();
        $fields[] = 'lesson';
        $fields[] = 'venue';
        $fields[] = 'lesson_date';
        return $fields;
    }
}
