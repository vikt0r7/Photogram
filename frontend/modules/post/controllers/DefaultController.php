<?php

namespace frontend\modules\post\controllers;

use frontend\models\Post;
use Yii;
use frontend\modules\post\models\forms\PostForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the Create view for the module
     * @return string
     */
    public function actionCreate()
    {
        $model = new PostForm(Yii::$app->user->identity);

        if  ($model->load(Yii::$app->request->post())){

            $model->picture = UploadedFile::getInstance($model, 'picture');
            if  ($model->save())  {
                Yii::$app->session->setFlash("success", "Post created");
                return $this->goHome();
            }

        }

        return $this->render('create',[
            'model' => $model,
        ]);

    }

    public function actionView($id)
    {
        return $this->render('view',[
           'post' => $this->findPost($id),
        ]);
    }

    public function findPost($id)
    {
        if ($user = Post::findOne($id)){
            return $user;
        }
        throw new NotFoundHttpException();

    }

}