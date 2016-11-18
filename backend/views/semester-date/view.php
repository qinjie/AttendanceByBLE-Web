<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SemesterDate */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Semester Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-date-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'semester_id',
            'tdate',
            'week_num',
            'weekday',
            'is_holiday',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
