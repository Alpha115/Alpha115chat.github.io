<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<div class="frame-theme-BODY">
    <div class="inner">

        <section id="bo_w">
            <!-- 게시물 작성/수정 시작 { -->
            <!--onsubmit="return fwrite_submit(this);" action="<?php echo $action_url ?>"  -->
            <form name="fwrite" id="fwrite" method="post" enctype="multipart/form-data" autocomplete="off">
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
                <?php
                $option = '';
                $option_hidden = '';

                if ($is_notice || $is_html || $is_secret || $is_mail) {
                    $option = '';
                    if ($is_notice) {
                        $option .= "\n" . '<input type="checkbox" id="notice" name="notice" value="1" ' . $notice_checked . '>' . "\n" . '<label for="notice">공지</label>';
                    }

                    if ($is_secret && $member['mb_id']) {
                        if ($is_admin || $is_secret == 1) {
                            $option .= "\n" . '<input type="checkbox" id="secret" name="secret" value="secret" ' . $secret_checked . '>' . "\n" . '<label for="secret">비밀글</label>';
                        } else {
                            $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                        }
                    }
                }

                echo $option_hidden;
                ?>

                <div class="theme-form">
                    <div class="wr_header">
                        <?php if ($is_name) { ?>
                            <div><label for="wr_name">이름<strong class="sound_only">필수</strong></label>
                                <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20">
                            </div>
                        <?php } ?>
                        <div class="div_wr_pass <? if ($member['mb_id']) { ?>hide<? } ?> ">
                            <label for="wr_pass">비밀번호 <strong class="sound_only">필수</strong></label>
                            <input type="password" name="wr_pass" id="wr_pass" <? if (!$member['mb_id']) { ?>required<? } ?> class="frm_input<? if (!$member['mb_id']) { ?>required<? } ?>" maxlength="20">
                            <? if (!$member['mb_id']) { ?><br><span>*비회원은 비밀글을 작성할 수 없으며 해당 비밀번호는 글 수정/삭제시 사용됩니다.</span><? } ?>
                        </div>

                    </div>
                    <div class="wr_header">
                        <?php if ($option) { ?>
                            <?php echo $option ?>
                        <?php } ?>
                        <div id="autosave_wrapper">
                            <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255" placeholder="제목">
                        </div>
                    </div>


                    <div class="wr_content">
                        <?php if ($write_min || $write_max) { ?>
                            <!-- 최소/최대 글자 수 사용 시 -->
                            <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                        <?php } ?>
                        <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 
                        ?>
                        <?php if ($write_min || $write_max) { ?>
                            <!-- 최소/최대 글자 수 사용 시 -->
                            <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                        <?php } ?>
                    </div>

                    <div class="wr_footer">
                        <div class="wr_file">
                            <label for="bf_file">이미지 업로드</label>
                            <div class="upload_file"></div>
                            <input type="file" id="bf_file" multiple name="bf_file[]" accept=".jpg, .jpeg, .png, .gif" data-filecount="<?php echo $file_count ?> " title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                            <div class="div_img">
                                <?php for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
                                    <?php if ($is_file_content) { ?>
                                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
                                    <?php } ?>
                                    <?php if ($w == 'u' && $file[$i]['file']) { ?>
                                        <div class="img">
                                            <input type="checkbox" class="bf_file_del" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1" style="display:none"> <label for="bf_file_del<?php echo $i ?>"><img src="<? echo $file[$i]['path'] . '/' . $file[$i]['file']; ?>">
                                        </div>
                                    <?php } ?>
                                <? } ?>
                            </div>

                            <?php for ($i = 1; $is_file && $i < $file_count; $i++) { ?><input type="file" id="bf_file" multiple name="bf_file[]" accept=".jpg, .jpeg, .png, .gif" data-filecount="<?php echo $file_count ?>" class="frm_file frm_input" style="display:none"> <? } ?>
                        </div>
                        <div class="">
                            <button id="btn_submit" class="btn_submit ui-btn point" onclick="fwrite_submit(); return false;">SEND</button>
                            <a id="modal_close" href="#close" rel="modal:close" style="display:none"></a>
                        </div>
                    </div>
                </div>
            </form>

        </section>
        <!-- } 게시물 작성/수정 끝 -->
        <br /><br /><br />
    </div>
</div>
<!-- </div> -->