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
<header id="header">
	<div class="fix-layout">
		<!-- 로고 영역 : PC 로고 / 모바일 로고 동시 출력 - 디자인 사용을 체크하지 않을 시, 제대로 출력되지 않을 수 있습니다. -->
		<!-- 관리자 기능을 사용하지 않고 로고를 넣고 싶을 시, < ? = $ log_data ? > 항목을 제거 하고 <img> 태그를 넣으세요. -->
		<?if($config['cf_logo_use']!='N'){?>
		<h1 id="logo">
			<a href="<?=$main_link?>">
				<?=$logo_data?>
			</a>
		</h1>
		<?}?>
		<!-- 로고를 삭제하고 싶을 경우 위의 <h1 ... </h1> 부분을 삭제하시면 됩니다 -->

		<!-- 모바일 모드에서 메뉴를 열고 닫기 할 수 있는 버튼 -->
		<a href="#gnb_wrapper" id="gnb_control_box">
			<img src="<?=G5_IMG_URL?>/ico_menu_control_pannel.png" alt="메뉴열고닫기" />
		</a>
		<script>
		$('#gnb_control_box').on('click', function() {
			$('body').toggleClass('open-gnb');
			return false;
		});
		</script>
		<!-- 모바일 메뉴 열고 닫기 버튼 종료 -->

		<div id="gnb_wrapper">
			<?
			if($config['cf_menu_content']){
			$menu_co=explode(",",$config['cf_menu_content']);
			$menu_content = get_site_content($menu_co[1]);
			echo '<div id="gnb">'.$menu_content.'</div>';
			}else{
		/**************************************************************
		----------------------------메뉴 영역 시작----------------------------
		* 원하실 경우 하단의 <div id="gnb"> ....  </div> 부분을 수정/삭제 해주세요.
		**************************************************************/?> 
			
			<div id="gnb">
				<ul id="no_design_gnb">
				<?
				
			 $sql = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '2'
                            order by me_order*1, me_id ";
                $result = sql_query($sql, false); 
				$count=sql_fetch($sql);
                $menu_datas = array();
			if($count['me_id']){ $sql = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '2'
                            order by me_order*1, me_id ";
                $result = sql_query($sql, false); 
                $menu_datas = array();

                for ($i=0; $row=sql_fetch_array($result); $i++) {
                    $menu_datas[$i] = $row;

                    $sql2 = " select *
                                from {$g5['menu_table']}
                                where me_use = '1'
                                  and length(me_code) = '4'
                                  and substring(me_code, 1, 2) = '{$row['me_code']}'
                                order by me_order*1, me_id ";
                    $result2 = sql_query($sql2);
                    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                        $menu_datas[$i]['sub'][$k] = $row2;
                    }

                }

                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue; 
					$color=$de['menu_text']['cs_value'];
					$over=$de['menu_text']['cs_etc_2'];
					if($row['me_color']) $color=$row['me_color'];
					if($row['me_over']) $over=$row['me_over'];
					$img_link='';
					if($row['me_img']){
						if($row['me_img2']){
						$img_link="<img src=\"{$row['me_img']}\" onmouseenter=\"this.src='{$row['me_img2']}'\" onmouseleave=\"this.src='{$row['me_img']}'\" alt=\"{$row['me_name']}\">";
						}
						else{
						$img_link='<img src="'.$row['me_img'].'" alt="'.$row['me_name'].'">';
						}
					}
                ?>
				<?if($member['mb_level']>=$row['me_level']){?>
                <li class="gnb_1dli <?if($i==0) echo " main";?>" >
                    <a href="<?php echo $row['me_link']?>"  target="_<?=$row['me_target']?>" class="gnb_1da" onMouseOver="this.style.color='<?=$over?>'" onMouseOut="this.style.color='<?=$color?>'" style="color:<?=$color?>;"><?php if($row['me_img']) echo $img_link; else echo $row['me_name']; ?></a>
                    
                </li>
				<?}?>
                <?php
                $i++;
                }   //end foreach $row
			}else{
			
			
			
				$bbs_list=sql_query("select bo_table,bo_subject from {$g5['board_table']} where bo_use_search='1'"); 
					$bbs_admin=sql_query("select bo_table,bo_subject from {$g5['board_table']} where bo_use_search='0'");
					for ($i=0;$bbs=sql_fetch_array($bbs_list);$i++){ 
					?>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
					</li>
				<?}unset($bbs);
					if($is_admin){
					for ($i=0;$bbs=sql_fetch_array($bbs_admin);$i++){ 
					?>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
					</li>
				<?}unset($bbs);}
			}?> 
				</ul>
			</div>
			<div id="login_box" class="txt-center"><?if ($is_member){?>
				<p class="name"><?=$member['mb_nick']?></p>
				<?if($is_admin){?><a href="<?=G5_ADMIN_URL?>" class="ui-btn admin small" target="_blank">관리자</a>
				<a href="<?php echo G5_ADMIN_URL ?>/board_form.php" class="ui-btn small">게시판생성</a><?}?>
				<?if($is_member && !$is_admin){?><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" class="ui-btn small">정보수정</a><?}?>
				<a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout" class="ui-btn small etc">로그아웃</a> 
				<?}else{?>
				<a href="<?=G5_BBS_URL?>/login.php" class="ui-btn point small">로그인</a>
				<?if($config['cf_1']){?> <a href="<?php echo G5_BBS_URL ?>/register.php" class="ui-btn small etc"><b>회원가입</b></a><?}?>
				<?}?>
			</div>
			<div id="bgm_box">
				<? include(G5_PATH."/template.bgm.php"); ?>
			</div>
			
			<? /**************************************************************
			----------------------------메뉴 영역 끝----------------------------
			**************************************************************/ }?> 
		</div>
	</div>
</header>
<!-- // 헤더 영역 -->

<section id="body">
	<div class="fix-layout"> 
<hr class="padding" />
