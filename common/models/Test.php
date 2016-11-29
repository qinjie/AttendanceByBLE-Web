<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $major1
 * @property integer $minor1
 * @property integer $major2
 * @property integer $minor2
 * @property string $created_at
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['major1', 'minor1', 'major2', 'minor2'], 'required'],
            [['major1', 'minor1', 'major2', 'minor2'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'major1' => 'Major1',
            'minor1' => 'Minor1',
            'major2' => 'Major2',
            'minor2' => 'Minor2',
            'created_at' => 'Created At',
        ];
    }
}
