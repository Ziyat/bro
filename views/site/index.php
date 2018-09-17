<?php
use \app\entities\dubious\Dubious;
use \yii\helpers\Json;
/* @var $this yii\web\View */

$this->title = 'Bank Report Systems';
?>
<div class="row">

<!--    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>-->


    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Пользователи</span>
                <span class="info-box-number"><?= $users ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">записи в базе</span>
                <span class="info-box-number"><?= $dubious ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Группы</span>
                <span class="info-box-number"><?= $groups ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-6 col-sm-12 col-xs-12">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">График сомнительные по дате сообщения</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="line-chart-date-msg" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>


    <div class="col-md-6 col-sm-12 col-xs-12">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">График сомнительные по критериям</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="bar-chart-criterion" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</div>


<?php

$dubiousDateMsg = Dubious::find()
    ->select(['date_msg','COUNT(*) AS count'])
    ->asArray()
    ->groupBy('date_msg')
    ->all();

$dubiousCriterion = Dubious::find()
    ->select(['criterion','COUNT(*) AS count'])
    ->asArray()
    ->groupBy('criterion')
    ->all();

foreach ($dubiousDateMsg as $k => $v)
{
    $dubiousDateMsg[$k]['date_msg'] = date('Y-m-d',$v['date_msg']);
}
$dubiousDateMsgJson = \yii\helpers\Json::encode($dubiousDateMsg);
$dubiousCriterionJson = \yii\helpers\Json::encode($dubiousCriterion);

$script = <<<JS
    new Morris.Line({
      // ID of the element in which to draw the chart.
      element: 'line-chart-date-msg',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: $dubiousDateMsgJson,
      // The name of the data record attribute that contains x-values.
      xkey: 'date_msg',
      // A list of names of data record attributes that contain y-values.
      ykeys: ['count'],
      // Labels for the ykeys -- will be displayed when you hover over the
      // chart.
      labels: ['Сомнительные']
    });

    new Morris.Bar({
      element: 'bar-chart-criterion',
      data: $dubiousCriterionJson,
      xkey: 'criterion',
      ykeys: ['count'],
      labels: ['Сомнительные']
    });
JS;

$this->registerJs($script);
