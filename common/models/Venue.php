<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "venue".
 *
 * @property integer $id
 * @property string $location
 * @property string $name
 * @property string $uuid
 * @property integer $major
 * @property integer $minor
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lesson[] $lessons
 */
class Venue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location'], 'required'],
            [['major', 'minor'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['location', 'name'], 'string', 'max' => 100],
            [['uuid'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location' => 'Location',
            'name' => 'Name',
            'uuid' => 'Uuid',
            'major' => 'Major',
            'minor' => 'Minor',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(), ['venue_id' => 'id']);
    }
}
