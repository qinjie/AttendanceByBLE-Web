<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BeaconAttendanceStudent */

$this->title = 'Update Beacon Attendance Student: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Beacon Attendance Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="beacon-attendance-student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
