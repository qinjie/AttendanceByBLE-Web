<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SemesterDate */

$this->title = 'Update Semester Date: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Semester Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="semester-date-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
