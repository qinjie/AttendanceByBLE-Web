<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SemesterInfo */

$this->title = 'Update Semester Info: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Semester Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="semester-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
