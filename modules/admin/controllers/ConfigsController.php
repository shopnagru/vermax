<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Params;
use app\modules\admin\models\ParamsSearch;
use Yii;
use app\modules\admin\models\Configs;
use app\modules\admin\models\ConfigsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ConfigsController implements the CRUD actions for Configs model.
 */
class ConfigsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions'=>['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Configs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Configs model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ParamsSearch(['conf' => $id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Configs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Configs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Configs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    public function actionCreatemodels($id)
    {


        $model = new Configs();

        $model_main = $this->findModel($id);
        $model->name = $model_main->name.'_clone';
        $model->description = $model_main->description;
        $model->type = $model_main->type;
      // $model->save();
        $params = $model_main->getParams()->all();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($params as $param){
                $new_param = new Params();
                $new_param->name = $param->name;
                $new_param->conf = $model->id;
                $new_param->value = $param->value;
                $new_param->comment = $param->comment;
                $new_param->save();
            }
            return $this->redirect(['newparams', 'id' => $model->id]);
        } else {
            return $this->render('create_clone', [
                'model' => $model,

            ]);
        }
    }


    public function actionNewparams($id){



        $model = new Configs();

        $model = $this->findModel($id);

        $params = $model->getParams()->all();
        $configs = Configs::find()->all();

        return $this->render('view_clone', [
            'params' => $params,
            'model' => $model,
            'configs' => $configs,

        ]);
    }

    /**
     * Множественное сохранение параметров
     */
    public function actionSavenewparams(){

        $data = array();
        foreach ($_POST['Params'] as $key=>$param){
           foreach ($param as $k=>$par){
               $data[$k][$key] = $par;
           }
        }
        foreach ($data as $key_e=>$entyty){
            $model = Params::find()->where(['id'=>$key_e])->one();
            $model->conf = $entyty['conf'];
            $model->comment = $entyty['comment'];
            $model->value = $entyty['value'];
            $model->name = $entyty['name'];
            $model->save();

        }


        return $this->redirect(['index']);

    }
    /**
     * Deletes an existing Configs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        Params::deleteAll(['conf'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Клонируем конфиг
     * @param $id
     * @return \yii\web\Response
     */
    public function actionClone($id)
    {

        $model = new Configs();

        $model_main = $this->findModel($id);
        $model->name = $model_main->name.'_clone';
        $model->description = $model_main->description;
        $model->type = $model_main->type;
        $model->save();
        $params = $model_main->getParams()->all();
        foreach ($params as $param){
            $new_param = new Params();
            $new_param->name = $param->name;
            $new_param->conf = $model->id;
            $new_param->value = $param->value;
            $new_param->comment = $param->comment;
            $new_param->save();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Configs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Configs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
