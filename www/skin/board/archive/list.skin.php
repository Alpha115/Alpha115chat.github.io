<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path . '/archive.lib.php');
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/custom.css">', 1);
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/modal.css">', 1);

?>
<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round" rel="stylesheet">
<!-- plyr -->
<script src="https://cdn.plyr.io/3.6.9/plyr.js"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />

<div class="frame-theme-BODY">
	<div class="inner">

		<? if ($board['bo_content_head']) { ?>
			<div class="board-notice frm-theme-NOTICE">
				<?= stripslashes($board['bo_content_head']); ?>
			</div>
		<? } ?>

		<!-- 게시판 목록 시작 { -->
		<div id="bo_list">
			<?php if ($list_href || $is_checkbox || $write_href) { ?>
				<div class="bo_fx bottom_menu">
					<?php if ($list_href || $write_href) { ?>
						<?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="list holoback"></a><?php } ?>
						<?php if ($write_href) { ?><a href='<?php echo $write_href ?>' rel="ajax:modal" class="write writemodal holoback"></a><?php } ?>
					<?php } ?>
				</div>
			<?php } ?>

			<!-- 게시판 검색 시작 { -->
			<fieldset id="bo_sch">
				<legend>게시물 검색</legend>

				<form name="fsearch" method="get">
					<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
					<input type="hidden" name="sca" value="<?php echo $sca ?>">
					<input type="hidden" name="sop" value="and">
					<label for="sfl" class="sound_only">검색대상</label>
					<select class="sfl" name="sfl" id="sfl">
						<option value="wr_subject" <?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
						<option value="wr_content" <?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
						<option value="wr_subject||wr_content" <?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
						<option value="mb_id,1" <?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
						<option value="mb_id,0" <?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
						<option value="wr_name,1" <?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
						<option value="wr_name,0" <?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input class="stx" type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="40" maxlength="20">
					<button type="submit"><span class="material-icons">search</span></button>
				</form>
			</fieldset>
			<!-- } 게시판 검색 끝 -->

			<!-- 페이지 -->
			<?php echo $write_pages;  ?>

			<form name="fboardlist" id="fboardlist" method="post">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="spt" value="<?php echo $spt ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="sst" value="<?php echo $sst ?>">
				<input type="hidden" name="sod" value="<?php echo $sod ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<input type="hidden" name="sw" value="">

				<div class="board-list">
					<?php for ($i = 0; $i < count($list); $i++) {
						include "$board_skin_path/inc.list_main.php";

						// 비회원 글임(비회원은 비밀글작성이 불가능하기때문에 잠그면X)/자신의 글임/관리자임
						$prm = !$list[$i]['mb_id'] || $member['mb_id'] == $list[$i]['mb_id'] || $is_admin;

						// echo 'check_password: ' . check_password(get_cookie('read_' . $list[$i]['wr_id']), $list[$i]['wr_password']);
						$is_open = check_password(get_cookie('read_' . $list[$i]['wr_id']), $list[$i]['wr_password']) || $prm;
					?>
						<div class="bo_item bg-<?= $i % 2 ?><?php if ($list[$i]['is_notice']) echo "bo_notice";
															if ($list[$i]['wr_reply']) echo " reply"; ?>" data-index="<?= $i ?>">

							<div class="div_thumb article-thumb">
								<!-- <span class="date
								<?
								if (strpos($list[$i]['datetime2'], "-") !== false) {
									$date = str_replace("-", "<br>", $list[$i]['datetime2']);
								?>"> <? echo $date;
									} else {
										$date = $list[$i]['datetime2'];
										?> new"> <? echo $date;
												} ?>
								</span> -->
							</div>
							<div class="div_info article-info">
								<div class="div_subject">
									<div>
										<span class="hologram">
											<?php echo $list[$i]['subject'] ?>
										</span>

										<?php

										if ($list[$i]['icon_new']) { ?>
											<span class="material-icons-outlined">
												fiber_new
											</span>
										<? }
										if (strstr($list[$i]['wr_option'], 'secret') && !$is_admin && !$is_open) {
										?> <span class="material-icons-outlined sm">
												lock
											</span>
										<? } ?>
										<span class="subinfo"><? echo $list[$i]['datetime2'] ?></span>
										<span class="subinfo"><?php echo $list[$i]['name'] ?></span>
									</div>

									<div class="co-footer">
										<div class="bo_v_com" style="text-align: right;">

											<?php

											if ($reply_href) { ?><a href="<?php echo $reply_href ?>" rel="ajax:modal" class="re replymodal holoback"></a><?php } ?>

											<?php

											if (($member['mb_id'] && ($member['mb_id'] == $list[$i]['mb_id'])) || $is_admin) { ?>
												<? if ($delete_href) { ?>
													<a href="<?php echo $delete_href ?>" onclick="del_archive(this.href); return false;" class="del holoback"></a>
												<? } ?>
												<? if ($update_href) { ?>
													<a href="<?php echo $update_href ?>" class="mod memberModmodal holoback" rel="ajax:modal"></a>
												<? } ?>
											<? } else if ($member['mb_id']) { ?>

											<? }
											// 비회원
											else { ?>
												<? if ($delete_href) { ?>
													<a href="<?php echo $delete_href ?>" class="del delmodal holoback" rel="ajax:modal"></a>
												<? } ?>
												<? if ($update_href) { ?>
													<a href="<?php echo $update_href ?>" class="mod modmodal holoback" rel="ajax:modal"></a>
												<? } ?>
											<? } ?>

										</div>
									</div>
								</div>
								<div>
									<div class="div_content">
										<div class="div_text">
											<?php
											if (strstr($list[$i]['wr_option'], 'secret') && !$is_admin && !$is_open) {
											?>
												<fieldset class="field_password">
													<input type="password" name="wr_pass" id="wr_pass_<?= $i ?>" value="" placeholder="PASSWORD" />
													<button class="hologram" onclick="secretSubmit(<?= $list[$i]['wr_id'] ?> , <?= $i ?>)"><span class="material-icons-round">
															arrow_right_alt
														</span></button>
												</fieldset>
										</div>
									<? } else { ?>
										<? if (strstr($list[$i]['wr_option'], 'secret')) { ?>
											<span style="color: #efb04e;">[SECRET]</span><br />
										<? }
												$list[$i]['wr_content'] = conv_content2($list[$i]['wr_content'], 0, 'wr_content');

												$list[$i]['wr_content'] = autolink2($list[$i]['wr_content'], $bo_table, $stx);

												$regex = '~(?:http|https|)(?::\/\/|)(?:www.|)(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*~i';

												$list[$i]['wr_content'] =  preg_replace($regex, '<div class="plyr"><div class="player" data-plyr-provider="youtube" data-plyr-embed-id="$1"></div></div>', $list[$i]['wr_content']);

												// 링크 설정
												/* 하이퍼링크 기능을 사용하지 않기를 원하시는 분은 이 줄 아래부터 */
												$list[$i]['wr_content'] = preg_replace("/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET=\"{$config['cf_link_target']}\">\\2</A>", $list[$i]['wr_content']);
												$list[$i]['wr_content'] = preg_replace("/(^|[\"'\s(])(www\.[^\"'\s()]+)/i", "\\1<A HREF=\"http://\\2\" TARGET=\"{$config['cf_link_target']}\">\\2</A>", $list[$i]['wr_content']);
												/* 이 줄 위까지의 코드를 모두 삭제해주세요 */


										?> <?= $list[$i]['wr_content'] ?>
									</div>
									<?php $files = get_file($bo_table, $list[$i]['wr_id']);
												if ($files) { ?>
										<div class="div_img">
											<? for ($j = 0; $j < count($files) - 1; $j++) {
														if ($files[$j]['file']) {
															$src = $files[$j]['path'] . '/' . $files[$j]['file'];
														}
											?>
												<? if ($src) { ?>
													<div class="img">
														<img src="<? echo $src ?>" />
													</div>
												<? } ?>
											<? } ?>
										</div>
									<? } ?>
									<? echo $secret_msg; ?>
								<? } ?>
								</div>

							</div>
						</div>
				</div>
			<?php } ?>
			<?php if (count($list) == 0) {
				echo '<tr><td colspan="' . $colspan . '" class="empty_table">게시물이 없습니다.</td></tr>';
			} ?>
		</div>

		</form>

	</div>

	<?php if ($is_checkbox) { ?>
		<noscript>
			<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
		</noscript>
	<?php } ?>

	<!-- 페이지 -->
	<?php echo $write_pages;  ?>



	<?php if ($is_checkbox) { ?>
		<script>
			function all_checked(sw) {
				var f = document.fboardlist;

				for (var i = 0; i < f.length; i++) {
					if (f.elements[i].name == "chk_wr_id[]")
						f.elements[i].checked = sw;
				}
			}

			function fboardlist_submit(f) {
				var chk_count = 0;

				for (var i = 0; i < f.length; i++) {
					if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
						chk_count++;
				}

				if (!chk_count) {
					alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
					return false;
				}

				if (document.pressed == "선택복사") {
					select_copy("copy");
					return;
				}

				if (document.pressed == "선택이동") {
					select_copy("move");
					return;
				}

				if (document.pressed == "선택삭제") {
					if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
						return false;

					f.removeAttribute("target");
					f.action = "./board_list_update.php";
				}

				return true;
			}

			// 선택한 게시물 복사 및 이동
			function select_copy(sw) {
				var f = document.fboardlist;

				if (sw == "copy")
					str = "복사";
				else
					str = "이동";

				var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

				f.sw.value = sw;
				f.target = "move";
				f.action = "./move.php";
				f.submit();
			}
		</script>
	<?php } ?>
	<!-- } 게시판 목록 끝 -->
	<div class="img_modal">
		<div class="modalBox">
		</div>
	</div>
</div>
</div>


<script>
	var avo_board_skin_url = "<?= $board_skin_url ?>";
	var bo_table = "<?= $bo_table ?>";

	$(function() {
		initListPage();
	})

	function initListPage() {
		imgModal();
		$(".player").each(function(index, item) {
			initPlayer(item);
		});
		$(".writemodal, .memberModmodal, .replymodal").on("click", function(event) {
			event.preventDefault();
			$.ajax({
				url: $(this).attr('href'),
				dataType: "html",
				success: function(data, textStatus, jqXHR) {
					var bodyData = $($.parseHTML(data)).filter("#body");
					if (bodyData.length == 0) {
						bodyData = data;
					}
					$(bodyData).appendTo('#body').modal().on($.modal.AFTER_CLOSE, function(modal) {
						$(this).remove();
					});
					initWriteForm();
				},
				error: function(jqXHR, textStatus, errorThrown) {}
			});
			return false;
		});

		$('.modmodal, .delmodal').on("click", function(event) {
			event.preventDefault();
			this.blur();
			$.get($(this).attr("href"), function(html) {
				var bodyData = $($.parseHTML(html)).filter("#password_box");
				if (bodyData.length == 0) {
					bodyData = html;
				}
				$(bodyData).appendTo("#body").modal().on($.modal.AFTER_CLOSE, function(modal) {
					$(this).remove();
				});;
			});
			return false;
		});
	}

	function del_archive(href) {
		if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
			$.ajax({
				url: href,
				type: "GET",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				success: function(data) {
					$('#body').children().remove();
					var bodyData = $($.parseHTML(data)).filter("#body");
					if (bodyData.length == 0) {
						bodyData = data;
					}
					$('#body').hide().replaceWith(bodyData).fadeIn(0);
					initListPage();
				},
				error: function(xhr, status) {
					alert(xhr + " : " + status);
				}
			});
		} else {
			return false;
		}
	}


	function secretSubmit(id, idx) {
		var f = new FormData();
		f.append("bo_table", bo_table);
		f.append("wr_id", id);
		f.append("wr_pass", $("#wr_pass_" + idx).val());

		$.ajax({
			url: avo_board_skin_url + "/password.php",
			type: "POST",
			data: f,
			dataType: "json",
			async: false,
			cache: false,
			processData: false,
			contentType: false,
			success: function(data) {
				$("#fboardlist")[0].reset();
			},
			error: function(xhr, status) {
				console.log("error");
				console.log(JSON.stringify(xhr));
			}
		});
	}

	function acyncMovePage(url) {
		var ajaxOption = {
			url: url,
			async: false,
			type: "POST",
			dataType: "html",
			cache: false,
			success: function(data) {
				$('#body').children().remove();
				var bodyData = $($.parseHTML(data)).filter("#body");
				if (bodyData.length == 0) {
					bodyData = data;
				}
				$('#body').hide().replaceWith(bodyData).fadeIn(0);
				initListPage();
			},
			error: function(xhr, status) {
				console.log(JSON.stringify(xhr));
			}

		};
		$.ajax(ajaxOption);
	}

	function imgModal() {
		$(".div_img .img img").click(function() {
			let img = new Image();
			img.src = $(this).attr("src")
			$('.img_modal .modalBox').html(img);
			$(".img_modal").show();
		});
		$(".img_modal").click(function(e) {
			$(".img_modal").fadeToggle(100);
		});
	}

	function initPlayer(item) {
		return new Plyr(item, {
			controls: ['play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
			invertTime: false,
			keyboard: {
				focused: false,
				global: false
			},
			autoplay: false,
			volume: 0.5,
			muted: false,
			resetOnEnd: true,
			clickToPlay: true,
			fullscreen: {
				enabled: false
			},
			loop: {
				active: true
			},
			listeners: {
				seek: function customSeekBehavior(e) {
					//e.preventDefault();
					//alert('변경 불가능');
					//return false;
				}
			}
		});

		player.on('timeupdate', function(e) {});

		player.on('ended', function(e) {
			// console.log(e.detail.plyr);
		});

	}
</script>

<script>
	let list_href = "./board.php?bo_table=<?php echo $bo_table ?>&page=<?php echo $page ?>"

	function initWriteForm() {
		$("#bf_file").on("change", function(e) {
			if (this.files) {
				$(".upload_file").html("");
				for (i = 0; i < this.files.length; i++) {
					var reader = new FileReader();
					reader.onload = function(e) {
						$(".upload_file").append(
							"<div class='img'><img src='" + e.target.result + "'></div>"
						);
					}
					reader.readAsDataURL(this.files[i]);
				}
			}
		});

		$("#secret").on("click ", function() {
			if (this.checked) {
				$(".div_wr_pass").removeClass("hide");
				$("#wr_pass").addClass("required");
				$("#wr_pass").attr("required", true);
			} else {
				$(".div_wr_pass").addClass("hide");
				$("#wr_pass").removeClass("required");
				$("#wr_pass").removeAttr("required");
			}
		})

		$(".bf_file_del").on("click", function() {
			if (this.checked) {
				$(this).parent().addClass("selected");
			} else {
				$(this).parent().removeClass("selected");
			}
		});
		<?php if ($write_min || $write_max) { ?>
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

		function html_auto_br(obj) {
			if (obj.checked) {
				result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
				if (result)
					obj.value = "html2";
				else
					obj.value = "html1";
			} else
				obj.value = "";
		}
	}

	function fwrite_submit() {
		var f = $("#fwrite")[0];
		if (f.bf_file[0].files.length > $(f.bf_file[0]).data("filecount")) {
			alert("파일 첨부 개수를 초과했습니다.");
			return false;
		}
		var result = true;
		$(f.bf_file[0].files).each(function(idx, file) {
			if (file != "") {
				var ext = file.name.split('.').pop().toLowerCase();
				if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif']) == -1) {
					result = false;
					alert('jpg, jpeg, png, gif 파일만 업로드 할 수 있습니다.');
					return false;
				} else {
					result = true;
				}
			}
		});
		if (!result) {
			return false;
		}
		if ($("#wr_name").val() == "" ||
			$("#wr_subject").val() == "" ||
			$("#wr_content").val() == "") {
			alert("폼을 모두 채우신 후 등록 버튼을 눌러 주세요.");
			return false;
		}
		if (!$(".div_wr_pass").hasClass("hide") && $("#wr_pass").val() == "") {
			alert("비밀번호를 입력해 주세요.");
			return false;
		} else if ($(".div_wr_pass").hasClass("hide")) {
			$("#wr_pass").val("");
		}
		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url + "/ajax.filter.php",
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
			alert("제목에 금지단어('" + subject + "')가 포함되어있습니다");
			f.wr_subject.focus();
			return false;
		}

		if (content) {
			alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
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
					alert("내용은 " + char_min + "글자 이상 쓰셔야 합니다.");
					return false;
				} else if (char_max > 0 && char_max < cnt) {
					alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
					return false;
				}
			}
		}


		document.getElementById("btn_submit").disabled = "disabled";

		$.ajax({
			url: g5_bbs_url + "/write_update.php",
			type: "POST",
			data: new FormData(f),
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			cache: false,
			success: function(data) {
				$("#fwrite")[0].reset();
				$('#modal_close').get(0).click();
				acyncMovePage(list_href);
			},
			error: function(xhr, status) {
				// console.log(xhr.responseText);
				$('.modal').children().remove();
				$('.modal').hide().replaceWith(xhr.responseText).fadeIn(0);
				location.href = list_href;
			}
		});
	}
</script>

<script>
	function passformSubmit(url) {
		var f = $("#fboardpassword")[0];

		$.ajax({
			url: url,
			type: "POST",
			data: new FormData(f),
			dataType: "html",
			async: false,
			cache: false,
			processData: false,
			contentType: false,
			success: function(data) {
				$("#fboardpassword")[0].reset();
				if (f.w.value == "u") {
					$('.modal').children().remove();
					var bodyData = $($.parseHTML(data)).filter("#body");
					if (bodyData.length == 0) {
						bodyData = data;
					}
					$('.modal').hide().empty().append(bodyData).fadeIn(0);
					$(".modal").removeAttr("id");

				} else if (f.w.value == "d") {
					$('#modal_close').get(0).click();
					acyncMovePage(list_href);
				}
			},
			error: function(xhr, status) {
				console.log("error");
				console.log(JSON.stringify(xhr));
			}
		});
	}
</script>