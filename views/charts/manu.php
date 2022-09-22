<?php

use app\assets\ChartJsAsset;
use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;

ChartJsAsset::register($this);

$this->registerCss("
.background-color-white {
    background-color: white;
}
.max-height-chart {
    height: 250px;
}
");

$this->title = $menu->title;

?>

<h3 class="">
    <?php
    if (isset($hash)) {
        echo Html::a('<i class="fas fa-link"></i>', [
            'charts/view',
            'hash' => $hash,
        ]);
    }
    ?>
    <?= Html::encode($this->title) ?>
    <?= Html::tag('span', $submenu, ['class' => 'small']) ?>
</h3>

<br>

<?php

if ($gridDataProvider) {

    $columns = [];
    foreach ($menu->getHeadersList() as $columnName => $columnLabel) {
        $columns[] = [
            'label' => $columnLabel,
            'attribute' => $columnName,
        ];
    }

    echo GridView::widget([
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'layout' => '{items}',
        'tableOptions' => ['class' => 'table table-bordered table-striped background-color-white'],
        'dataProvider' => $gridDataProvider,
        'filterModel' => null,
        'options' => ['class' => 'table-responsive'],
        'columns' => $columns,
        'afterRow' => null,
    ]);
}
?>

<br>

<div class="row" id="charts_div">
</div>

<script>
    let charts = <?= json_encode($charts) ?>;

    function encodeURIComponent(input) {
        return input.toString()
            .replace(/\&/g, '&amp;')
            .replace(/\</g, '&lt;')
            .replace(/\>/g, '&gt;')
            .replace(/\"/g, '&quot;')
            .replace(/\'/g, '&#x27')
            .replace(/\//g, '&#x2F')
            //
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/'/g, "&#39;")
            .replace(/"/g, "&#34;");
    }

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgba(" + r + "," + g + "," + b + ",0.35)";
    };

    document.addEventListener("DOMContentLoaded", function(event) {

        function drawChartBarSingleDataset(id, title, labels, data, backgroundColor = null) {

            var backgroundColors = [];
            if (backgroundColor === null) {
                for (var i in data) {
                    backgroundColors.push(dynamicColors());
                }
            }

            var config = {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: false,
                    animation: {
                        duration: 1,
                        onComplete: function() {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function(bar, index) {
                                    var data = dataset.data[index];
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    },
                    title: {
                        display: true,
                        text: " "
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        rtl: true
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                },
                defaultFontFamily: Chart.defaults.global.defaultFontFamily = "'Sahel'",
            };
            var ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, config);
        }

        function drawChartPieSingleDataset(id, title, labels, data, backgroundColor = null) {

            if (backgroundColor === null) {
                if (data.count > 7) {
                    var backgroundColor = [];
                    for (var i in data) {
                        backgroundColor.push(dynamicColors());
                    }
                } else {
                    backgroundColor = [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ];
                }
            }

            var config = {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: false,
                    title: {
                        display: true,
                        text: " "
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        rtl: true
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                },
                defaultFontFamily: Chart.defaults.global.defaultFontFamily = "'Sahel'",
            };
            var ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, config);
        }

        Object.keys(charts).forEach(chartsKey => {
            chart = charts[chartsKey];

            let footer = '';
            if ("pie" === chart.chart_type) {
                footer += ` <div class="box-footer no-padding"> <ul class="nav nav-pills nav-stacked"> `
                Object.keys(chart.axis_x).forEach(chartAxisXKey => {
                    footer += `<li>
                        <a href="#">
                            <span class="pull-left">` + encodeURIComponent(chart.axis_x[chartAxisXKey]) + `</span>
                            <span class="pull-right">` + encodeURIComponent(chart.axis_y[chartAxisXKey]) + `</span>
                            <div class="clearfix"></div>
                        </a>
                    </li>`
                });
                footer += `</ul> </div>`;
            }

            document.getElementById("charts_div").innerHTML += `
            <div class="col-sm-` + encodeURIComponent(chart.width_12) + `">
                <div class=" box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">` + encodeURIComponent(chart.title) + `</h3>
                    </div>
                    <div class="box-body">
                        <div class="max-height-chart">
                            <canvas id="` + encodeURIComponent(chart.div_id) + `"></canvas>
                        </div>
                    </div>` + footer + ` 
                </div>
            </div>`;
        });

        Object.keys(charts).forEach(chartsKey => {
            chart = charts[chartsKey];
            if ("pie" === chart.chart_type) {
                drawChartPieSingleDataset(
                    chart.div_id,
                    chart.title,
                    chart.axis_x,
                    chart.axis_y
                );
            } else {
                drawChartBarSingleDataset(
                    chart.div_id,
                    chart.title,
                    chart.axis_x,
                    chart.axis_y
                );

            }
        });
    });
</script>