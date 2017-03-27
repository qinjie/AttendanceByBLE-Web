<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\models\Student;
use api\common\models\Timetable;
use api\components\CustomActiveController;
use common\components\AccessRule;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class TimetableController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Timetable';

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
        $searchModel = new \common\models\TimetableSearch();
        $dataProvider = $searchModel->searchRest(Yii::$app->request->queryParams);
        return $dataProvider;
    }

    public function actionTime(){
        $request = Yii::$app->request;
        $bodyParams = $request->bodyParams;
//        $student_id =  $bodyParams['student_id'];
        $datetime =  $bodyParams['datetime'];
        $datetime = strtotime($datetime);
        $date = date('Y-m-d', $datetime);
        $time = date('H:m:s', $datetime);
//        $data = Timetable::find()->where(['student_id' => $student_id, 'lesson.ldate' => $date])->all();
        $searchModel = new \common\models\TimetableSearch();
        $dataProvider = $searchModel->searchNow(Yii::$app->request->queryParams, $time, $date);
//        if (empty($dataProvider->getModels())) return null;
        return $dataProvider->getModels()[0];

    }

    public function actionGetStudent(){
        $request = Yii::$app->request;
        $bodyParams = $request->bodyParams;
        $lesson_id =  $bodyParams['lesson_id'];
        $data = Timetable::find()->where(['lesson_id' => $lesson_id])->all();
        $listStudent = [];
        foreach ($data as $item){
            $listStudent[] =  $item->student;
        }
        return $listStudent;
    }

    public function actionGetAllStudent(){
        $request = Yii::$app->request;
        $bodyParams = $request->bodyParams;
        $student_id =  $bodyParams['student_id'];
        $timetable = Timetable::find()->where(['student_id' => $student_id])->all();
        $listTimeTable = [];
//        return $timetable;
        foreach ($timetable as $lesson){
            $data = Timetable::find()->where(['lesson_id' => $lesson->lesson_id])->all();
            $listStudent = [];
            foreach ($data as $item){
                $listStudent[] =  $item->student;
            }
            $listTimeTable[] = array("lesson_id" => $lesson->lesson_id,"students" => $listStudent);
        }
        return $listTimeTable;

        return $listStudent;

    }
}