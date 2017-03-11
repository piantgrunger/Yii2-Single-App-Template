<?php

namespace app\controllers;

use Yii;
use app\models\Departemen;
use app\models\Divisi;
use app\models\DepartemenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * DepartemenController implements the CRUD actions for Departemen model.
 */
class DepartemenController extends Controller
{
    /**
     * @inheritdoc
     */
    public function getDataBrowseDivisi()
    {        
     return ArrayHelper::map(
                                Divisi::find()
                                        ->select([
                                                'id_divisi','ket_divisi' => 'CONCAT(kode_divisi," - ",nama_divisi)'
                                        ])
                                        ->asArray()
                                        ->all(), 'id_divisi', 'ket_divisi');
    }
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Departemen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartemenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single Departemen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Departemen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Departemen();
        $dataBrowse = $this->getDataBrowseDivisi();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_departemen]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataBrowse'=>$dataBrowse,
            ]);
        }
    }

    /**
     * Updates an existing Departemen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataBrowse = $this->getDataBrowseDivisi();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_departemen]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataBrowse'=>$dataBrowse,
            ]);
        }
    }

    /**
     * Deletes an existing Departemen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Departemen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Departemen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Departemen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
