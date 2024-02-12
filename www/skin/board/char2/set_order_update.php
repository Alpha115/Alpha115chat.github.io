<?php 
include_once("./_common.php");

for ($i=0;$i<count($idx);$i++){
	$k=$idx[$i];
	sql_query("update {$write_table}
		set wr_10 = '{$order[$k]}',
			wr_9 = '{$parents[$k]}',
			wr_type = '{$type[$k]}'
		where wr_id='{$k}'
	");
	if($board['bo_use_category']&&$board['bo_category_list'] && $category[$k]!=''){
		sql_query("update {$write_table} set ca_name='{$category[$k]}' where wr_9='{$k}'");
	}
}
goto_url('./set_order.php?bo_table='.$bo_table.'&write_table='.$write_table);
?>
