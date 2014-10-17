<?php

class PostsController extends ApiController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    public $allowedActions = array(
        'create',
        'comment',
        'update',
        'delcomm',
    );
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view', 'create', 'comment', 'update', 'delcomm'),
                'users'=>array('*'),
            ),
            //array('allow', // allow authenticated user to perform 'create' and 'update' actions
            //    'actions'=>array('create','update'),
            //    'users'=>array('*'),
                //'users'=>array('@'),
            //),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Posts;


        if(isset($_POST['Posts']))
        {
            $data = array_merge($_POST['Posts'], array('id_author' => Yii::app()->user->getCurrent()->id));

            $model->setAttributes($data);



            if($model->save()){
                $this->sendResponse(self::STATUS_OK, $model->attributes);
            }
        }

        $this->sendResponse(self::STATUS_BAD_REQUEST, array($model->getErrors(), $model->attributes));//return;

    }

    public function actionComment()
    {

        $errors = array();

        $author_name = '';

        $avaPath = 'noimage.png';


        if(Yii::app()->user->isGuest){
            if(!empty($_POST['Users'])){
                $users = new Users;
                $addData = array(
                    'author_id' => '0',
                );

                $users->attributes = array_merge($_POST['Users'], array('pass' => 'Insert Ur Pass Here', 'status' => Users::LEFT_COMMENT));

                //$users->validate();
                $ifKent = Users::model()->find('login=:LOG', array(':LOG'=>$users->login));


                //die(var_dump($ifKent));

                if(!$ifKent and $users->save()){
                    $addData['author_id'] = $users->getAttribute('id');
                    $author_name = $users->login;
                }elseif(!$ifKent){
                    //$this->sendResponse(self::STATUS_OK, $_POST);
                    $errors = array_merge($users->getErrors(), $errors);
                    //unset($errors['author_id']);
                }else{
                    $addData['author_id'] = $ifKent->id;
                    $author_name = $ifKent->login;

                    $avaPath = $ifKent->pic ?  $ifKent->id . '/avatar/' . $ifKent->pic : 'noimage.png';
                }
            }else{
                $errors['ident'] = 'Empty identification data';
            }
        }else{
            $addData['author_id'] = Yii::app()->user->id;
            $author_name = Yii::app()->user->login;

            //echo '<pre>';
            //die(var_dump(Yii::app()->user->getAttribute('pic')));
            $avaPath =  Yii::app()->user->getAttribute('pic') ?  Yii::app()->user->id . '/avatar/ '.Yii::app()->user->getAttribute('pic') : 'noimage.png';
        }




        if(!empty($_POST['Comments']) and empty($errors)){
            $comm = new Comments;

            $postData = $_POST['Comments'];
            $postData['parent'] = str_replace('num_comm', '', $postData['parent']);
            $comm->attributes = array_merge($postData, $addData);

            $comm->setAttributes(array('when_done' => 'NOW()'));
            if($comm->save()){
                //$this->sendResponse(self::STATUS_OK, $addData);



                $this->sendResponse(self::STATUS_OK, array(
                    'text'    =>  $comm->comment,
                    'id'      =>  $comm->id,
                    'parent'  =>  $comm->parent ? $comm->parent : '0',
                    'author'  =>  $author_name,
                    'date'    =>  date('g:-i A - j F, Y'),
                    'pic'     =>  $avaPath,
                ));
            }else{
                $errors = array_merge($comm->getErrors(), $errors);
            }

        }
        //$this->sendResponse(self::STATUS_OK, $errors);
        $this->sendResponse(self::STATUS_BAD_REQUEST, $errors);
    }





    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['Posts']))
        {
            $data = array_merge($_POST['Posts'], array('id_author' => Yii::app()->user->getCurrent()->id));

            $model->setAttributes($data);



            if($model->save()){
                $this->sendResponse(self::STATUS_OK, $model->attributes);
            }
        }

        $this->sendResponse(self::STATUS_BAD_REQUEST, array($model->getErrors(), $model->attributes));//return;
        //die('ok');

        //$this->render('update',array(
        //    'model'=>$model,
        //));
    }

    public function actionDelcomm(){


        $model = new Comments;


        if(!empty($_POST) and isset($_POST['id'])){
            $id = $_POST['id'];

            //Comments::model()->deleteByPk($_POST['id']);
            $family = $model->findByPk($id);
            //die('test');
            $post_id = $family->post_id;
            $family->delete();//()){

            if(empty($family->getErrors())){
                $this->sendResponse(self::STATUS_OK, array('id' =>  $id, 'count' => $family->count('post_id =?', array($post_id))));
            }else{
                $this->sendResponse(self::STATUS_BAD_REQUEST, $family->getErrors());
            }
            //}

            $this->sendResponse(self::STATUS_BAD_REQUEST, array('errors' => 'No such record'));
        }

        //$this->sendResponse(self::STATUS_NOT_FOUND);
        //$this->loadModel($id)->delete();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Posts');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Posts('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Posts']))
            $model->attributes=$_GET['Posts'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Posts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Posts::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Posts $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='posts-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
