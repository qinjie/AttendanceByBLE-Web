<?php

namespace backend\controllers;

use Yii;
use common\models\SemesterInfo;
use common\models\SemesterInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SemesterInfoController implements the CRUD actions for SemesterInfo model.
 */
class SemesterInfoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SemesterInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemesterInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemesterInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SemesterInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SemesterInfo();

        if ($model->load(Yii::$app->request->post())) {
            $begin = new \DateTime($model->start_date);
            $beforeDate = new \DateTime(date('Y-m-d', strtotime($model->start_date . ' -1 day' )));
            $afterDate = new \DateTime(date('Y-m-d', strtotime($model->end_date . ' +1 day' )));
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $afterDate);
            $start_weekday = date('w', strtotime($begin->format('Y-m-d')));
            $weeknum = 1;
            if ($start_weekday == 1){
                $weeknum = 0;
            }
            foreach ( $period as $dt ){
                $tdate = $dt->format( "Y-m-d" );
                $weekday = date('w', strtotime($dt->format('Y-m-d')));
                $weekday++;
                if ($weekday==1) $weekday = 8;
                if ($weekday==2) $weeknum++;
                $is_holiday = false;
                $cmd = Yii::$app->db
                    ->createCommand("select hdate from  public_holiday where hdate = :tdate");
                $cmd->bindValue(':tdate', $tdate);
                $result = $cmd->query();
                if (count($result) > 0){
                    $is_holiday = true;
                }
                $cmd = Yii::$app->db
                    ->createCommand("insert into semester_date(semester_id, tdate, week_num, weekday, is_holiday) values (1, :tdate, :weeknum, :weekday, :is_holiday)");
                $cmd->bindValue(':tdate', $tdate);
                $cmd->bindValue(':weeknum', $weeknum);
                $cmd->bindValue(':weekday', $weekday);
                $cmd->bindValue(':is_holiday', $is_holiday);
                $result = $cmd->query();
            }

            $cmd = Yii::$app->db
                ->createCommand("select tdate, week_num, weekday from semester_date where is_holiday = 0 and tdate >= ".$model->start_date." and tdate <= ".$model->end_date."");
            $result = $cmd->queryAll();
            foreach ($result as $td){
                $ldate = $td['tdate'];
                $week_num = $td['week_num'];
                $weekday = $td['weekday'];

                $cmd = Yii::$app->db
                    ->createCommand("select id from lesson where weekday = :weekday");
                $cmd->bindValue(':weekday', $weekday);
                $lesson = $cmd->queryAll();

                foreach ($lesson as $ls){
                    $lesson_id = $ls['id'];
                    $cmd = Yii::$app->db
                        ->createCommand("insert into lesson_date(lesson_id, ldate, updated_by) values (:lession_id, :ldate, 1)");
                    $cmd->bindValue(':lession_id', $lesson_id);
                    $cmd->bindValue(':ldate', $ldate);
                    $result = $cmd->query();
                }
            }
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SemesterInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SemesterInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SemesterInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SemesterInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemesterInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
