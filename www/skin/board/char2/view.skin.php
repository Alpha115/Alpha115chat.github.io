<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
 
if($board['bo_table_width']==0) $width="100%";   
$parent_type=$board['bo_1']?$board['bo_1']:'오리지널';
// 동일캐릭터 wr_9 묶음, au명은 wr_type 사용, 캐릭터명은 wr_subject 사용. 

$allow_body=450;
$content_width=400;
if($board['bo_5']) $conts=explode("|",$board['bo_5']);
if($conts[0]) $allow_body=trim($conts[0]);
if($conts[1]) $content_width=trim($conts[1]);

$rel=sql_fetch("select wr_id from {$write_table} where wr_9='{$view['wr_9']}' and wr_id!={$view['wr_9']} order by wr_10*1");
$relate=sql_query("select wr_id, wr_type from {$write_table} where wr_9='{$view['wr_9']}' and wr_id!={$view['wr_9']} order by wr_10*1, wr_reply");
$or_link = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$view['wr_9'].$qstr; // @211117
$parent=sql_fetch("select wr_id, wr_type, wr_7 from {$write_table} where wr_id='{$view['wr_9']}' and wr_is_comment=0");
$cl_no=sql_query("select * from {$write_table} where wr_is_comment=1 and wr_parent='{$wr_id}' and wr_content='옷장' order by wr_10*1 ");
$cl=array();
$idx=0;
for($i=0;$clo=sql_fetch_array($cl_no);$i++){
	$cl[$idx]=$clo; 
	$idx++;
}?> 
<div class="board-viewer">

<div id="body_img" class="body_img txt-center">
	<?if($view['wr_1']){?>
	<div id="body_0" class="body-img"><img src="<?=$view['wr_1']?>" onclick="window.open(this.src);"></div>
	<?}?>
	<? 
	for($k=0;$k<count($cl);$k++){
		$files=get_file($bo_table,$cl[$k]['wr_id']);
		$filelink=G5_DATA_URL.'/file/'.$bo_table.'/'.$files[0]['file']; 
		?>
		<div id="body_<?=$k+1?>" class="body-img" style="display:none;">
			<img src="<?=$filelink?>" onclick="window.open(this.src);">
		</div>
	<?} ?> 
<?if($rel['wr_id'] || count($cl)>0){?>
<a href="#" onclick="$(this).next().slideToggle();return false;" id="links-box-open" class="ui-btn small full">AU/옷장</a><?}?>
<div class="links-box">
	<div id="rel_link" class="ui-links">
		<ul> 	
		<?if($rel['wr_id']){ //@211117 ?>
			<li><a href="<?=$or_link?>" class="rel <?=$view['wr_9']!=$wr_id ? ' txt-default': '';?>"><?=($parent['wr_type']&&!$parent['wr_7']) ? $parent['wr_type']: $parent_type?></a></li>  
			<?for($k=0;$re=sql_fetch_array($relate);$k++){
				$link = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$re['wr_id'].$qstr;?>
				<li><a href="<?=$link?>" class="rel <?=$re['wr_id']!=$wr_id ? ' txt-default': '';?>"><?=$re['wr_type'] ? $re['wr_type'] : $parent_type;?></a></li>
			<?}?>
		<?}?>
		</ul>
	</div>
	<div id="clo_link" class="ui-links">
	<ul>
	<?if(count($cl)>0){?><li><a href="#body_0" class="clo" id="clo_0">기본전신</a></li><?}?>
	<?
	for($h=0;$h<count($cl);$h++){
		$file=get_file($bo_table,$cl[$h]['wr_id']);
		$file_link=G5_DATA_URL.'/file/'.$bo_table.'/'.$file[0]['file'];
	?>
		<li><a href="#body_<?=$h+1?>" class="clo txt-default" id="clo_<?=$h+1?>"><?=$file[0]['content']?></a></li>
		
	<?} ?>
	</ul>
	</div>
</div>
</div>
<div class="contents"> 
	<div class="content-wrap">
	<!-- 본문 내용 시작 { -->
	<div id="bo_v_con"><? echo get_view_thumbnail($view['content']); ?></div>
	<?//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
	<!-- } 본문 내용 끝 -->

	<?
	// 코멘트 입출력
	include_once(G5_BBS_PATH.'/view_comment.php');
	?>
	</div> 
<!-- 링크 버튼 시작 { -->
	<div id="bo_v_bot">
	<? ob_start(); ?> 
	<div class="bo_v_com">
		<a href="<? echo $list_href ?>" class="ui-btn left">목록</a>
		<? if ($update_href) { ?><a href="<? echo $update_href ?>" class="ui-btn">수정</a><? } ?>
		<? if ($delete_href) { ?><a href="<? echo $delete_href ?>" class="ui-btn admin" onclick="del(this.href); return false;">삭제</a><? } ?>  
		<? if ($view['wr_reply']=='' && $view['mb_id']==$member['mb_id']) { ?><a href="<? echo $reply_href ?>" class="ui-btn"><?=$view['wr_subject']?> AU 등록</a><? } ?>
		<? if ($write_href) { ?><a href="<? echo $write_href ?>" class="ui-btn point">캐릭터 등록</a><? } ?>
	</div>
	<?
	$link_buttons = ob_get_contents();
	ob_end_flush();
	?>
</div> 
<!-- } 링크 버튼 끝 -->    
</div>
</div> 
<script> 

function board_move(href)
{
	window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
} 
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});

$("#clo_link a").click(function(){
	var idx=$(this).attr("href");
	$(".clo").addClass("txt-default");
	$(this).removeClass("txt-default");
	$(".body-img").fadeOut(300);
	$(idx).delay(330).fadeIn(300);
	return false;
}); 

// 레이아웃 셋팅 - 반응형
viewer_setting();

// 화면 사이즈가 변경 될 시, 레이아웃 셋팅 실행

$(window).resize(function() { viewer_setting(); });
 
function viewer_setting() {
	var h=$("header").outerHeight();
	var f=$("footer").outerHeight();
	var w=$(window).height();
	var off=$(".board-viewer").offset().top;
	if(h>=w) h=0;
	
	var content_height=w-f-off;

	var allow_body=<?=$allow_body?>;
	var content_width =<?=$content_width?>; 
	var viewer_width= $('.board-viewer').outerWidth();
	var body_width = Math.floor(viewer_width - content_width ); 
	if(body_width<allow_body) {
		$('.board-viewer').addClass('clear'); 
	} else {
		$('.board-viewer').removeClass('clear').css('height',content_height);
		$('#body_img').css('width',body_width+'px');  
		$('.board-viewer .contents').css('width',content_width+'px');  
	} 
};
</script>
<!-- } 게시글 읽기 끝 --> 