const musicButton = document.querySelector(".music-button");
const musicUpButton = document.querySelector(".music-up");
const musicDownButton = document.querySelector(".music-down");
const songTitle = document.querySelector(".function-content-name .marquee-content");
const audio = new Audio();
const videos = document.querySelectorAll("video"); // 偵測所有影片

// **歌曲播放清單**
const musicBasePath = window.location.origin + '/assets/music/mp3';
const songs = [
  { title: "Whispering Memories", src: `${musicBasePath}/Whispering Memories.mp3` },
  { title: "Embrace Reminiscence Melancholy", src: `${musicBasePath}/Embrace Reminiscence Melancholy.mp3` },
  { title: "Gentle Solitude", src: `${musicBasePath}/Gentle Solitude.mp3` },
  { title: "Heartfelt Solitude", src: `${musicBasePath}/Heartfelt Solitude.mp3` },
  { title: "Reminiscence Farewell Pawprints", src: `${musicBasePath}/Reminiscence Farewell Pawprints.mp3` },
].sort(() => Math.random() - 0.5); // 隨機排序

let currentSongIndex = 0;
let isPlaying = false;
let wasPlayingBeforeBlur = false; // 記錄離開頁面前是否正在播放

function loadSong(index) {
    audio.src = songs[index].src;
    audio.currentTime = 0;
    audio.volume = 0.5; // 音量
    audio.loop = true; // 循環播放
    songTitle.innerText = songs[index].title;
    checkTitleOverflow();
}

loadSong(currentSongIndex);

const musicButtonPlay = document.querySelector(".music-button-play");
const musicButtonPause = document.querySelector(".music-button-pause");

musicButton.addEventListener("click", () => {
  if (isPlaying) {
    audio.pause();
    musicButtonPlay.style.display = "flex";
    musicButtonPause.style.display = "none";
  } else {
    audio.play();
    musicButtonPlay.style.display = "none";
    musicButtonPause.style.display = "flex";
  }
  isPlaying = !isPlaying;
});

musicUpButton.addEventListener("click", () => {
  currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
  loadSong(currentSongIndex);
  if (isPlaying) audio.play();
});

musicDownButton.addEventListener("click", () => {
  currentSongIndex = (currentSongIndex + 1) % songs.length;
  loadSong(currentSongIndex);
  if (isPlaying) audio.play();
});

function checkTitleOverflow() {
  const title = songTitle.innerText;
  if (title.length > 10) {
    songTitle.style.animation = "marquee 15s linear infinite";
  } else {
    songTitle.style.animation = "none";
  }
}

// 監聽頁面
if (window.innerWidth <= 768) {
  document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
      wasPlayingBeforeBlur = isPlaying; // 記錄當前播放狀態
      audio.muted = true; // 靜音
    } else {
      audio.muted = false; // 取消靜音
    }
  });
}

// 監聽一般影片播放
videos.forEach((video) => {
  video.addEventListener("play", () => {
    audio.volume = 0.1; // 影片播放時音樂靜音
  });
  video.addEventListener("ended", () => {
    audio.volume = 0.5; // 影片結束時恢復音樂音量
  });
});

// 監聽 "握手" 按鈕點擊時恢復音樂音量
const handButton = document.querySelector(".hand");

if (handButton) {
  handButton.addEventListener("click", () => {
    audio.volume = 0.5; // 恢復音量
  });
}


document.addEventListener("videoSelected", (event) => {
  const selectedVideo = event.detail;

  const videoElement = document.querySelector(".main-video-area video");

  if (videoElement) {
    videoElement.addEventListener("play", () => {
      if (!selectedVideo.sound) {
        audio.volume = 0.5; // 無聲影片播放時，恢復音樂音量
      }
    });
  }
});





// 監聽 Fancybox 內的影片播放與靜音控制
const observer = new MutationObserver(() => {
  const fancyboxVideos = document.querySelectorAll(".fancybox__html5video");
  fancyboxVideos.forEach((video) => {
    video.addEventListener("play", () => {
      audio.volume = 0.1; // 燈箱內影片播放時靜音背景音樂
    });
  });
});

observer.observe(document.body, { childList: true, subtree: true });

// 監聽 Fancybox 燈箱關閉或左右切換事件，恢復音量
const fancyboxObserver = new MutationObserver(() => {
  if (!document.querySelector(".fancybox__container")) {
    audio.volume = 0.5; // 確保燈箱完全關閉後恢復音量
  } else {
    const activeVideo = document.querySelector(".fancybox__slide.is-selected .fancybox__html5video");
    if (!activeVideo) {
      audio.volume = 0.5; // 如果當前頁面沒有播放影片則恢復音樂音量
    }
  }
});

fancyboxObserver.observe(document.body, { childList: true, subtree: true });

// 動態插入 CSS
const style = document.createElement("style");
style.innerHTML = `
@keyframes marquee {
  0% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}
`;
document.head.appendChild(style);

loadSong(currentSongIndex);