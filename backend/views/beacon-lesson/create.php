<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BeaconLesson */

$this->title = 'Create Beacon Lesson';
$this->params['breadcrumbs'][] = ['label' => 'Beacon Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacon-lesson-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
