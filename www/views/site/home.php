<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Olá, bem-vindo!';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-about">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class='subtitle' style="padding-top: 20px">Este é um sistema de extração e carregamento de arquivos CNAB.</p>
    <p class='subtitle' style="margin-top:20px"><b><?=Html::a("> Clique aqui" ,["load/index"]); ?></b> para visualizar os arquivos já carregados.</p>

</div>
