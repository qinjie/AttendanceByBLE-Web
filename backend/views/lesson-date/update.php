<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LessonDate */

$this->title = 'Update Lesson Date: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lesson Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lesson-date-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
