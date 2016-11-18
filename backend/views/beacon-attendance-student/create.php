<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BeaconAttendanceStudent */

$this->title = 'Create Beacon Attendance Student';
$this->params['breadcrumbs'][] = ['label' => 'Beacon Attendance Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacon-attendance-student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
