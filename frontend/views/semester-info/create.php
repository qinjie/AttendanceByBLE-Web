<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SemesterInfo */

$this->title = 'Create Semester Info';
$this->params['breadcrumbs'][] = ['label' => 'Semester Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
