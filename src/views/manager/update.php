<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manager */

$this->title = 'Редактирование менеджера: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Менеджеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="manager-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
