<?php

use app\models\Rate;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rates';
$this->params['breadcrumbs'][] = $this->title;

// var_dump($dataProvider)
?>
<div class="rate-index">

    <h1><?= Html::encode("Тарифы") ?></h1>

    <p>
        <?= Html::a('Создать тариф', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'price',
            [
                "label"=>"Цена",
                'attribute' => 'price'
            ],
            [
                "label"=>"Название",
                'attribute' => 'name'
            ],
            // 'name:ntext',
            [
                'label' => 'Скорость',
                'format' => 'raw',
                
                'value' => function($data){
                    // var_dump($data);
                    return "<form"." class='inpForm'".">".Html::input('number', 'speed', $data->speed, ['class' => "speed", "id"=>"RateID".$data->id, "data-id" =>$data->id])."</form>";
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Rate $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>


<?php
$js = <<<JS
    let inputs = document.querySelectorAll(".speed")
    console.log(inputs)
    inputs.forEach(item => {
        item.addEventListener("change", function(e){
            let data = e.currentTarget.value;
            let id = e.currentTarget.dataset.id
            // console.log(data)
            // console.log(id)
            $.ajax({
            url: '/rate/rate',
            type: 'POST',
            dataType: 'json',
            data: {
                speed:data,
                id: id
            },
            success: function(res){
                console.log(res);
            },
        });
        })
    })
JS;
 
$this->registerJs($js);
?>