<?php

namespace api\controllers;

use yii\web\Controller;
use app\models\Post;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function actionLatest()
    {
        $data = [];
		$posts = Post::getLatestPosts();
		foreach($posts as $post) {
			$t = $post->toArray();
			$data[] =$t;
		}

        return \yii\helpers\Json::encode($data);
    }

}
