<? 
include_once('./_common.php');

if($action == "play") { 
  ?>
  <!doctype html>
  <html lang="ko">
  <head><meta charset="utf-8"></head>
  <body>
  
  <div id="player">  
  </div>
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script type="text/javascript" id="www-widgetapi-script" src="https://www.youtube.com/s/player/c403842a/www-widgetapi.vflset/www-widgetapi.js" async=""></script>
  <script>
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var player;
		
        function loadPlaylist_playlist_id(list_id) {
            player.loadPlaylist({
                'list': list_id,		//이부분을 변수로 받아옴
                'listType': 'playlist',
                'index': 0,
                'startSeconds': 0,
                'suggestedQuality': 'small'
            });
        }
		
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '0',
          width: '0',
          videoId: ' ',
          events: {
          'onReady': function (event) {
            // 이 부분 재생목록 ID 수정하기 (1)★★★
          event.target.cuePlaylist({list: "PLYcsc2NXLkEOGEcSkPoudIh_JmljkEimz"});
          event.target.playVideo();
          event.target.setLoop(true);
          setTimeout(function() {
		      var called_frame = parent.document.getElementById("bgm_frame").contentWindow;
		      called_frame.player.playVideoAt(0);
	        },500);
          }
          }
        });
        player.personalPlayer = {'currentTimeSliding': false,
                                    'errors': []};
      }

      function onPlayerReady(event) {
      var player = event.target;
        // 이 부분 재생목록 ID 수정하기 (2)★★★
        // 아보카도 관리자의 재생목록 ID까지 수정해줘야 정상출력됩니다!
		  loadPlaylist_playlist_id('PLYcsc2NXLkEOGEcSkPoudIh_JmljkEimz');
      }


      function songinfo(id) {

        //곡 목록★★★

  if (id == 'ys_XM_ST-_M') {
    songtitle = 'Love Spell';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2F4v0qB%2FbtsBfL8f435%2FAsgJQm2vpI0flyU1e1kSa1%2Fimg.png';
      pointcolor = '#8f0021'
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '50% 70%';
  }

    if (id == 'WWbSMSjMCdM') {
    songtitle = 'alittlesomething';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2FFnE8w%2FbtsBfhl2jIu%2Fue5cdlfyvfbCoGHkBpM8w1%2Fimg.jpg';
      pointcolor = '#0088ad';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '';
  }
  
  if (id == '-xbPZKO67rs') {
    songtitle = 'ᵇᵉˡᵒᵛᵉᵈ';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2FcmjpBJ%2FbtsBjFey8La%2F5oqLYSzeW0N4Dg8QgpCtdk%2Fimg.png';
      pointcolor = '#ffbb0f';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '50% 80%';
  }
    if (id == 'qulrjh2bEuY') {
    songtitle = 'Drinking On A Tuesday';
    songimg = 'https://blog.kakaocdn.net/dn/C4SUl/btsDP9ZdMwn/cVipVQS7D9KBM2DhRS8MCk/img.png';
      pointcolor = '#0fb3ff';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '';
  }
      if (id == 'Roay9R57cEI') {
    songtitle = 'L.A. (+1 .818.643.6885)';
    songimg = 'https://blog.kakaocdn.net/dn/bmiIHO/btsDnvOANLU/njDJzT9gdUy3F7edzjHZ1k/img.gif';
      pointcolor = '#ff0fe3';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '43% 70%';
  }
          if (id == 'sfh8l6BQ7MI') {
    songtitle = 'TRY HARD-1+1';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2FcLOiNk%2FbtsBiTYu9zk%2FCUSW9pFKOX2k2FQZX0nwn0%2Fimg.png';
      pointcolor = '#f8ff1f';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '50% 35%';
  }

  if (id == 'olNXKOZC_nI') {
    songtitle = 'lovememore';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2FciPGJm%2FbtsBgIDBq3d%2F4GCaHcO9UhKMbM8Uw0Jc00%2Fimg.jpg';
      pointcolor = '#ba6d6d'
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '40% 80%';
  }

          if (id == 'a3bSi3i2bH4') {
    songtitle = '무아(無我)';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2Fo8XtL%2FbtsBqzyszYg%2Fx0kF7er4Q5MPqIhkWALvDk%2Fimg.png';
      pointcolor = '#565e7b';
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '40% 60%';
  }

      if (id == 'ucU_d861a9Y') {
    songtitle = 'North';
    songimg = 'https://img1.daumcdn.net/thumb/R1280x0/?scode=mtistory2&fname=https%3A%2F%2Fblog.kakaocdn.net%2Fdn%2FdDt8wl%2FbtsBffhrtWG%2FghoUOHGZ4XnVsOkQ2fHGFK%2Fimg.png';
      pointcolor = '#cccccc'
      textcolor = '#ffffff';
      backcolor = '';
      backgroundPos = '40% 60%';
  }
      //곡 목록 끝

    
  //    if (id == '') {
  //  songtitle = '';
  //  songimg = '썸네일 이미지 주소'; 없으면 유튜브 영상 썸네일이 자동 삽입됩니다
  //    pointcolor = ''; 포인트 컬러
  //    textcolor = ''; 곡 이름, 현재 재생 위치 색상... #ffffff 형식으로 넣어주세요
  //    backcolor = ''; 플레이어 배경색. 지정이 없으면 textcolor의 반대색이 됩니다
  //    backgroundPos = ''; 배경 위치 / 없으면 자동으로 중간 (50% 50%) 으로 고정.
  //    }

  // songimg가 설정되어 있지 않으면 유튜브 썸네일로, 배경 사이즈도 알맞게 수정
  if (songimg == '') {
    songimg = 'https://i.ytimg.com/vi/' + id + '/maxresdefault.jpg';
    backsize = 'cover';
  } else {
    backsize = '';
  }
  if (backcolor == ''){
    backcolor = invertColor(textcolor);
  }
}

function invertColor(hex) {
    if (hex.indexOf('#') === 0) {
        hex = hex.slice(1);
    }
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    if (hex.length !== 6) {
        throw new Error('Invalid HEX color.');
    }
    // invert color components
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    // pad each with zeros and return
    return '#' + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) {
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}


// 곡 url을 반환하여 타이틀과 색상을 받아와 변경
function songt() {
		var songindex = player.getVideoUrl();
    let searchParams = new URLSearchParams(songindex);
    var songid = searchParams.get('v');
    var music_thumb = parent.document.getElementById('music-thumb');
    songinfo(songid);

    parent.document.getElementById('songtitle').innerHTML= songtitle;
    music_thumb.style.backgroundImage= "url('" + songimg + "')";
    music_thumb.style.backgroundPosition= backgroundPos;
    if (pointcolor != '' && pointcolor != 'null') {
    parent.document.documentElement.style.setProperty(`--music-point`, pointcolor);
    }
    if (textcolor != '' && textcolor != 'null') {
    parent.document.documentElement.style.setProperty(`--music-text`, textcolor);
    }
    if (backcolor != '' && backcolor != 'null') {
    parent.document.documentElement.style.setProperty(`--music-base`, backcolor);
    }
    if (backsize == 'cover'){
      music_thumb.style.backgroundSize = backsize;
    } else if (backsize == ''){
      music_thumb.style.backgroundSize = '';
    }

    previous = parent.document.querySelector('.listmusic.active');
    if (previous) {
    previous.classList.remove('active');
    }
    nowplay = parent.document.getElementById(songid);
    nowplay.classList.add('active');

	}

  // 이전과 같은 곡인지 체크
  var check_previous = -1
  function less() {
      songnow = player.getPlaylistIndex();
      if (check_previous == -1) {
        check_previous = songnow;
        setTimeout(songt, 1000);
      } else if (check_previous == songnow) {
      } else if (check_previous != songnow) {
        songt();
        check_previous = songnow;
      }
    }
		setInterval(less, 1000);
    
    function load_list() {
		pl_list = player.getPlaylist();
    
    mslist = parent.document.getElementById('mslist');
    listDiv = [];
    pl_list.forEach((id, i) => {
      listDiv[i] = document.createElement("div");
      songinfo(id);
      listDiv[i].innerHTML = songtitle;
      listDiv[i].setAttribute("class", "listmusic");
      listDiv[i].setAttribute("id", id);
      listDiv[i].setAttribute("onclick", 'changeMusic("' + id + '")');
      mslist.appendChild(listDiv[i]);
    });
    }
    setTimeout(load_list, 2000);


    
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {

          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
      
	  </script>
  </body>
  </html>
  <? } ?>
    