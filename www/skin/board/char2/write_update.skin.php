<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
$customer_sql = "";
$temp_wr_id = $wr_id; 
 
if($w=='' and !$wr_9) $customer_sql .=",wr_9='{$wr_id}'";

if($w=='u' && $bf_file_del){
	for($i=0;$i<$board['bo_upload_count'];$i++){
		if(!$bf_file_del[$i]) continue;
		sql_query("update {$write_table} set {$bf_file_del[$i]}='' where wr_id='{$wr_id}'");
		if($bf_file_del[$i]=='wr_1') $common_line="and bf_no='0'";
		if($bf_file_del[$i]=='wr_2') $common_line="and bf_no='1'";
		if($bf_file_del[$i]=='wr_3') $common_line="and bf_no='2'"; 
		sql_query("delete from {$g5['board_file_table']} where wr_id='{$wr_id}' and bo_table='{$bo_table}' {$common_line}");
	}
} 

for($i=0;$i<$board['bo_upload_count'];$i++){
	if($_FILES['bf_file']['name'][$i]){
		$uimg=sql_fetch("select bf_file from {$g5['board_file_table']} where bo_table='{$bo_table}' and wr_id='{$wr_id}' and bf_no='{$i}'"); 
		$ulink=G5_DATA_URL.'/file/'.$bo_table.'/'.$uimg['bf_file'];
		$uid=$i+1;
		$customer_sql.=", wr_{$uid}='{$ulink}'";
		if($i=='0'){
			sql_query("update {$g5['board_file_table']} set bf_content='기본전신' where wr_id='{$wr_id}' and bf_no='0'");
		}
	}
}  
  
sql_query(" update {$write_table}
				set wr_id = '{$wr_id}'
				{$customer_sql}
			  where wr_id = '{$wr_id}' ");
  

?>
