<?php 
include_once("./_common.php");
include_once(G5_PATH."/head.sub.php"); 
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0); 

if (!$is_admin)
    alert('관리자만 접근 가능합니다.');
if($is_admin){
?>
<form action="<?=$board_skin_url?>/set_order_update.php" name="orders" method="post" autocomplete="off">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type="hidden" name="write_table" value="<?=$write_table?>">
<div style="max-width:600px;margin:10px auto;">
<ul> 
	<?
	$order=sql_query("select * from {$write_table} where wr_reply='' and wr_is_comment=0 order by wr_10*1 asc");
	$parent_type=$board['bo_1']?$board['bo_1']:'오리지널';
	for ($i=0;$row=sql_fetch_array($order);$i++){ ?>
		<li class="theme-box" style="margin:1px;line-height:30px;padding:0;clear:both;overflow:hidden;">
			<a href="#" onclick="$(this).siblings('div').slideToggle(); return false;">
			<span style="padding:0 5px">[<?=$parent_type?>]</span>
			<span style="padding:0 5px"><?=$row['wr_subject']?></span></a>
			<span style="padding:0 5px;"><input name="type[<?=$row['wr_id']?>]" type="text" value="<?=$row['wr_type']?>"></span>
			<span style="padding:0 5px;float:right;"><input type="text" value="<?=$row['wr_10']?>" name="order[<?=$row['wr_id']?>]" size="4" style="height:28px;line-height:26px;"></span>
			<?if($board['bo_use_category']&&$board['bo_category_list']){?>
			<select name="category[<?=$row['wr_id']?>]" style="float:right;">
				<option value="">카테고리</option>
				<?$cate=explode('|',$board['bo_category_list']);
				for($h=0;$h<count($cate);$h++){?>
					<option value="<?=$cate[$h]?>" <?=$row['ca_name']==$cate[$h] ? "selected": "";?>><?=$cate[$h]?></option>
				<?}?>
			</select><?}?>
			<input type="hidden" name="idx[]" value="<?=$row['wr_id']?>">
			<input type="hidden" name="parents[<?=$row['wr_id']?>]" value="<?=$row['wr_parent']?>">
			
		<?
			$sub=sql_query("select * from {$write_table} where wr_reply!='' and (ca_name='{$row['wr_subject']}' or wr_9='{$row['wr_id']}') and wr_id!='{$row['wr_id']}' and wr_is_comment=0 order by wr_10*1 asc");
			for ($k=0;$row2=sql_fetch_array($sub);$k++){ ?>
			<div style="padding-left:10px;clear:both;">
				<span style="padding:0 5px">[AU] [<?=$row2['wr_type']?>]</span>
				<span style="padding:0 5px"><?=$row2['wr_subject']?></span>
				<span style="padding:0 5px;"><input name="type[<?=$row2['wr_id']?>]" type="text" value="<?=$row2['wr_type']?>"></span>
				<span style="padding:0 5px;float:right;"><input type="text" value="<?=$row2['wr_10']?>" name="order[<?=$row2['wr_id']?>]" size="4" style="height:28px;line-height:26px;"></span>
				<input type="hidden" name="idx[]" value="<?=$row2['wr_id']?>">
				<input type="hidden" name="parents[<?=$row2['wr_id']?>]" value="<?=$row['wr_parent']?>">
			</div>
			
		<? } ?>
		</li>
	<? } ?>
</ul>
<br>
<button type="submit" class="ui-btn point">확인</button>
<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>" class="ui-btn">목록으로</a>
</div>	
</form>
<?}?>