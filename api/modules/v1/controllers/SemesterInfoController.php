<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\components\CustomActiveController;
use common\components\AccessRule;
use common\models\SemesterInfo;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class SemesterInfoController extends CustomActiveController
{
    public $modelClass = 'common\models\SemesterInfo';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => [],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
            ],
        ];

        return $behaviors;
    }

    public function actionCurrent(){
        $query = SemesterInfo::find()->andWhere('start_date <= \''.date('Y-m-d').'\' and end_date >= \''.date('Y-m-d').'\'')->one();
        $result['name'] = $query['name'];
        $result['start_date'] = $query['start_date'];
        $result['end_date'] = $query['end_date'];
        return $result;
    }
}