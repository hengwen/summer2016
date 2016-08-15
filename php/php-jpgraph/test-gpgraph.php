<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/1
 * Time: 下午5:25
 */
//引入类库
require_once('./jpgraph-4.0.0/src/jpgraph.php');
require_once('./jpgraph-4.0.0/src/jpgraph_line.php');
//自定义测试数据
$data = array(0=>21,1=>10,2=>-10,3=>38,4=>10,5=>14,6=>20,7=>26,8=>29,9=>35,10=>25);
$graph = new Graph(800,600);//得到graph对象,并设置画布大小
$graph->SetScale("textint",-30,50);//设置x和y轴的样式,以及y轴的最大值和最小值
$graph->SetY2Scale("int",-30,50);//设置画布右边y轴的样式以及最大值和最小值
$graph->img->setMargin(50,50,50,70);//设置图像的边距
$graph->SetShadow();//图像加入阴影
$graph->title->Set("xy坐标");//设置图像的标题
$graph->title->SetFont(FF_CHINESE);
$linePlot = new LinePlot($data);//得到曲线实例
$graph->Add($linePlot);//将曲线加到画布中
//设置坐标轴名称
$graph->xaxis->title->Set("Month");
$graph->yaxis->title->Set("beijing");
$graph->y2axis->title->Set("shanghai");
$linePlot->SetColor('red');//设置曲线的颜色,需要在曲线添加到画布之后设置
$linePlot->SetLegend("图例");//设置曲线的实例
//设置图例样式和坐标
$graph->legend->setlayout(LEGEND_HOR);
$graph->legend->Pos(0.5,0.8,"center","bottom");
//将图像输出到浏览器
$graph->Stroke();