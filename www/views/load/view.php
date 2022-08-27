<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\common\Util;
use \app\controllers\LoadController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilesCnabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$FilesCnabCode = Yii::$app->request->get('Code');
$this->title = 'Arquivo: ' . \app\controllers\LoadController::getFileNameByCode($FilesCnabCode);
$this->params['breadcrumbs'][] = "Detalhes da Extração";



?>


<div id="title-bar" class="container">
    <div>
        <h1 class="title"><?= Html::encode($this->title);?></h1>
    </div>


    <div class="form-inline well gradient_tb" style="height: 80px !important;">

        <?=Html::a("<i class='fa fa-plus'></i> " . "Carregar Novo Arquivo",["upload"], ["class" => "cla-btn btn-green", "style" => 'float:right']); ?>
        <?=Html::a("<i class='fa fa-caret-left'></i> " . "Voltar" ,["index"], ["class" => "cla-btn btn-primary", "style" => 'float:right']); ?>

        <div class="box-detail-total">Total Acumulado: <?= number_format(LoadController::getAmountByCode($FilesCnabCode), 2, ',', '.')?></div>

    </div>

</div>



<div class="url-index">


    <script>

        $(function() {

            window.setInterval(function(){
                $.pjax.reload({container: '#pjax_id', async: false});
            }, 2000); //reloading after 2 seconds...

        });

    </script>



    <?php Pjax::begin(['id'=>'pjax_id', 'timeout' => 500]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'model' => $model,
        'layout' => '{items}{pager}{summary}',
        'columns' => [
            [
                'label' => '#',
                'attribute' => 'Code',
                'value' => 'Code',
                'contentOptions' => ['style' => 'width: 50px;text-align:center'],
                'headerOptions'  => ['style' => 'text-align:center'],
            ],

            [
                'label' => 'CPF',
                'attribute' => 'NationalRegister',
                'value' => function($model) {
                    return Util::formatCPF($model->NationalRegister);
                },
            ],

            [
                'label' => 'Transação',
                'attribute' => 'TransactionTypeCode',
                'format'=>'raw',
                'value' => function($model) {
                    return  \app\controllers\LoadController::getTransactionNameByCode($model->TransactionTypeCode);
                },
            ],

            [
                'label' => 'Data',
                'attribute' => 'DateOccurrence',
                'value' => function($model) {
                    return date("d/m/Y", strtotime($model->DateOccurrence));
                },
            ],

            [
                'label' => 'Hora',
                'attribute' => 'TimeOccurrence',
                'value' => function($model) {
                    return date("H:m:s", strtotime($model->TimeOccurrence));
                },
            ],

            [
                'label' => 'Cartão',
                'attribute' => 'Card',
                'value' => 'Card',
            ],

            [
                'label' => 'Nome da Loja',
                'attribute' => 'NameStore',
                'value' => 'NameStore',
            ],

            [
                'label' => 'Representante da Loja',
                'attribute' => 'NameStoreOwner',
                'value' => 'NameStoreOwner',
            ],

            [
                'label' => 'Valor',
                'attribute' => 'Value',
                'value' => function($model) {
                    return number_format($model->Value, 2, ',', '.');
                },
            ],

            [
                'label' => 'Categoria',
                'attribute' => 'TransactionTypeCode',
                'format'=>'raw',
                'value' => function($model) {
                    return  \app\controllers\LoadController::getCategoryByTransactionCode($model->TransactionTypeCode);
                },
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>


</div>
