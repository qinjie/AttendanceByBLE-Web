<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BeaconAttendanceLecturerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beacon Attendance Lecturers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacon-attendance-lecturer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Beacon Attendance Lecturer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lesson_date_id',
            'student_id',
            'lecturer_id',
            'status',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
