<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentLeave */

$this->title = 'Update Student Leave: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Leaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-leave-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
