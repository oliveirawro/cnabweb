<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilesCnabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>



<div id="title-bar" class="container">
    <div>
        <h1 class="title">Arquivos Carregados</h1>
        <p class='subtitle'>Esta é uma lista com arquivos carregados CNAB previamente.</p>
    </div>


    <div class="form-inline well gradient_tb" style="height: 80px">
        <?=Html::a("<i class='fa fa-plus'></i> " . "Carregar Novo Arquivo",["upload"], ["class" => "cla-btn btn-green", "style" => 'float:right']); ?>
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
                'label' => 'Arquivo',
                'attribute' => 'FileName',
                'value' => 'FileName',
            ],


            [
                'label' => 'Data de Carregamento',
                'attribute' => 'DateTimeLoaded',
                'value' => function($model) {
                    $dateTimeLoaded = $model->DateTimeLoaded;
                    return date("d/m/Y H:i:s", strtotime($dateTimeLoaded));
                },
            ],



            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'contentOptions' => ['style' => 'width: 80px;text-align:center'],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['load/'.$action, 'Code' => $model->Code]);
                }
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>



</div>
