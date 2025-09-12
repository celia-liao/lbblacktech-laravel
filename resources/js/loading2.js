const loadingOverlay = document.querySelector(".loading-overlay");

let isTimeOut = false; // 是否已經過了兩秒
let isLoad = false; // 是否已經完全載入
let hasRemove = false; // 是否已經移除loading

// 禁止滾動
function disableScroll() {
  document.body.style.overflow = "hidden";
  document.body.style.position = "fixed";
  document.body.style.width = "100%";
  
  // 禁止滑鼠滾動
  window.addEventListener("wheel", preventScroll, { passive: false });

  // 禁止觸控滾動（手機）
  window.addEventListener("touchmove", preventScroll, { passive: false });
}

// 允許滾動
function enableScroll() {
  document.body.style.overflow = ""; // 恢復滾動
  document.body.style.position = "";
  document.body.style.width = "";

  // 移除滑鼠滾動事件
  window.removeEventListener("wheel", preventScroll);

  // 移除觸控滾動事件（手機）
  window.removeEventListener("touchmove", preventScroll);
}

// 防止滾動的事件處理函數
function preventScroll(event) {
  event.preventDefault();
}

// 至少執行2秒
const timer = setTimeout(() => {
  isTimeOut = true;
  if (isLoad) {
    removeLoading();
  }
}, 2000);

// 完全載入的事件
window.addEventListener("load", () => {
  isLoad = true;
  preloadImages();
  if (isTimeOut) {
    removeLoading();
  }
});

// 移除loading
function removeLoading() {
  if (hasRemove) return;
  hasRemove = true;

  // 開始淡出效果
  loadingOverlay.style.opacity = 0;

  // loading隱藏
  loadingOverlay.addEventListener("transitionend", () => {
    loadingOverlay.style.display = "none";
    enableScroll(); // 恢復滾動

    // 初始化 AOS
    AOS.init({
      once: true,
      duration: 1500,
      offset: 160,
      anchorPlacement: "center-bottom",
    });

    // 計數器觀察功能
    if (typeof observeCounters === "function") {
      observeCounters();
    } else {
      // console.warn("observeCounters 函數未定義。");
    }
  });
}

// 啟動loading時禁止滾動
if (loadingOverlay) {
  loadingOverlay.style.display = "flex";
  disableScroll(); // 禁止滾動
}

// 套件中的原始圖片調整
function preloadImages() {
  const links = document.querySelectorAll('a[href$=".webp"], a[href$=".jpg"], a[href$=".png"]');
  links.forEach(link => {
    const img = new Image();
    img.src = link.href; // 預加載圖片
    img.onload = () => {};
  });
}
