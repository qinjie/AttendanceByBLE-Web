<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BeaconUser */

$this->title = 'Create Beacon User';
$this->params['breadcrumbs'][] = ['label' => 'Beacon Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beacon-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
