<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentLeave */

$this->title = 'Create Student Leave';
$this->params['breadcrumbs'][] = ['label' => 'Student Leaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-leave-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
