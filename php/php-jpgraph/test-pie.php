<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/1
 * Time: 下午9:35
 */
require './jpgraph-4.0.0/src/jpgraph.php';
require './jpgraph-4.0.0/src/jpgraph_pie.php';
$data = array(1=>10,2=>20,3=>50,4=>20);
$graph = new PieGraph(600,600);
$graph->SetMargin(50,50,60,80);
$graph->title->SetFont(FF_CHINESE);
$graph->title->Set('饼图');
$pie = new PiePlot($data);
$pie->SetLegends(array("php","java","perl","c++"));
$graph->legend->Pos(0.3,0.78,"left","top");
$graph->Add($pie);
$graph->Stroke();
