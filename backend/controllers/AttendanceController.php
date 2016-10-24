<?php

namespace backend\controllers;

use common\components\AccessRule;
use common\models\User;
use common\models\search\AttendanceSearch;

use Yii;
use common\models\Attendance;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use moonland\phpexcel\Excel;

/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_LECTURER]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionDay()
    {
        $searchModel = new AttendanceSearch();
        $queryParams = Yii::$app->request->queryParams;
        if (!isset($queryParams['recorded_date']))
            $queryParams['recorded_date'] = date('Y-m-d');
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->pagination = false;
        $query = $dataProvider->query;
        $query->andWhere(['recorded_date' => $queryParams['recorded_date']]);
        if (Yii::$app->user->identity->isStudent()) {
            $query->andWhere(['student_id' => Yii::$app->user->identity->student->id]);
        } else if (Yii::$app->user->identity->isLecturer()) {
            $query->andWhere(['lecturer_id' => Yii::$app->user->identity->lecturer->id]);
        }
        $query->joinWith('lesson');
        $query->orderBy([
            'lesson.start_time' => SORT_ASC,
            'lesson.id' => SORT_ASC,
        ]);
        return $this->render('day', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Lists all Attendance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find(),
        ]);
        $query = $dataProvider->query;
        $query->where([
            'lecturer_id' => Yii::$app->user->identity->lecturer->id
        ]);
        $query->joinWith('lesson', 'student');
        $query->orderBy([
            'recorded_date' => SORT_ASC,
            'lesson.start_time' => SORT_ASC,
            'lesson.id' => SORT_ASC,
        ]);
        $dataProvider->sort->attributes['lesson.class_section'] = [
            'asc' => ['lesson.class_section' => SORT_ASC],
            'desc' => ['lesson.class_section' => SORT_DESC]
        ];
        unset($dataProvider->sort->attributes['is_absent'],
            $dataProvider->sort->attributes['is_late'],
            $dataProvider->sort->attributes['late_min']);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Attendance model.
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
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attendance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Attendance model.
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
     * Deletes an existing Attendance model.
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
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
