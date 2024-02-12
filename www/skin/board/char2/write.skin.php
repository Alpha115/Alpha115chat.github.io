<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$c_name=$board['bo_1'] ? $board['bo_1'] : '오리지널';

if($w=='' || $w=='r'){
	$write['wr_width']=0;
	$write['wr_height']=0; 
	$wr_type=''; 
} 
else $wr_type=$write['wr_type'];

$category_option = "";

if($is_category && $board['bo_category_list']){

	$categories = explode("|", $board['bo_category_list']); // 구분자가 | 로 되어 있음
	for ($i=0; $i<count($categories); $i++) {
		$category = trim($categories[$i]);
		if (!$category) continue;

		$category_option .= "<option value=\"$categories[$i]\"";
		if ($category == $ca_name) {
			$category_option .= ' selected="selected"';
		}
		$category_option .= ">$categories[$i]</option>\n";
	}
}

$parent_type=$board['bo_1']? $board['bo_1'] : "오리지널";

?>


<hr class="padding">
<section id="bo_w">
	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="file" name="bf_file[]" style="display:none;">
	<?php
	$option = '';
	$option_hidden = '';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		$option = '';
		if ($is_notice) {
			//$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
		}

		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
			}
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}

		if ($is_mail) {
			$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
		}
	}

	echo $option_hidden;
	?>

	<div class="board-write theme-box"> 
		<?if($option){?>
		<dl>
			<dt>옵션</dt>
			<dd><?php echo $option ?></dd>
		</dl>
			
		<?}?> 
		<? if($is_category){?>
		<dl>
			<dt style="line-height:150%;">카테고리</dt>
			<dd><select name="ca_name" id="ca_name" required class="required" >
				<option value="">선택하세요</option>
				<?php echo $category_option ?>
			</select>  
			</dd>
		</dl>   
		<?}?>
		<dl>  
			<dt>이미지</dt>
			<dd>
			<div class="files">  
				<div class="sub"><span class="sub_tit">전신</span>
				<input type="file" name="bf_file[0]" title="전신 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input full"> 
				<input type="hidden" name="wr_1" value="<?=$w=='u' ? $write['wr_1']: ""?>"> 
				<?if($w=='u' && $write['wr_1']){?>
				<a href="<?=$write['wr_1']?>" class="ui-btn" target="_blank">전신 확인</a>
				<input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="wr_1"> <label for="bf_file_del0"> 등록된 전신 삭제</label><?}?>
				<label for="wr_8_1" class="label-right"><input type="radio" value="wr_1" name="wr_8" id="wr_8_1" class="wr_8" <?=($write['wr_8']=='wr_1'||($board['bo_upload_count']=='1'&& ($w!='u' || !$write['wr_8']))) ? "checked" : "";?>> 전신을 썸네일로 사용&nbsp;&nbsp;</label>
				<div id="crop" <?if($write['wr_8']!='wr_1'&&!($board['bo_upload_count']=='1'&& ($w!='u' || !$write['wr_8']))){?>style="display:none;"<?}?>><span class="sub_tit">크롭 지점</span> 
					X (왼쪽에서부터) <input type="text" name="wr_width" value="<?=$write['wr_width']?>" class="frm_input small"> px /
					Y (위에서부터) <input type="text" name="wr_height" value="<?=$write['wr_height']?>" class="frm_input small"> px</p>
				<?=help("* 전신을 썸네일로 사용할 경우 크롭지점을 설정합니다. 왼쪽에서부터 몇픽셀을, 위에서부터 몇픽셀을 잘라낼 것인지 숫자만 적어주세요. X지점이 0일경우 가운데로 맞춰집니다.")?>
				</div>
				</div>  
				<?if($board['bo_upload_count']>1){?><div class="sub"><span class="sub_tit">두상</span>
				<input type="file" name="bf_file[1]" title="두상 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input full">
				<input type="hidden" name="wr_2" value="<?=$w=='u' ? $write['wr_2']: ""?>"> 
				<?if($w=='u' && $write['wr_2']){?>
				<a href="<?=$write['wr_2']?>" class="ui-btn" target="_blank">두상 확인</a>
				<input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="wr_2"> <label for="bf_file_del1"> 등록된 두상 삭제</label><?}?>
				<label class="label-right" for="wr_8_2"><input type="radio" value="wr_2" name="wr_8" class="wr_8" id="wr_8_2" <?=($write['wr_8']=='wr_2'||($board['bo_upload_count']>1 && ($w!='u' || !$write['wr_8']))) ? "checked" : "";?>> 두상을 썸네일로 사용&nbsp;&nbsp;</label>
				<?=help("* 본문에는 출력되지 않습니다. 썸네일 사이즈와 다를 경우 사이즈에 맞게 늘어나거나 줄어듭니다.")?>
				</div>
				<?}?>
				<!--
				<?if($board['bo_upload_count']>2){?><div class="sub"><span class="sub_tit">흉상/기타</span>
				<input type="file" name="bf_file[2]" title="흉상 등록 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input full">
				<input type="hidden" name="wr_3" value="<?=$w=='u' ? $write['wr_3']: ""?>">
				<?if($w=='u' && $write['wr_3']){?>
				<a href="<?=$write['wr_3']?>" class="ui-btn" target="_blank">흉상 확인</a>
				<input type="checkbox" id="bf_file_del2" name="bf_file_del[2]" value="wr_3"> <label for="bf_file_del2"> 등록된 흉상 삭제</label><?}?>
				<label for="wr_8_3" class="label-right"><input type="radio" value="wr_3" name="wr_8" class="wr_8" id="wr_8_3" <?=($write['wr_8']=='wr_3') ? "checked" : "";?>>흉상을 썸네일로 사용&nbsp;&nbsp;</label>
				</div>  
				<?}?>
				-->
				<?=help("* 현재 설정된 썸네일 사이즈: {$board['bo_gallery_width']} x {$board['bo_gallery_height']}\n* 슬라이드형 목록 스타일에서는 가로사이즈를 사용하지 않습니다.")?>
			</div> 
			</dd>
		</dl>
		<dl>
			<dt>캐릭터명</dt>
			<dd><div class="wr_subject" style="margin-top: 20px;">
			<input type="text" name="wr_subject" value="<?php echo $write['wr_subject'] ?>" class="frm_input full required" size="50" maxlength="255" required>
			<?=help("본문에는 출력되지 않습니다.")?> 
			</div></dd>
		</dl>
		<?  //오리지널캐릭터 아이디값 구함
			if($w=='r' || $write['wr_reply'] ) { 
				$uid=$write['wr_9'];
			}
			else {
				$uid=$wr_id;
			}
		?>
		<input type="hidden" name="wr_9" value="<?=$uid?>">  
		<dl>
			<dt>구분</dt>
			<dd><div class="wr_type"> 
			<input type="text" name="wr_type" value="<?=$w=='u' ? $write['wr_type'] : "";?>" <?if($w=='r' || $write['wr_reply']) echo "required";?>> <?if($w!='r' && $write['wr_reply']==''){?>
			<input type="checkbox" value="1" name="wr_7" <?=($write['wr_7']&&$w!='r') ? "checked":""?>> 프로필 AU 목록에 '<?=$parent_type?>'로 표기<?}?>
			<?=help("커뮤 명칭, AU 명칭 등 구분용으로 사용할 내용을 입력해주세요.\n목록에 노출되는 프로필(오리지널)일 경우 출력되는 항목이 있습니다.(배포글 참조)")?>
			</div> 
			</dd>
		</dl>
		<dl>
			<dt>설정 및 내용</dt>
			<dd><div class="wr_content">
			<?if(!$board['bo_use_dhtml_editor']){echo help("* 게시판에서 dhtml 에디터 사용을 체크하시는것을 추천합니다.");}?>  
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
			<?php } ?>
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<div id="char_count_wrap"><span id="char_count"></span>글자</div>
			<?php } ?>
			</div>
			</dd>
		</dl> 
		<dl>
			<dt>순서</dt>
			<dd><div class="wr_10">
			<input type="text" name="wr_10" value="<?=$w=='u' ? $write['wr_10']:"";?>" >
			<?=help("* 순서는 1이 가장 처음으로 캐릭터 목록상에서는 숫자가 클수록 최신(가장 왼쪽), AU 목록상에서는 숫자가 클수록 오리지널에서 순서가 멀어집니다. \n순서를 정하지 않을 경우 먼저 등록한 순서대로 정렬됩니다.");?>
			</div>
			</dd>
		</dl>  
	</div>

	<hr class="padding" />
	<div class="btn_confirm txt-center">
		<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit ui-btn point">
		<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel ui-btn">취소</a>
	</div>
	</form>

	<script>
	<?php if($write_min || $write_max) { ?>
	// 글자수 제한
	var char_min = parseInt(<?php echo $write_min; ?>); // 최소
	var char_max = parseInt(<?php echo $write_max; ?>); // 최대
	check_byte("wr_content", "char_count");


	$(function() {
		$("#wr_content").on("keyup", function() {
			check_byte("wr_content", "char_count");
		});
	});

	<?php } ?> 
 
	function html_auto_br(obj)
	{
		if (obj.checked) {
			result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
			if (result)
				obj.value = "html2";
			else
				obj.value = "html1";
		}
		else
			obj.value = "";
	}

	function fwrite_submit(f)
	{
		<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
		 
		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": f.wr_subject.value,
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (subject) {
			alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
			f.wr_subject.focus();
			return false;
		}

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			if (typeof(ed_wr_content) != "undefined")
				ed_wr_content.returnFalse();
			else
				f.wr_content.focus();
			return false;
		}

		if (document.getElementById("char_count")) {
			if (char_min > 0 || char_max > 0) {
				var cnt = parseInt(check_byte("wr_content", "char_count"));
				if (char_min > 0 && char_min > cnt) {
					alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
					return false;
				}
				else if (char_max > 0 && char_max < cnt) {
					alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
		} 
		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	} 
	$(".wr_8").on("change",function(){
		if($(this).val()=='wr_1'){
			$("#crop").css("display","block");
		}else {
			$("#crop").css("display","none");
		}
	});
	</script>
</section>
<!-- } 게시물 작성/수정 끝 -->