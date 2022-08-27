<?php

/* @var $this yii\web\View */

if (!Yii::$app->user->isGuest) {

    Yii::$app->response->redirect(['site/home']);

} else {

    Yii::$app->response->redirect(['site/login']);

}
?>
