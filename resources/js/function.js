// 狀態列
const functionElement = document.querySelector(".function");
const right = document.querySelector("footer .right");
const functionHover = document.querySelector(".function-hover");

let isFunctionVisible = false; // 記錄目前狀態
let hideTimeout; // 計時器
let isMouseInside = false; // 電腦 & 手機是否在 .function 內

// 點擊 .function-hover 時，開關功能
functionHover.addEventListener("click", () => {
  if (isFunctionVisible) {
    hideFunction();
  } else {
    showFunction();
  }
});

// 點擊 .function（但不是 .function-hover）時，重新計時
functionElement.addEventListener("click", (event) => {
  if (event.target.closest(".function-hover")) return;
  resetTimer();
});

// **當滑鼠進入 .function，清除計時**
functionElement.addEventListener("mouseenter", () => {
  isMouseInside = true;
  clearTimeout(hideTimeout);
});

// **當滑鼠離開 .function，重新啟動計時**
functionElement.addEventListener("mouseleave", () => {
  isMouseInside = false;
  resetTimer();
});

// **手機：當手指觸摸 .function，清除計時**
functionElement.addEventListener("touchstart", () => {
  isMouseInside = true;
  clearTimeout(hideTimeout);
});

// **手機：當手指離開 .function，重新啟動計時**
functionElement.addEventListener("touchend", () => {
  isMouseInside = false;
  resetTimer();
});

// 顯示 .function 並啟動 5 秒計時
function showFunction() {
  functionElement.style.bottom = "0";
  right.style.bottom = "50px";
  isFunctionVisible = true;
  resetTimer();
}

// 隱藏 .function
function hideFunction() {
  functionElement.style.bottom = "-50px";
  right.style.bottom = "0";
  isFunctionVisible = false;
  clearTimeout(hideTimeout);
}

// 重新計時的函數
function resetTimer() {
  clearTimeout(hideTimeout);

  // 只有當滑鼠 & 手指不在 `.function` 內時，才啟動計時
  if (!isMouseInside) {
    hideTimeout = setTimeout(() => {
      hideFunction();
    }, 5000);
  }
}
