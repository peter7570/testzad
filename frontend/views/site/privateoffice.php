<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
<div class="site-index">                                        



<?php $dataProvider = new ActiveDataProvider([
    
  
    'query' => $model::find()->joinWith('userFriends')->where('user_friends.friend_id = :friend_id',[':friend_id'=>$id])->andWhere('user_friends.user_id != :user_id',[':user_id'=>$id]),
   
]);
?>

    <div class="body-content">          
    
    <h2><?php $_SESSION['id'] = $id; $u = $model->findById($id); echo $u->username. ' '. $id; ?> </h2>
    
        <?php if (Yii::$app->user->isGuest) { ?>
    
           die;
    
        <?php } else { 

        echo   \yii\grid\GridView::widget(
          [
             'dataProvider' => $dataProvider,
             'columns' => [
                'id',
                'username',
                'email',
              [
                'label' => 'ActionColumn',
                'format' => 'raw',
                'value' => function($model){     
                  if($model->getFriends1($id) !== NULL && ArrayHelper::isIn($model->id,$model->getFriends1($id))) {  
                    return Html::a(
                    'RemoveFriend',
                    [Url::toRoute(['site/removefriend', 'fid' => $model->id, 'uid' => $_SESSION['id']])]
                   ); 
                  } else {
                     return Html::a(
                    'AddFriend',
                  //  [Url::toRoute(['/site/addfriend/', 'fid' => $model->id, 'uid' => $id])]
                    [Url::to(['site/addfriend', 'fid' => $model->id, 'uid' => $_SESSION['id']])]
                   ); 
                  }
                }
              ],
              [
                'label' => 'ActionColumn',
                'format' => 'raw',
                'value' => function($model){    
                     return Html::a(
                    'View',
                    [Url::to(['/site/privateoffice/', 'id' => $model->id])]
                   ); 
                 
                }
              ],
              [
                'label' => 'ActionColumn',
                'format' => 'raw',
                'value' => function($model){    
                     return Html::a(
                    'Delete',
                    [Url::to(['/site/deleteuser/', 'id' => $model->id])]
                   ); 
                 
                }
              ],
            ]
          ]
        );
        
        
        } ?>
    
    

    </div>
    
    
</div>
