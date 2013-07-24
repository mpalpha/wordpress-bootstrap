<?php 
/**********************************************************
title: bootstrap css grid generator.

description: this script will generate a custom bootstrap grid stylesheet. If no name is specified it will override the original bootstrap grid styles!
default grid: 60+20*12=960 grid

example: <link href="bootstrap-grid.php?name=namespace-&col=12&cw=60&gw=20" rel="stylesheet" type="text/css">
***********************************************************/

// set file header to css
header('Content-type: text/css');
// do not cache
header('Cache-control: must-revalidate');
// check for variables
if ($_GET['col'] && $_GET['cw'] && $_GET['gw']) {
$gridName = $_GET['name'] ? $_GET['name']:'';
$gridColumns = $_GET['col'] ? $_GET['col']:12;
$gridColumnWidth = $_GET['cw'] ? $_GET['cw']:60;
$gridGutterWidth = $_GET['gw'] ? $_GET['gw']:20;
$gridRowWidth = ($gridColumns * $gridColumnWidth) + ($gridGutterWidth * ($gridColumns - 1));
$fluidGridGutterWidth = ($gridGutterWidth/$gridRowWidth) * 100;
$fluidGridColumnWidth = ($gridColumnWidth/$gridRowWidth) * 100;
$fluidGridGutterOffset = $fluidGridGutterWidth-0.08621;

/* uncomment to debug 
echo $gridName .PHP_EOL;
echo $gridColumns .PHP_EOL;
echo $gridColumnWidth .PHP_EOL;
echo $gridGutterWidth .PHP_EOL;
echo $gridRowWidth .PHP_EOL;
echo $fluidGridColumnWidth .PHP_EOL;
echo $fluidGridGutterWidth .PHP_EOL;
*/
// generate rows
$str = <<<NORMAL
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {
[class*="{$gridName}span"].hide,
.row-fluid [class*="{$gridName}span"].hide {
  display: none; }

[class*="{$gridName}span"].pull-right,
.row-fluid [class*="{$gridName}span"].pull-right {
  float: right; }

.{$gridName}row {
  margin-left: -{$gridGutterWidth}px;
  *zoom: 1; }
  .{$gridName}row:before, .{$gridName}row:after {
    display: table;
    content: "";
    line-height: 0; }
  .{$gridName}row:after {
    clear: both; }

[class*="{$gridName}span"] {
  float: left;
  min-height: 1px;
  margin-left: {$gridGutterWidth}px; }

.{$gridName}container,
.{$gridName}navbar-static-top .{$gridName}container,
.{$gridName}navbar-fixed-top .{$gridName}container,
.{$gridName}navbar-fixed-bottom .{$gridName}container {
  width: {$gridRowWidth}px; }
NORMAL;
// new line
$str.=PHP_EOL;
// generate spans
for ($i = 0; $i < $gridColumns; $i++) {
	$val++;
	$gwidth = ($val==1)?0:$gridGutterWidth;
	$cwidth+= ($gridColumnWidth+$gwidth);
	$str.= '.'.$gridName.'span'.($val) .' {width: '. $cwidth .'px;}'.PHP_EOL;
}
// generate offsets
for ($j = 0; $j < $gridColumns; $j++) {
	$val2++;
	$gwidth2 = ($val2==1) ? $gridGutterWidth*2 :$gridGutterWidth;
	$cwidth2+= ($gridColumnWidth+$gwidth2);
	$str.= '.'.$gridName.'offset'.($val2) .' {width: '. $cwidth2 .'px;}'.PHP_EOL;
}
// generate fluid rows
$str.= <<<FLUID
.{$gridName}row-fluid {
  width: 100%;
  *zoom: 1; }
  .{$gridName}row-fluid:before, .{$gridName}row-fluid:after {
    display: table;
    content: "";
    line-height: 0; }
  .{$gridName}row-fluid:after {
    clear: both; }
  .{$gridName}row-fluid [class*="{$gridName}span"] {
    display: block;
    width: 100%;
    min-height: 30px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    float: left;
    margin-left: {$fluidGridGutterWidth}%;
    *margin-left: {$fluidGridGutterOffset}%; }
  .{$gridName}row-fluid [class*="{$gridName}span"]:first-child {
    margin-left: 0; }
  .{$gridName}row-fluid .{$gridName}controls-row [class*="{$gridName}span"] + [class*="{$gridName}span"] {
    margin-left: {$fluidGridGutterWidth}%; }
FLUID;
// new line
$str.=PHP_EOL;
// generate fluid spans
for ($k = 0; $k < $gridColumns; $k++) {
	$val3++;
	$gwidth3 = ($val3==1)?0:$fluidGridGutterWidth;
	$cwidth3+= ($fluidGridColumnWidth+$gwidth3);
	$gowidth3 = ($val3==1)?0:$fluidGridGutterOffset;
	$cowidth3+= ($fluidGridColumnWidth+$gowidth3);
	$str.= '.'.$gridName.'row-fluid .'.$gridName.'span'.($val3) .' {width: '. $cwidth3 .'%;width: '. $cowidth3 .'%;}'.PHP_EOL;
}
// generate fluid offsets
for ($j = 0; $j < $gridColumns; $j++) {
	$val4++;
	$gwidth4 = ($val4==1) ? $fluidGridGutterWidth*2 :$fluidGridGutterWidth;
	$cwidth4+= ($fluidGridColumnWidth+$gwidth4);
	$gowidth4 = ($val4==1) ? $fluidGridGutterOffset*2 :$fluidGridGutterOffset;
	$cowidth4+= ($fluidGridColumnWidth+$gowidth4);
	$str.= '.'.$gridName.'row-fluid .'.$gridName.'offset'.($val4) .' {width: '. $cwidth4 .'%;width: '. $cowidth4 .'%;}'.PHP_EOL;
}
// generate end row
$str.= <<<EOD
.{$gridName}row, .{$gridName}row-fluid {
  margin-left: 0;
  overflow: hidden; }
}
EOD;
// output stylesheet
echo $str;
} else {
// show help if no variables are defined
echo <<<ERROR
/*
Please provide name, number of columns, column width, and gutter width.
example: bootstrap-grid.php?name=namespace-&col=12&cw=60&gw=20
*/
ERROR;
}
 ?>