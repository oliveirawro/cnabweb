<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilesCnab */
/* @var $form yii\widgets\ActiveForm */

$this->params['breadcrumbs'][] = ['label' => 'Arquivos CNAB', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div id="title-bar" class="container" style="">
    <div style="">
        <h1 class="title">Selecione arquivo CNAB</h1>
        <p class='subtitle'>Clique no botão abaixo para fazer o carregamento de um arquivo no formato CNAB.</p>
    </div>
</div>



<div class="url-create">


    <div class="url-form form-gray">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <div class="" style="height: 250px">

            <?= Html::label('Arquivo:', '', ['class' => 'col-sm-1 subtitle', 'style' => 'padding-top:25px']);?>

            <div class="col-sm-11">
                <?= $form->field($model, 'file')->fileInput(['class' =>'btn btn-green', 'style' => 'width:500px;'])->label(''); ?>
            </div>

        </div>


        <div class="form-group" style="float: right">
            <?=Html::a("<i class='fa fa-caret-left'></i> " . "Voltar" ,["index"], ["class" => "cla-btn btn-primary"]); ?>
            <?=Html::submitButton(Yii::t('app', 'Carregar'), ['name' => 'btnSubmit', 'value' => 'true', 'id'=>'btnSubmit', 'class' => 'cla-btn btn-green']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
