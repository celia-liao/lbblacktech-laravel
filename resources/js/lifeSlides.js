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

// 結構
let n = 1;
let slidesArray = [];
function createSlides(group) {
  // 使用 corridor_images 作為輪播圖（封面）
  // corridor_videos 作為點擊後顯示的媒體內容
  window.corridor_images.forEach((imagePath, index) => {
    const slide = document.createElement("div");
    slide.className = `main-film-out-in-slide order-${n}`;
    n++;

    const bgImg = document.createElement("img");
    // 使用動態路徑
    bgImg.src = '/storage/pets/image/film.png';
    bgImg.alt = "Background";

    const card = document.createElement("div");
    card.className = "main-film-out-in-slide-card";

    const cardLink = document.createElement("a");
    cardLink.classList.add(group);
    cardLink.setAttribute("data-fancybox", "film");
    
    // 獲取對應的媒體內容（可能是圖片或影片）
    const mediaPath = window.corridor_videos[index];
    
    // 封面圖使用 corridor_images
    const previewImg = `${window.PET_ASSETS.imagePath}/main/film/photo/${imagePath}`;
    
    // 根據媒體類型設置 data-src
    if (mediaPath && mediaPath.endsWith(".mp4")) {
      // 影片：設置影片路徑
      const fullVideoPath = `${window.PET_ASSETS.imagePath}/main/film/photo/video/mp4/${mediaPath}`;
      cardLink.setAttribute("data-src", fullVideoPath);
    } else if (mediaPath) {
      // 圖片：設置圖片路徑
      const fullImagePath = `${window.PET_ASSETS.imagePath}/main/film/photo/picture/${mediaPath}`;
      cardLink.setAttribute("data-src", fullImagePath);
    } else {
      // 如果沒有媒體內容，使用封面圖作為全尺寸顯示
      cardLink.setAttribute("data-src", previewImg);
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
  createSlides("group-1");
} else {
  console.error('記憶迴廊變數未準備就緒:', {
    corridor_images: window.corridor_images,
    corridor_videos: window.corridor_videos,
    pictureNum: window.pictureNum
  });
}
