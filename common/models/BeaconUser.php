<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacon_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $major
 * @property integer $minor
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class BeaconUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacon_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'major', 'minor'], 'integer'],
            [['major', 'minor'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
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
            'user_id' => 'User ID',
            'major' => 'Major',
            'minor' => 'Minor',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
