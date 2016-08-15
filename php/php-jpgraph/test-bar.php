<?php
require_once("./jpgraph-4.0.0/src/jpgraph.php");
require_once("./jpgraph-4.0.0/src/jpgraph_bar.php");
//自定义数据
$data = array(0=>-20,1=>-10,2=>20,3=>40,4=>60,5=>90,6=>70,7=>20,8=>-20,9=>-60);
//实例化graph,并设置画布大小
$graph = new Graph(800,600);
$graph->SetScale("textint");//设置x和y轴样式
$graph->img->SetMargin(50,50,50,60);//设置画布的边界
$graph->title->Set("柱形图");
$graph->title->SetFont(FF_CHINESE);
//得到柱状图形对象
$barPlot = new BarPlot($data);
$barPlot->value->show();
$graph->xaxis->title->SetFont(FF_CHINESE);
$graph->yaxis->title->SetFont(FF_CHINESE);
$graph->xaxis->title->Set("x轴");
$graph->yaxis->title->Set("y轴");
$graph->yaxis->title->SetMargin(10);
$barPlot->SetLegend("图例");//设置图例
$graph->legend->Pos(0.5,0.8,"center","bottom");
$graph->Add($barPlot);
$barPlot->Setcolor("blue");
$graph->Stroke();

