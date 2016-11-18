<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacon_lesson".
 *
 * @property integer $id
 * @property integer $lesson_id
 * @property string $uuid
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lesson $lesson
 */
class BeaconLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacon_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id'], 'integer'],
            [['uuid'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid'], 'string', 'max' => 40],
            [['uuid'], 'unique'],
            [['lesson_id'], 'unique'],
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
            'uuid' => 'Uuid',
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

    public function getTimetable()
    {
        return $this->hasOne(Timetable::className(), ['lesson_id' => 'lesson_id']);
    }
}
