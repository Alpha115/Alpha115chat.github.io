<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 ?>
<?if($board['bo_4']==2) {
add_stylesheet('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">', 0); ?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script> 
<?}?>
<?
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 
 
$au_type=$board['bo_1']?$board['bo_1']:'오리지널';
$slide_space=10;
$margin="5px";
$slide_loop=($board['bo_3']) ? 'true':'false';
if($board['bo_table_width']==0) $width="100%";

$cate=array();
$lists=array(); 
?> 
<? if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div>
<? } ?>
<div class="board-skin-basic" style="max-width:<?=$width?>;">
	<!-- 게시판 카테고리 시작 { -->
	<? if ($is_category && !$board['bo_4']) { ?> 
	<nav id="navi_category"> 
		<ul>
			<?php echo $category_option ?>
		</ul> 
	</nav>
	<? } ?>
	<!-- } 게시판 카테고리 끝 -->
<?
if($board['bo_4']=='1' && $is_category) { 
	$cate=explode('|',$board['bo_category_list']);
} 
for($h=0;$h<=count($cate);$h++){
	if(count($cate)>0 && $h==count($cate)) continue;
	$list_item=sql_query("select * from {$write_table} where wr_reply='' and wr_is_comment=0 order by wr_10*1 desc, wr_num");
 
	for($k=0;$row=sql_fetch_array($list_item);$k++){
		$lists[$k]=get_list($row,$board,$board_skin_url);
	}
?>
<div class="swiper-container" >
	<?if($board['bo_4']=='1' && $is_category){?><h2><?=$cate[$h]?></h2><?}?>
	<ul class="swiper-wrapper"><?
		if($board['bo_2']){
			$margins=explode(',',$board['bo_2']);
			$margin=trim($margins[0]).'px';
			if($margins[1]) $margin.=" ".trim($margins[1]).'px';
			$slide_space=trim($margins[0]);
		}
		 if(count($lists)>0){
		for ($i=0; $i<count($lists); $i++) { 
			if($is_category) {
				if(($board['bo_4']=='1' && $lists[$i]['ca_name']!=$cate[$h]) || (!$board['bo_4'] && $sca && $lists[$i]['ca_name']!=$sca)) continue;
			}

			if($lists[$i]['wr_file']>0){
				if($lists[$i]['wr_8']=='wr_1' || $lists[$i]['wr_8']==''){
					if($lists[$i]['wr_width']=='0') 
						$position="center top"; 
					else 
						$position = "-".$lists[$i]['wr_width']."px 0"; 
					$thumb_img = get_list_thumbnail($bo_table, $lists[$i]['wr_id'],0,$board['bo_gallery_height'],true,true,'custom',false,'',$lists[$i]['wr_height']);
					if($thumb_img['src'])$thumb=$thumb_img['src'];
					else $thumb="";
				}else{
					$idx=$lists[$i]['wr_8'];
					$thumb=$lists[$i][$idx];
					$position="center";
				}
			}else {
				$thumb=""; 
			}  
		?><li class="<?=$board['bo_4']==2? 'swiper-slide':'bo-list';?>" style="<?if($board['bo_4']<2){?>width:<?=$board['bo_gallery_width']+($margins[0]*2)?>px;margin:<?=$margin?>;<?}?>">
			<a href="<?=$lists[$i]['href']?>" class="ui-thumb theme-box<?if(!$thumb) echo " empty";?>
				<?if(strstr($lists[$i]['wr_option'],'secret')) echo "secret";?>" style="<?if($board['bo_4']<2){?>width:<?=$board['bo_gallery_width']?>px;<?}?>height:<?=$board['bo_gallery_height']?>px;<?if($thumb){?>background-image:url(<?=$thumb?>);background-repeat:no-repeat;background-position:<?=$position?>;background-size:cover;<?}else{?><?}?>"> 
			</a>
			<?if($board['bo_4']<2){?>
			<a href="<?=$lists[$i]['href']?>" class="ui-profile">
				<strong class="name">
				<?=$lists[$i]['wr_subject']?>
				</strong>
				<span class="type">
					<?=$lists[$i]['wr_type']?>
				</span>
			</a> 
			<?}?>
		</li><? }}?></ul>  
</div>
<?if($board['bo_4']==2){?>
	<div class="swiper-button-next" ><a href="javascript:void(0);">&gt;</a></div>
	<div class="swiper-button-prev" ><a href="javascript:void(0);">&lt;</a></div>
<?}?> 
<?}?>	
 <? if ($list_href || $is_checkbox || $write_href) { ?>
	<div class="bo_fx txt-right" style="padding: 20px 0;">
		<? if ($list_href || $write_href) { ?>
		<? if ($list_href) { ?><a href="<? echo $list_href ?>" class="ui-btn">목록</a><? } ?>
		<? if ($write_href) { ?>
		<a href="<? echo $write_href ?>" class="ui-btn point">캐릭터 등록</a><? } ?>
		<? } ?>
		<? if($admin_href){?>
		<a href="<?=$board_skin_url?>/set_order.php?bo_table=<?=$bo_table?>&write_table=<?=$write_table?>" class="ui-btn">순서 관리</a>
		<a href="<?=$admin_href?>" class="ui-btn admin">관리자</a><?}?>
	</div> 
	<? } ?>  
</div> 

<?if($board['bo_4']==2){?>

  <!-- Initialize Swiper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

  <script>
  	var win=$(window).width();
	var space = <?=$slide_space?>;
	var loop = <?=$slide_loop?>;
	var s_w;
	var temp=<?=$bo_gallery_cols?>;
	if(win<380) s_w=2;
	else if(win<450 && temp>=3) s_w=3;
	else if (win<640 && temp>=4) s_w=4;
	else s_w=<?=$bo_gallery_cols?>; 

    var swiper = new Swiper('.swiper-container', {
      slidesPerView: s_w,
      spaceBetween: space,
      slidesPerGroup: s_w,
      loop: loop,
      loopFillGroupWithBlank: false,
	  mousewheel: true,
	  direction: 'horizontal',
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });   


  $(window).on('resize',_.debounce(function(){
	var win=$(window).width();
	var temp=<?=$bo_gallery_cols?>;
	if(win<380) s_w=2;
	else if(win<450 && temp>=3) s_w=3;
	else if (win<640 && temp>=4) s_w=4;
	else s_w=<?=$bo_gallery_cols?>; 
	

	 var swiper = new Swiper('.swiper-container', {
      slidesPerView: s_w,
      spaceBetween: space,
      slidesPerGroup: s_w,
      loop: loop,
      loopFillGroupWithBlank: false,
	  mousewheel: true,
	  direction: 'horizontal',
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });   


  },300)); 
  </script>
<?}?>


<!-- } 게시판 목록 끝 -->
