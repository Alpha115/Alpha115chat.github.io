
<?
	if($config['cf_bgm']) {
?>

<nav class="bgm-player">
	<div class="bar-equalizer">
		<?
			// 이퀄라이저 바 개수
			$equal_count = 25;
			while($equal_count > 0) { echo "<i></i>"; $equal_count--; } 
		?>
	</div>
	  
	  &nbsp;
	  <a onClick="bgm_func(1)" style="cursor: pointer">|◀</a>
	  <a  id="playicon" onClick="bgm_func(2)" style="display:none;cursor: pointer;">▶</a>
	<a  id="pauseicon" onClick="bgm_func(3)" style="display:inline-block;cursor: pointer;" >■</a>
 <a onClick="bgm_func(4)" style="cursor: pointer">▶|</a>
	<a id="notShuffle" onClick="bgm_func(5)" style="display:none;cursor: pointer;">⇄</a>
	<a id="isShuffle" onClick="bgm_func(6)" style="display:inline-block;cursor: pointer;">&nbsp;∽&nbsp;</a>&nbsp;&nbsp;

</nav>



<script type="text/javascript">
var bgm_effect = null;
var set_equalizer = function () {
	$('.bar-equalizer i').each(function(i) {
		var height = Math.random() * 20 + 5;
		$(this).css('height', height);
	});
}

function fn_control_bgm(state) {
	
	if(state == 'play') { 
		$('.bar-equalizer').removeClass('stop');
		bgm_effect = setInterval(set_equalizer, 300);
	} 
	else { 
		$('.bar-equalizer').addClass('stop');
		clearInterval(bgm_effect); 
		$('.bar-equalizer i').css('height', '2px');
	}

	if($('html').hasClass('single')) { 
		return false;
	} else {
		return true;
	}
}
bgm_effect = setInterval(set_equalizer, 300);
</script>
			  <script>
		  var isplaying = 1;
		  var isShu = 1;
		  function imgToggle(){
			  var playicon = document.getElementById("playicon");
			  var pauseicon = document.getElementById("pauseicon");
			  
			  if(isplaying ==1){
				  pauseicon.style.display='none';
				  playicon.style.display='inline-block';
		
			  }else{
				  playicon.style.display='none';
				  pauseicon.style.display='inline-block';
			  }
			  isplaying++;
			  isplaying=isplaying%2;
		  }
		  
			function ShuffleToggle(){
			  var isShuffle = document.getElementById("isShuffle");
			  var notShuffle = document.getElementById("notShuffle");
			  
			  if(isShu ==1){
				  notShuffle.style.display='none';
				  isShuffle.style.display='inline-block';
		
			  }else{
				  isShuffle.style.display='none';
				  notShuffle.style.display='inline-block';
			  }
			  isShu++;
			  isShu=isShu%2;
		  }

		  function bgm_func(val){
			  var called_frame = parent.document.getElementById("bgm_frame").contentWindow;
			  //alert(called_frame.player.pauseVideo);
			  
			  if(val == 1){				//이전곡 
				  called_frame.player.previousVideo();
				  if(isplaying !=1){imgToggle();}
				  fn_control_bgm('play');
			  } 
			  else if (val == 2){		//재생 
				  called_frame.player.playVideo();
				  fn_control_bgm('play');
				  imgToggle();
			  }
			  else if (val == 3){		//정지 
				  called_frame.player.stopVideo();
				  fn_control_bgm('stop');
				  imgToggle();
			  }
			  else if (val == 4){		//다음곡 
				  called_frame.player.nextVideo();
				  if(isplaying !=1){imgToggle();}
				  fn_control_bgm('play');
			  }
			   else if (val == 5){		//셔플 
				  called_frame.player.setShuffle(false);
				   ShuffleToggle();
			  }
			   else if (val == 6){		//비 셔플 
				  called_frame.player.setShuffle(true);
			   		ShuffleToggle();
			   }
			  else {
				  					//기타 
			  }
			  
				
			 
		  }
		  
	  </script>
<? } 
?>