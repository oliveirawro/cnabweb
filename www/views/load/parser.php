<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
use app\common\Util;
use \app\controllers\LoadController;

/* @var $this yii\web\View */
/* @var $model app\models\FilesCnab */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Extração realizada com sucesso!';
$this->params['breadcrumbs'][] = ['label' => 'Arquivos CNAB', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div id="title-bar" class="container" style="">
    <div style="">
        <h1 class="title"><?= Html::encode($this->title) ?></h1>
        <p class='subtitle'>Verifique no quadro <b>Total Acumulado</b> o somatório desta extração.</p>
    </div>

</div>



<div class="url-create">


    <div class="url-form form-gray">


        <div class="" style="height: 250px">


            <div class="col-sm-12">

                <table id='extract_table' border="1">
                    <thead>
                    <tr>
                        <th>Linha</th>
                        <th>CPF</th>
                        <th>Transação</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Cartão</th>
                        <th>Nome da Loja</th>
                        <th>Representante da Loja</th>
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Total</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php
                    $line = 1;
                    foreach($dataTransaction as $row) {

                        $description = LoadController::getTransactionNameByCode($row['TransactionTypeCode']);
                        $category = LoadController::getCategoryByTransactionCode($row['TransactionTypeCode']);
                        $signal = LoadController::getSignalByTransactionCode($row['TransactionTypeCode']);

                        ?>

                        <tr>
                            <td style="text-align: center"><?=$line?></td>
                            <td style="text-align: center"><?= Util::formatCPF($row['NationalRegister'])?></td>
                            <td style="text-align: center;"><?=$description ?></td>
                            <td style="text-align: center"><?= Util::dateUStoBR($row['DateOccurrence'])?></td>
                            <td style="text-align: center"><?= Util::timeAdjust($row['TimeOccurrence'])?></td>
                            <td style="text-align: center"><?= $row['Card'] ?></td>
                            <td style="text-align: left"><?= $row['NameStore'] ?></td>
                            <td style="text-align: left"><?= $row['NameStoreOwner'] ?></td>
                            <td style="text-align: right"><?= number_format($row['Value'], 2, ',', '.')?></td>
                            <td style="text-align: center; font-weight:bold; color:<?= ($signal=='+') ? "#02BE3B" : "red" ?>"><?=$category?></td>
                            <td style="text-align: right"><?= number_format($row['Total'], 2, ',', '.')?></td>
                        </tr>


                    <?php
                        $line++;
                    }
                    ?>

                    </tbody>
                </table>
            </div>



        </div>

        <div class="col-sm-4 box-total">
            Total Acumulado: <?= number_format(LoadController::getAmountByCode($row['FilesCnabCode']), 2, ',', '.')?>
        </div>


        <div class="form-group" style="padding-top:20px; float: right">
            <?=Html::a("<i class='fa fa-caret-left'></i> " . "Voltar" ,["index"], ["class" => "cla-btn btn-primary"]); ?>
        </div>


    </div>

</div>
