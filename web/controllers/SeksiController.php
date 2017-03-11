<?php

namespace app\controllers;

use Yii;
use app\models\Seksi;
use app\models\SeksiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Departemen;
use yii\helpers\ArrayHelper;

/**
 * SeksiController implements the CRUD actions for Seksi model.
 */
class SeksiController extends Controller
{
    /**
     * @inheritdoc
     */
    
     public function getDataBrowseDepartemen()
    {        
     return ArrayHelper::map(
                     Departemen::find()
                                        ->select([
                                                'id_departemen','ket_departemen' => 'CONCAT(kode_departemen," - ",nama_departemen)','nama_divisi'
                                        ])
                                        ->join('left join','tb_m_divisi',['tb_m_divisi.id_divisi'=>'tb_m_departemen.id_divisi'])   
                                        ->asArray()
                                        ->all(), 'id_departemen', 'ket_departemen','nama_divisi');
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
     * Lists all Seksi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seksi model.
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
     * Creates a new Seksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seksi();
        $dataBrowse = $this->getDataBrowseDepartemen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_seksi]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataBrowse'=>$dataBrowse,
            ]);
        }
    }

    /**
     * Updates an existing Seksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataBrowse = $this->getDataBrowseDepartemen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_seksi]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataBrowse'=>$dataBrowse,
                
                
            ]);
        }
    }

    /**
     * Deletes an existing Seksi model.
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
     * Finds the Seksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seksi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
