<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 내용을 변환
function conv_content2($content, $html, $filter = true)
{
    global $config, $board;

    if ($html) {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // 자동 줄바꿈
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // 테이블 태그의 개수를 세어 테이블이 깨지지 않도록 한다.
        $table_begin_count = substr_count(strtolower($content), "<table");
        $table_end_count = substr_count(strtolower($content), "</table");
        for ($i = $table_end_count; $i < $table_begin_count; $i++) {
            $content .= "</table>";
        }

        $content = preg_replace($source, $target, $content);

        if ($filter)
            $content = html_purifier($content);
    } else // text 이면
    {
        // & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
        $content = html_symbol($content);

        // 공백 처리
        //$content = preg_replace("/  /", "&nbsp; ", $content);
        $content = str_replace("  ", "&nbsp; ", $content);
        $content = str_replace("\n ", "\n&nbsp;", $content);

        $content = get_text($content, 1);
    }

    return $content;
}

function autolink2($str, $bo_table, $stx = '')
{
    global $g5, $config;

    $str = ' ' . $str;

    $str = str_replace("&#039;", "'", $str);
    $str = str_replace("&#034;", "&quot;", $str);

    // 해시태그 설정
    $hash_pattern = "/\\#([0-9a-zA-Z가-힣_])([0-9a-zA-Z가-힣_]*)/";
    $str = preg_replace($hash_pattern, '<a href="?bo_table=' . $bo_table . '&amp;sfl=wr_content&amp;stx=%23$1$2" class="link_hash_tag">&#35;$1$2</a>', $str);

    return $str;
}
