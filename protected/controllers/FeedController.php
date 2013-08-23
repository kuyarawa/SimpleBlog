<?php

class FeedController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $end_point = 'https://api.sandbox.paypal.com/v1/oauth2/token';

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
				'actions'=>array('index','view','order','result'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Posts']))
		{
			$model->attributes=$_POST['Posts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Posts']))
		{
			$model->attributes=$_POST['Posts'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$this->processPageRequest('page');

		$dataProvider=new CActiveDataProvider('Posts', array(
            'pagination'=>array(
                'pageSize'=>10,
                'pageVar' =>'page',
            ),
        ));

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
            ));
            Yii::app()->end();
        } else {
            $this->render('index', array(
                'dataProvider'=>$dataProvider,
            ));
        }
	}

	protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
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


	protected function actionError($value='')
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	protected function curl_req()
	{
		# code...
	}
	public function actionResult()
	{
		var_dump($_GET['token']);
		/*
			curl -v https://api.sandbox.paypal.com/v1/payments/payment/PAY-6RV70583SB702805EKEYSZ6Y/execute/ \
			-H 'Content-Type:application/json' \
			-H 'Authorization:Bearer EOjEJigcsRhdOgD7_76lPfrr45UfuI43zzNzTktUk1MK' \
			-d '{ "payer_id" : "7E7MGXCWTTKK2" }'
		*/
		$ec = $_GET['token'];
		$payer = $_GET['PayerID'];



		$model=Paypal::model()->findByPk($ec);
		var_dump($model->attributes);
		$url = 'https://api.sandbox.paypal.com/v1/payments/payment/'.$model->attributes['pay'].'/execute/';
		var_dump($url);
		//First step - get access-token
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{ "payer_id" : "'.$payer.'" }');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type:application/json",
		  	"Authorization: Bearer ".$model->attributes['access'])
		);

        //getting response from server 
        $response = curl_exec($ch); 
        $error = 'No curl errors';
     
        if (curl_errno($ch)){ 
            $error = curl_errno($ch); 
        }else{  
            curl_close($ch); 
        }

        //$response = json_decode($response);
        var_dump($response);
        var_dump($error);
	}
	//PayPal
	public function actionOrder()
	{
		$id = (int)$_GET['id'];  

		$model=Posts::model()->findByPk($id);

		//First step - get access-token
		$ch = curl_init();
		$clientId = "ATb3hhCI7V3GFoOCc5EjXudPsrtq1pCe4JcCKfYhblrpQJ2FlixoQK_bTKNi";
		$secret = "EHHWiBB6I94ATx-aCQSelzyzBjknx-9DlSe3_lMNT47SbMPLU3-6oXtVKiWn";

		curl_setopt($ch, CURLOPT_URL, $this->end_point);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        //getting response from server 
        $response = curl_exec($ch); 
        $error = 'No curl errors';
     
        if (curl_errno($ch)){ 
            $error = curl_errno($ch); 
        }else{  
            curl_close($ch); 
        }

        $response = json_decode($response);

		$data = '{
		  "intent":"sale",
		  "redirect_urls":{
		    "return_url":"http://learn.yii/feed/result/",
		    "cancel_url":"http://learn.yii/feed/result"
		  },
		  "payer":{
		    "payment_method":"paypal"
		  },
		  "transactions":[
		    {
		      "amount":{
		        "total":"'.$model->attributes['price'].'",
		        "currency":"USD"
		      },
		      "description":"Order :'.$model->attributes['title'].' Desc :'.$model->attributes['text'].'"
		    }
		  ]
		}';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type:application/json",
		  	"Authorization: Bearer ".$response->access_token, 
		  	"Content-length: ".strlen($data))
		);

		$open_transaction = curl_exec($ch); 
		$open_transaction = json_decode($open_transaction);

		$approval_url = $open_transaction->links[1]->href;

		$query = parse_url($approval_url)['query'];
		$ec_token = explode('=',$query)[2];//get &token= pos

		//add to db {ec-token} -> {pay_token, access_token}
		$pay_token = new Paypal;
		$pay_token->ec = $ec_token;
		$pay_token->pay = $open_transaction->id;
		$pay_token->access = $response->access_token;
		$pay_token->save();


		$this->render('order', array(
				'input' => $_GET,
				'error' => $error,
				'response' => $response,
				'model' => $model,
				'transaction' => $open_transaction,
				'approval' => $approval_url,
				'ec' => $ec_token,
			)
		);
	}
}
