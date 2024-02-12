<? 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 원본 https://codepen.io/kyoyababa/pen/OWJaoB

// 눈송이 갯수 (원본코드 100)
$snow_cnt = 100;
?>

<ul class="g-snows" id="jsi-snows">
    <?for($i=0; $i<$snow_cnt; $i++){?>
        <li></li>
    <?}?>
</ul>

<style>
.g-snows * { pointer-events:none; }
.g-snows > li {
    opacity: 0;
    position: absolute;
    top: 0;
    border-radius: 100%;
    background-color: #FFFFFF;
    background-repeat: no-repeat;
    background-size: 100% auto;
    animation-name: snow-drop;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}
<?
$snow_size_base = 30;
$browser_buffer = 50;
$left_position = 100 + $browser_buffer;
$animate_speed_base = 10000;
$minimum_falling_speed = 5000;
$animate_delay_base = 5000;
$blur_base = 5;

for($i=0; $i<$snow_cnt; $i++){ 
    $snowdrop_size = abs(rand(1, $snow_size_base) - rand(1, $snow_size_base));
?>
.g-snows > li:nth-child(<?=$i?>) {
    left: <?=abs(rand(1, $left_position) - rand(1, $left_position))?>%;
    width: <?=$snowdrop_size?>px;
    height: <?=$snowdrop_size?>px;
    animation-duration: <?=abs(rand(1, $animate_speed_base) - rand(1, $animate_speed_base))+$minimum_falling_speed?>ms;
    animation-delay: <?=abs(rand(1, $animate_delay_base))?>ms;
    filter: blur(<?=abs(rand(1, $blur_base)-rand(1, $blur_base))?>px);
}
<?}?>

@keyframes snow-drop {
<? $window_height_threshold = 1.5; ?>
    0% {
        transform: translate(0, 0);
        opacity: 0.5;
        margin-left: 0;
    }
    10% {
        margin-left: 15px;
    }
    20% {
        margin-left: 20px;
    }
    25% {
        transform: translate(0, <?=250/$window_height_threshold?>px);
        opacity: 0.75;
    }
    30% {
        margin-left: 15px;
    }
    40% {
        margin-left: 0;
    }
    50% {
        transform: translate(0, <?=500/$window_height_threshold?>px);
        opacity: 1;
        margin-left: -15px;
    }
    60% {
        margin-left: -20px;
    }
    70% {
        margin-left: -15px;
    }
    75% {
        transform: translate(0, <?=750/$window_height_threshold?>px);
        opacity: 0.5;
    }
    80% {
        margin-left: 0;
    }
    100% {
        transform: translate(0, <?=1000/$window_height_threshold?>px);
        opacity: 0;
    }
}
</style>

