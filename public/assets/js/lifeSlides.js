// 記憶迴廊 (corridor) 動畫設定
// 使用動態路徑而不是硬編碼路徑

// 計算動畫參數
let corridor_css = window.pictureNum / 4;
document.documentElement.style.setProperty('--animation-time', `${10 * corridor_css}s`);
document.documentElement.style.setProperty('--animation-move', `${-100 * corridor_css}%`);
// 1280
document.documentElement.style.setProperty('--animation-time-1280', `${12 * corridor_css}s`);
document.documentElement.style.setProperty('--animation-move-1280', `${-133.33 * corridor_css}%`);
// 768
document.documentElement.style.setProperty('--animation-time-768', `${13 * corridor_css}s`);
document.documentElement.style.setProperty('--animation-move-768', `${-200 * corridor_css}%`);
// 500
document.documentElement.style.setProperty('--animation-time-500', `${16 * corridor_css}s`);
document.documentElement.style.setProperty('--animation-move-500', `${-300 * corridor_css}%`);

// id
const container = document.getElementById("main-film-container");

// 隨機排列媒體並確保不重複
function getRandomMedia(count) {
  const mediaList = [...window.corridor_images, ...window.corridor_videos].sort(() => Math.random() - 0.5);
  return mediaList.slice(0, count);
}

// 結構
let n = 1;
let slidesArray = [];
function createSlides(mediaList, group) {
  mediaList.forEach((mediaPath) => {
    const slide = document.createElement("div");
    slide.className = `main-film-out-in-slide order-${n}`;
    n++;

    const bgImg = document.createElement("img");
    // 使用動態路徑
    bgImg.src = `${window.PET_ASSETS ? window.PET_ASSETS.imagePath : '/storage/pets/ruby-20130701/image'}/main/film/film.png`;
    bgImg.alt = "Background";

    const card = document.createElement("div");
    card.className = "main-film-out-in-slide-card";

    const cardLink = document.createElement("a");
    cardLink.classList.add(group);
    cardLink.setAttribute("data-fancybox", "film");
    
    let previewImg = "";
    if (mediaPath.endsWith(".mp4")) {
      // 视频文件路径
      const fullVideoPath = `${window.PET_ASSETS.imagePath}/main/film/photo/video/mp4/${mediaPath}`;
      cardLink.setAttribute("data-src", fullVideoPath);
      // 视频预览图路径
      const mediaName = mediaPath.split('/').pop(); // 獲取文件名
      previewImg = `${window.PET_ASSETS.imagePath}/main/film/photo/video/${mediaName.replace(".mp4", ".webp")}`;
    } else {
      // 图片文件路径
      const fullImagePath = `${window.PET_ASSETS.imagePath}/main/film/photo/${mediaPath}`;
      cardLink.setAttribute("data-src", fullImagePath);
      // 图片预览图路径（就是原图）
      const mediaName = mediaPath.split('/').pop(); // 獲取文件名
      previewImg = `${window.PET_ASSETS.imagePath}/main/film/photo/${mediaName}`;
    }
    
    const randomImg = document.createElement("img");
    randomImg.src = previewImg;
    randomImg.alt = "life slides";
    
    cardLink.appendChild(randomImg);
    card.appendChild(cardLink);
    slide.appendChild(bgImg);
    slide.appendChild(card);
    slidesArray.push(slide);
  });

  // 插入 group-1
  slidesArray.forEach((slide) => {
    container.appendChild(slide);
  });

  // 插入 group-2（複製 group-1）
  slidesArray.forEach((slide) => {
    const cloneSlide = slide.cloneNode(true);
    cloneSlide.querySelector("a").classList.replace("group-1", "group-2");
    container.appendChild(cloneSlide);
  });
}

// 確保變數已準備就緒
if (window.corridor_images && window.corridor_videos && window.pictureNum) {
  const randomMedia = getRandomMedia(window.pictureNum);
  createSlides(randomMedia, "group-1");
} else {
  console.error('記憶迴廊變數未準備就緒:', {
    corridor_images: window.corridor_images,
    corridor_videos: window.corridor_videos,
    pictureNum: window.pictureNum
  });
}
