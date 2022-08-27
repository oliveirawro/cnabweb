<?php

namespace app\controllers;

use app\models\FilesCnabSearch;
use app\models\TransactionCnab;
use app\models\TransactionCnabSearch;
use app\models\TransactionType;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Url;
use app\models\FilesCnab;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use app\common\Util;

/**
 * LoadController implements the CRUD actions for Load model.
 */


class LoadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','getFileNameByCode'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new FilesCnabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($Code)
    {

        $searchModel = new TransactionCnabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['FilesCnabCode' => $Code]);


        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }



    public function actionUpload()
    {
        $model = new FilesCnab();
        $rows = [];

        $posted = Yii::$app->request->post();

        if ($model->load($posted)) {

            $model->UserCode = Yii::$app->user->identity->Code;

            $model->DateTimeLoaded = date("Y-m-d H:i:s");

            //UPLOAD ************************************************************************
            $uploadPath = dirname(__DIR__) . '/uploads/';

            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');

                $model->FileName = time() . '__' . $model->file->baseName . '.' . $model->file->extension;

                if ($model->file && $model->validate()) {

                    $fullFileName = $uploadPath . $model->FileName;
                    $model->file->saveAs($fullFileName);

                    $model->save();

                    //After upload success, pass the ID and redirect to parser
                    $Code = Util::getNewIdTable('FilesCnab','Code') -1;
                    return $this->redirect(['load/parser', 'Code' => $Code]);

                }

            }

        }

        return $this->render('upload', [
            'model' => $model,
        ]);

    }





   
    public function actionParser($Code)
    {


        $model = FilesCnab::find()->where(['Code' => $Code])->one();


        //PARSE ******************************************
        $uploadPath = dirname(__DIR__) . '/uploads/';
        $file       = file_get_contents($uploadPath . $model->FileName);
        $rows       = explode("\n", $file);

        $dataTransaction = array();
        $total = 0;
        $i = 0;

        foreach($rows as $row => $data)  {

            if ($data !== "") {



                $dataTransaction[$i]['FilesCnabCode']       = $Code;
                $dataTransaction[$i]['TransactionTypeCode'] = substr($data, 0, 1); //Tipo da transação
                $dataTransaction[$i]['DateOccurrence']      = substr($data, 1, 8); //Tipo da ocorrência
                $dataTransaction[$i]['Value']               = number_format((substr($data, 9, 10)/100), 2, '.', ''); //Valor da movimentação (valor / 100.00)
                $dataTransaction[$i]['NationalRegister']    = substr($data, 19, 11); //Valor da movimentação
                $dataTransaction[$i]['Card']                = substr($data, 30, 12); //Cartão utilizado na transação
                $dataTransaction[$i]['TimeOccurrence']      = substr($data, 42, 6); //Hora da ocorrência atendendo ao fuso de UTC-3
                $dataTransaction[$i]['NameStoreOwner']      = substr($data, 48, 14); //Nome do representante da loja
                $dataTransaction[$i]['NameStore']           = substr($data, 62, 20); //Nome da loja

                //Total Incremental
                $signal                                     = LoadController::getSignalByTransactionCode($dataTransaction[$i]['TransactionTypeCode']);
                $total                                      = ($signal=='+') ? ($total+$dataTransaction[$i]['Value']) : ($total-$dataTransaction[$i]['Value']);
                $dataTransaction[$i]['Total']               = $total;



                $modelTransaction = new TransactionCnab();

                $modelTransaction->FilesCnabCode            = Util::cleanStr($dataTransaction[$i]['FilesCnabCode']);
                $modelTransaction->TransactionTypeCode      = Util::cleanStr($dataTransaction[$i]['TransactionTypeCode']);
                $modelTransaction->DateOccurrence           = Util::cleanStr($dataTransaction[$i]['DateOccurrence']);
                $modelTransaction->Value                    = Util::cleanStr($dataTransaction[$i]['Value']);
                $modelTransaction->NationalRegister         = Util::cleanStr($dataTransaction[$i]['NationalRegister']);
                $modelTransaction->Card                     = Util::cleanStr($dataTransaction[$i]['Card']);
                $modelTransaction->TimeOccurrence           = Util::cleanStr($dataTransaction[$i]['TimeOccurrence']);
                $modelTransaction->NameStoreOwner           = Util::cleanStr($dataTransaction[$i]['NameStoreOwner']);
                $modelTransaction->NameStore                = Util::cleanStr($dataTransaction[$i]['NameStore']);


                if (is_null(LoadController::checkParsed($Code))) {
                    $modelTransaction->save();
                }


                $i++;
            }
        }

        Yii::$app->db->createCommand()
            ->update('FilesCnab', ['Amount' => $total, 'Parsed' => true], "Code = $Code")
            ->execute();



        return $this->render('parser', [
            'model' => $model,
            'rows' => $rows,
            'modelTransaction' => $modelTransaction,
            'dataTransaction' => $dataTransaction,
        ]);

    }



    public function getFileNameByCode($Code)
    {
        $model = FilesCnab::find()->where(['Code' => $Code])->one();
        return $model->FileName;
    }

    public function getSignalByTransactionCode($Code)
    {
        $model = TransactionType::find()->where(['Code' => $Code])->one();
        return $model->Signal;
    }

    public function getCategoryByTransactionCode($Code)
    {
        $model = TransactionType::find()->where(['Code' => $Code])->one();
        return $model->Category;
    }

    public function getTransactionNameByCode($Code)
    {
        $model = TransactionType::find()->where(['Code' => $Code])->one();
        return $model->Description;
    }

    public function getAmountByCode($Code)
    {
        $model = FilesCnab::find()->where(['Code' => $Code])->one();
        return $model->Amount;
    }

    public function checkParsed($Code)
    {
        $model = FilesCnab::find()->where(['Code' => $Code])->one();
        return $model->Parsed;
    }

    public function actionDelete($Code)
    {
        $model = FilesCnab::findOne($Code);
        $model->delete();
        return $this->redirect(['load/index']);
    }






}
