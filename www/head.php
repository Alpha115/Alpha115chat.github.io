<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php'); 

/*********** Logo Data ************/
$logo = get_logo('pc');
$m_logo = get_logo('mo');

$logo_data = "";
if(!$logo && !$m_logo)$logo_data=$config['cf_title'];
else{
if($logo)		$logo_data .= "<img src='".$logo."' ";
if($m_logo)		$logo_data .= "class='only-pc' /><img src='".$m_logo."' class='not-pc'";
if($logo_data)	$logo_data.= " />";
}
/*********************************/

$main_link=get_main_link();
?>

<!-- 헤더 영역 -->
<!-- 마우스 커서 모양 -->
<style type="text/css">* {cursor: url(https://cur.cursors-4u.net/cursors/cur-4/cur330.cur), auto !important;}</style><a href="https://www.cursors-4u.com/cursor/2010/05/04/mac-os-x-normal-select-pointer.html" target="_blank" title="Mac OS X Normal Select Pointer"><img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Mac OS X Normal Select Pointer" style="position:absolute; top: 0px; right: 0px;" /></a>

<header id="header">

    <div class="fix-layout">

        <?include(G5_PATH."/menu.php");?>

    </div>

</header>
<!-- // 헤더 영역 -->

<section id="body">
	<div class="fix-layout"> 
<hr class="padding" />
