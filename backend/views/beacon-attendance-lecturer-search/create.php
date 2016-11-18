<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BeaconAttendanceLecturer */

$this->title = 'Create Beacon Attendance Lecturer';
$this->params['breadcrumbs'][] = ['label' => 'Beacon Attendance Lecturers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacon-attendance-lecturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
