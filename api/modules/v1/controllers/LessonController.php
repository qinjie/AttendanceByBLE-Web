<?php

namespace api\modules\v1\controllers;

use common\models\Lesson;
use common\models\search\LessonSearch;
use api\components\CustomActiveController;
use common\models\User;
use common\components\AccessRule;
use common\components\Util;
use api\models\FaceAttendanceForm;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends CustomActiveController
{
    const CURRENT_SEMESTER = 2;

    public $modelClass = 'common\models\Lesson';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth::className()
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['current-classes'],
                        'allow' => true,
                        'roles' => [User::ROLE_STUDENT],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new UnauthorizedHttpException('You are not authorized');
                },
            ]
        ];
    }

    public function actionCurrentClasses()
    {
        $searchModel = new LessonSearch();
        $dataProvider = $searchModel->search(null);
        $query = $dataProvider->query;
        $query->joinWith([
            'attendances' => function($query) {
                $query->andWhere([
                    'student_id' => Yii::$app->user->identity->student->id
                ]);
            }
        ]);
        $query->joinWith('attendances');
        $query->where([
            'attendance.student_id' => Yii::$app->user->identity->student->id,
            'semester' => self::CURRENT_SEMESTER
        ]);
        $query->orderBy([
            'class_section' => SORT_ASC
        ]);

        $listModels = $dataProvider->getModels();
        $result = [];
        $count = 0;
        for ($iter = 0; $iter < count($listModels); ++$iter) {
            $listModels[$iter] = $listModels[$iter]->toArray([], ['attendances']);
            if (count($result) == 0) {
                $result[] = $listModels[$iter];
                $count += 1;
            } else if ($result[$count - 1]['class_section'] == $listModels[$iter]['class_section']) {
                $result[$count - 1]['attendances'] = array_merge(
                    $result[$count - 1]['attendances'],
                    $listModels[$iter]['attendances']
                );
            } else {
                $result[] = $listModels[$iter];
                $count += 1;
            }
        }
        $sortFn = function($v1, $v2) {
            return strcmp($v1['recorded_date'], $v2['recorded_date']);
        };
        for ($iter = 0; $iter < $count; ++$iter) {
            usort($result[$iter]['attendances'], $sortFn);
        }
        return $result;
    }

    /**
     * Lists all Lesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lesson model.
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
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lesson model.
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
     * Deletes an existing Lesson model.
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
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
