<?php
/**
 * Created by PhpStorm.
 * User: tungphung
 * Date: 4/1/17
 * Time: 10:36 AM
 */
namespace api\modules\v1\controllers;
use api\common\models\BeaconUser;
use api\components\CustomActiveController;
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use  yii\db\Query;
use  yii\web\Request;
use Yii;
class BeaconUserController extends CustomActiveController
{
    public $modelClass = 'api\common\models\BeaconUser';
    public function behaviors()
    {
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
                    'actions' => ['get-user'],
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
    public function actionGetUser(){
        $request = Yii::$app->getRequest();
        $major1 =$request->getBodyParam('major1');
        $minor1 =$request->getBodyParam('minor1');
        $major2 =$request->getBodyParam('major2');
        $minor2 =$request->getBodyParam('minor2');
        $user[] = (BeaconUser::find()->where(['major' => $major1, 'minor' => $minor1])->one());
        $user[] = (BeaconUser::find()->where(['major' => $major2, 'minor' => $minor2])->one());
        return $user;
    }
}