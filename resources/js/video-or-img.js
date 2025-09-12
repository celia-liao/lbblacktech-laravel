// 隨機選擇影片或圖片
function getRandomMedia() {
  const hasVideos = header_videos.length > 0;
  const hasImages = header_imageList.length > 0;

  if (hasVideos && hasImages) {
      // 50% 機率選擇影片或圖片
      const isVideo = Math.random() < 0.5;
      if (isVideo) {
          return { type: "video", src: header_videos[Math.floor(Math.random() * header_videos.length)] };
      } else {
          return { type: "image", src: header_imageList[Math.floor(Math.random() * header_imageList.length)] };
      }
  } else if (hasVideos) {
      // 如果沒有圖片，則只能選擇影片
      return { type: "video", src: header_videos[Math.floor(Math.random() * header_videos.length)] };
  } else if (hasImages) {
      // 如果沒有影片，則只能選擇圖片
      return { type: "image", src: header_imageList[Math.floor(Math.random() * header_imageList.length)] };
  } else {
      // 如果都沒有，就回傳 null
      return null;
  }
}

function setRandomMedia() {
  const container = document.getElementById("main-media-container");
  const media = getRandomMedia();

  if (!media) {
      console.warn("沒有可用的影片或圖片");
      container.innerHTML = "<p>暫無可用媒體</p>"; // 這裡可以換成你要的預設內容
      return;
  }

  if (media.type === "video") {
      container.innerHTML = `
          <video
              src="${media.src}"
              autoplay
              muted
              loop
              playsinline
              data-aos="opacity-class"
          ></video>
      `;
  } else if (media.type === "image") {
      container.innerHTML = `
          <img
              src="${media.src}"
              alt="Random Image"
              data-aos="opacity-class"
          />
      `;
  }
}

setRandomMedia();
