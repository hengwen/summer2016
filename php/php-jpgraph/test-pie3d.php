<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/1
 * Time: 下午9:51
 */
require './jpgraph-4.0.0/src/jpgraph.php';
require './jpgraph-4.0.0/src/jpgraph_pie.php';
require './jpgraph-4.0.0/src/jpgraph_pie3d.php';
$data = array(0=>10,1=>20,2=>10,3=>40,4=>20);
$graph = new PieGraph(600,600);
$graph->img->SetMargin(10,10,20,10);
$graph->title->Set("3D饼图");
$graph->title->SetFont(FF_CHINESE);
$pie3d = new PiePlot3D($data);
$graph->Add($pie3d);
$pie3d->SetLegends(array('PHP',"C++","C","JAVA","RUBY"));
$graph->Stroke();