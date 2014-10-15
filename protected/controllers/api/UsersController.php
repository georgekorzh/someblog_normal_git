<?php
class UsersController extends ApiController
{
    public $allowedActions = array(
        'signin',
        'signup',
    );
    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

    // Actions
    public function actionList()
    {
        echo 'test';
        $this->sendResponse(200);
    }
    public function actionView()
    {
    }
    public function actionSignup()
    {

        $model=new Users;


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {



            $model->attributes = $_POST['Users'];
            //$model->attributes = $_POST['Users'];
            $model->imgobj = CUploadedFile::getInstance($model,'pic');
            $finalNamePic = '';

            if($model->imgobj !== null){
                $time_pref = mktime();
                $finalNamePic = $time_pref . $model->imgobj->getName();
                $model->setAttribute('pic', $finalNamePic);
                $model->pic = $finalNamePic;
            }


            //$this->sendResponse(self::STATUS_OK, array_merge($model->attributes, array('somepic' => $model->pic)));return;
            //$this->sendResponse(self::STATUS_UNAUTHORIZED, array_merge($model->attributes, array($finalNamePic)));return;

            if($model->save()){

                if(isset($fileNamePic)){
                    $dirIMG = realpath('') . DIRECTORY_SEPARATOR . 'images'. DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR . 'avatar';

                    if(mkdir($dirIMG ,0777, true)) {
                        $model->imgobj->saveAs($dirIMG . DIRECTORY_SEPARATOR . $finalNamePic);
                    }

                }
                $this->sendResponse(self::STATUS_OK);


                //$this->redirect(array('view','id'=>$model->id));

            }
            $this->sendResponse(self::STATUS_BAD_REQUEST, array_merge($_POST['Users'], $model->getErrors()));return;
        }



    }
    public function actionSignin()
    {
        //$this->sendResponse(self::STATUS_BAD_REQUEST);
        /**/
        if (!empty($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_PW'])
            $data = array(
                'email' => $_SERVER['PHP_AUTH_USER'],
                'password' => $_SERVER['PHP_AUTH_PW'],
            );
        elseif(isset($_POST['LoginForm']))
        {

            $model = new LoginForm;

            $model->attributes = $data = $_POST['LoginForm'];

        }else{
            $data = array();
        }


        if ($model->validate() && $model->loginapi())
        {

            $identity = new UserIdentity($model->username, $model->password);

            if ($identity->authenticate() && Yii::app()->user->login($identity, $model->rememberMe ? 5*365*24*60*60 : 0))
            {
                //$this->sendResponse(self::STATUS_OK, $data);
                $this->sendResponse(self::STATUS_OK, array(

                    'token' => Yii::app()->user->getModel()->getApiToken(),
                    'user' => Users::getCurrent()->toJSON()
                ));
            }
        else
            {
                $this->sendResponse(self::STATUS_BAD_REQUEST, array('password' => 'Wrong login or password'));
            }

        }

        $this->sendResponse(self::STATUS_UNAUTHORIZED, $model->getErrors());//, $data['LoginForm']);

    }
    public function actionUpdate()
    {
    }
    public function actionDelete()
    {
    }
}
?>