<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\models\Attendance;
use api\components\CustomActiveController;
use common\components\AccessRule;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use Yii;

class AttendanceController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Attendance';

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

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new \common\models\AttendanceSearch();
        $dataProvider = $searchModel->searchRest(Yii::$app->request->queryParams);
        $query = $dataProvider->query;
        return $dataProvider;
    }

    public function actionListAttendanceStatusByLecturer()
    {
        $request = Yii::$app->request;
        $bodyParams = $request->bodyParams;
        $lesson_date_id =  $bodyParams['lesson_date_id'];
        $searchModel = new \common\models\AttendanceSearch();
        $dataProvider = $searchModel->searchByLecturer($lesson_date_id);
        return $dataProvider;
    }

    public function actionUpdateStatus()
    {
        $request = Yii::$app->request;
        $bodyParams = $request->bodyParams;
        $lesson_date_id =  $bodyParams['lesson_date_id'];
        $student_id = $bodyParams['student_id'];
        $seachStudent = new \common\models\StudentSearch();
        $student_name = $seachStudent->searchName($student_id);
        $status = $bodyParams['status'];
        $result = Yii::$app->db->createCommand()->update('attendance', ['status' => $status], 'lesson_date_id ='.$lesson_date_id.' and student_id='.$student_id)->execute();
        if ($result == 1)
            return 'Update attendance status of Student '.$student_name.' to '.$status.' successful.';
        else
            return 'Update attendance status of Student '.$student_name.' to '.$status.' failed.';
    }
}