const scrollArrow = document.querySelector(".go-down");
const mainLifeTop = document.querySelector(".main-life");
const mainLifeScrollContainer = document.querySelector(".main-life-scroll-container");
const mainLifeScrollContainerSlides = document.querySelector(".main-life-scroll-container-slides");
const scrollStopButton = document.querySelector(".go-down-scroll");
const targetNode = document.body;
let scrollAnimationFrame;
let isAtBottom = false;
let hasScrolledMainLife = false;
let isInsideMainLifeScroll = false;
let savedInnerScrollProgress = 0;
let isMousePaused = false;
let isPausedByMouse = false;
let isPausedByMutation = false;
const isMobile = window.innerWidth <= 768;
const viewportCenter = window.innerHeight / 5;
const config = {
  childList: true,
  subtree: true,
};

const lineMove = document.querySelector(".line-move");
const lineDotAll = document.querySelectorAll(".line-dot");
const lifeAllSlide = document.querySelectorAll(".main-life-scroll-container-slide");

// 獲取 lineMove 當前位置的函數
function getCurrentLineMovePosition() {
  return window.currentLineMovePosition || '0%';
}


// 按鈕狀態 - 設為全局變數
window.buttonStates = false;

scrollArrow.addEventListener("click", () => {
  window.buttonStates = true;
});
scrollStopButton.addEventListener("click", () => {
  window.buttonStates = false;
});


let FIXED_SCROLL_SPEED = 0.1; // 滾動速度
if (isMobile) {
  FIXED_SCROLL_SPEED = 0.05;
}
// 生命軌跡
let FIXED_SCROLL_SPEED_LIFE = 0.05; // 滾動速度
if (isMobile) {
  FIXED_SCROLL_SPEED_LIFE = 0.125; // 手機版：main-life-scroll-container-slide內容換頁速度：375px / 0.125 = 3000ms
}
let isMouseInsideMainLife = false;

window.addEventListener("scroll", handleMainLifeScrollTop);
mainLifeScrollContainer.addEventListener("scroll", function () {
  if (!isMobile) {
    if (
      mainLifeScrollContainer.scrollTop + 60 >=
      mainLifeScrollContainer.scrollHeight - mainLifeScrollContainer.clientHeight
    ) {
      hasScrolledMainLife = true;
    }
  }
});


// 綁定滑鼠事件
function bindMouseEventsForMainLife() {
  mainLifeScrollContainer.addEventListener("mouseenter", handleMouseEnter);
  mainLifeScrollContainer.addEventListener("mouseleave", handleMouseLeave);
}

// 移除滑鼠事件
function unbindMouseEventsForMainLife() {
  mainLifeScrollContainer.removeEventListener("mouseenter", handleMouseEnter);
  mainLifeScrollContainer.removeEventListener("mouseleave", handleMouseLeave);
}

// 滑鼠進入
function handleMouseEnter() {
  isMouseInsideMainLife = true;
  if (!isPausedByMutation) {
    isPausedByMouse = true;
    stopScrollAnimation();
  }
}

// 滑鼠離開
function handleMouseLeave() {
  isMouseInsideMainLife = false;
  if (!window.buttonStates) {
    return;
  }
  if (isPausedByMouse && !isPausedByMutation) {
    isPausedByMouse = false;
    if (!hasScrolledMainLife && isInsideMainLifeScroll) {
      scrollMainLifeContent(savedInnerScrollProgress);
    } else if (hasScrolledMainLife) {
      requestAnimationFrame(() => {
        const newRemainingDistance =
          document.documentElement.scrollHeight -
          (window.scrollY + window.innerHeight);
        if (newRemainingDistance > 0) {
          continueOuterScroll(newRemainingDistance);
        } else {
          finishScroll();
        }
      });
    }
  }
}
// 重製生命迴廊滾動位置
function handleMainLifeScrollTop() {
  if (isMobile) {
    if (
      !isInsideMainLifeScroll &&
      hasScrolledMainLife &&
      window.scrollY <= mainLifeTop.offsetTop - viewportCenter - 20
    ) {
      goTop();
    }
  } else {
    if (
      !isInsideMainLifeScroll &&
      hasScrolledMainLife &&
      window.scrollY <= mainLifeTop.offsetTop - 20
    ) {
      goTop();
    }
  }
}
// 打開幻燈片停下滾動
const observer = new MutationObserver((mutationsList) => {
  for (const mutation of mutationsList) {
    if (mutation.type === "childList") {
      if (mutation.addedNodes.length > 0) {
        mutation.addedNodes.forEach((node) => {
          if (
            node.nodeType === 1 &&
            node.tagName === "DIV" &&
            node.classList.contains("pswp--open")
          ) {
            pauseInternalScroll();
          }
        });
      }
    }
  }
});

observer.observe(targetNode, config);

function forceRepaint(element) {
  element.style.transform = "translateZ(0)";
  requestAnimationFrame(() => {
    element.style.transform = "";
  });
}

// 為兩個容器都添加滾動事件監聽器
mainLifeScrollContainer.addEventListener("scroll", () => {
  if (isMouseInsideMainLife && !isMobile) {
    savedInnerScrollProgress = mainLifeScrollContainer.scrollTop;
  }
});

if (mainLifeScrollContainerSlides) {
  mainLifeScrollContainerSlides.addEventListener("scroll", () => {
    if (isMouseInsideMainLife && isMobile) {
      savedInnerScrollProgress = mainLifeScrollContainerSlides.scrollLeft;
    }
  });

  // 手機版滾動完成檢測
  mainLifeScrollContainerSlides.addEventListener("scroll", function () {
    if (isMobile) {
      if (
        mainLifeScrollContainerSlides.scrollLeft + 60 >=
        mainLifeScrollContainerSlides.scrollWidth - mainLifeScrollContainerSlides.clientWidth
      ) {
        hasScrolledMainLife = true;
      }
    }
  });
}

scrollStopButton.addEventListener("click", () => {
  if (!isMousePaused) {
    stopScrollAnimation();
  }
});

scrollArrow.addEventListener("click", () => {
  if (!isMousePaused) {
    stopScrollAnimation();
  }
  if (isAtBottomOfPage()) {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
    toggleScrollArrow(false);
    isAtBottom = false;
    goTop();
  } else {
    scrollToBottomWithFixedSpeed();
  }
});

let scrollTimeout = null;

function goTop() {
  const targetContainer = isMobile ? mainLifeScrollContainerSlides : mainLifeScrollContainer;
  if (targetContainer) {
    if (isMobile) {
      targetContainer.scrollLeft = 0;
    } else {
      targetContainer.scrollTop = 0;
    }
    if (scrollTimeout) {
      clearTimeout(scrollTimeout);
    }
    scrollTimeout = setTimeout(() => {
      if (isMobile) {
        targetContainer.scrollLeft = 0;
      } else {
        targetContainer.scrollTop = 0;
      }
      hasScrolledMainLife = false;
      isInsideMainLifeScroll = false;
      savedInnerScrollProgress = 0;
      if (dotMove) {
        dotMove(0, 1);
      }
      scrollTimeout = null;
    }, 300);
  }
}


function scrollToBottomWithFixedSpeed(remainingDistance = null) {
  stopScrollAnimation();
  document.documentElement.style.scrollBehavior = "auto";

  scrollArrow.classList.add("go-down-scroll");
  scrollStopButton.style.display = "block";

  const start = window.scrollY;
  const end = document.documentElement.scrollHeight;
  const distance =
    remainingDistance !== null ?
    remainingDistance :
    end - (start + window.innerHeight);

  if (distance <= 0) {
    toggleScrollArrow(true);
    return;
  }

  const duration = distance / FIXED_SCROLL_SPEED;
  let startTime = performance.now();

  function scrollStep(timestamp) {
    const elapsed = timestamp - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const targetY = start + distance * progress;
    const mainLifeBottom = mainLifeTop.offsetTop + mainLifeTop.offsetHeight;
    if (isMobile) {
      const mainLifeTopVisible =
        targetY >= mainLifeTop.offsetTop - viewportCenter;


      if (
        mainLifeTopVisible &&
        window.scrollY < mainLifeBottom &&
        !hasScrolledMainLife
      ) {
        // console.log("手機版：main-life-scroll-container 滾動至畫面中心，開始內部滾動");
        stopScrollAnimation();
        scrollMainLifeContent(distance * (1 - progress));
        return;
      }
    } else {
      if (
        targetY >= mainLifeTop.offsetTop &&
        window.scrollY < mainLifeBottom &&
        !hasScrolledMainLife
      ) {
        // console.log("桌面版：main-life-scroll-container 滾動至畫面中心，開始內部滾動");
        stopScrollAnimation();
        scrollMainLifeContent(distance * (1 - progress));
        return;
      }
    }

    window.scrollTo(0, targetY);

    if (progress < 1) {
      scrollAnimationFrame = requestAnimationFrame(scrollStep);
    } else {
      finishScroll();
    }
  }

  scrollAnimationFrame = requestAnimationFrame(scrollStep);
}

// 滾動內部容器
function scrollMainLifeContent(remainingDistance) {
  // 根據設備類型選擇正確的滾動容器
  const targetContainer = isMobile ? mainLifeScrollContainerSlides : mainLifeScrollContainer;

  // console.log("scrollMainLifeContent 被調用，targetContainer:", targetContainer);

  if (!targetContainer) {
    console.error("滾動容器不存在！");
    return;
  }

  isInsideMainLifeScroll = true;
  bindMouseEventsForMainLife();

  scrollArrow.classList.add("go-down-scroll");
  scrollStopButton.style.display = "block";

  if (isMobile) {
    // 手機版：橫向滾動
    const scrollWidth = targetContainer.scrollWidth - targetContainer.clientWidth;
    const remainingScrollWidth = scrollWidth - savedInnerScrollProgress;
    const duration = remainingScrollWidth / FIXED_SCROLL_SPEED_LIFE;

    // line-move 動畫準備
    const totalItems = lineDotAll.length;
    const step = 100 / (totalItems - 1);
    // 目前 left 百分比
    let currentLeft = 0;
    if (lineMove && lineMove.style.left) {
      currentLeft = parseFloat(lineMove.style.left);
      if (isNaN(currentLeft)) currentLeft = 0;
    }
    // 目標 left 百分比
    const targetLeft = 100;

    let startTime = performance.now();

    function mainLifeScrollStep(timestamp) {
      const elapsed = timestamp - startTime;
      const scrollProgress = Math.min(elapsed / duration, 1);
      targetContainer.scrollLeft =
        savedInnerScrollProgress + remainingScrollWidth * scrollProgress;

      // line-move 同步動畫
      if (lineMove) {
        // 依照 scrollProgress 計算 left 百分比
        const left = currentLeft + (targetLeft - currentLeft) * scrollProgress;
        lineMove.style.top = '50%';
        lineMove.style.left = `${left}%`;
        // 也同步 window.currentLineMovePosition
        window.currentLineMovePosition = `${left}%`;
      }

      if (scrollProgress < 1) {
        scrollAnimationFrame = requestAnimationFrame(mainLifeScrollStep);
      } else {
        if (lineMove) {
          lineMove.style.left = `${targetLeft}%`;
          window.currentLineMovePosition = `${targetLeft}%`;
        }
        isInsideMainLifeScroll = false;
        hasScrolledMainLife = true;
        savedInnerScrollProgress = 0;
        scrollArrow.classList.remove("go-down-scroll");
        scrollStopButton.style.display = "none";
        unbindMouseEventsForMainLife();
        forceRepaint(targetContainer);
        requestAnimationFrame(() => {
          const newRemainingDistance =
            document.documentElement.scrollHeight -
            (window.scrollY + window.innerHeight);
          if (newRemainingDistance > 0) {
            continueOuterScroll(newRemainingDistance);
          } else {
            finishScroll();
          }
        });
      }
    }

    scrollAnimationFrame = requestAnimationFrame(mainLifeScrollStep);
  } else {
    // 電腦版：垂直滾動
    const scrollHeight = targetContainer.scrollHeight - targetContainer.clientHeight;
    const remainingScrollHeight = scrollHeight - savedInnerScrollProgress;
    const duration = remainingScrollHeight / FIXED_SCROLL_SPEED_LIFE;

    // console.log("電腦版滾動參數:", {
    //   scrollHeight: scrollHeight,
    //   clientHeight: targetContainer.clientHeight,
    //   savedInnerScrollProgress: savedInnerScrollProgress,
    //   remainingScrollHeight: remainingScrollHeight,
    //   duration: duration
    // });

    let startTime = performance.now();

    function mainLifeScrollStep(timestamp) {
      const elapsed = timestamp - startTime;
      const scrollProgress = Math.min(elapsed / duration, 1);
      targetContainer.scrollTop =
        savedInnerScrollProgress + remainingScrollHeight * scrollProgress;

      if (scrollProgress < 1) {
        scrollAnimationFrame = requestAnimationFrame(mainLifeScrollStep);
      } else {
        isInsideMainLifeScroll = false;
        hasScrolledMainLife = true;
        savedInnerScrollProgress = 0;
        scrollArrow.classList.remove("go-down-scroll");
        scrollStopButton.style.display = "none";
        unbindMouseEventsForMainLife();
        forceRepaint(targetContainer);
        requestAnimationFrame(() => {
          const newRemainingDistance =
            document.documentElement.scrollHeight -
            (window.scrollY + window.innerHeight);
          if (newRemainingDistance > 0) {
            continueOuterScroll(newRemainingDistance);
          } else {
            finishScroll();
          }
        });
      }
    }

    scrollAnimationFrame = requestAnimationFrame(mainLifeScrollStep);
  }
}

function continueOuterScroll(remainingDistance) {
  if (remainingDistance > 0) {
    scrollToBottomWithFixedSpeed(remainingDistance);
  } else {
    finishScroll();
  }
}
// 滾動完成
function finishScroll() {
  toggleScrollArrow(true);
  isAtBottom = true;
  document.documentElement.style.scrollBehavior = "smooth";
  scrollArrow.classList.remove("go-down-scroll");
  scrollStopButton.style.display = "none";
}
// 畫面底部
function isAtBottomOfPage() {
  const tolerance = 2;
  return (
    window.scrollY + window.innerHeight >=
    document.documentElement.scrollHeight - tolerance
  );
}

function stopScrollAnimation() {
  if (scrollAnimationFrame) {
    cancelAnimationFrame(scrollAnimationFrame);
    scrollAnimationFrame = null;
    const targetContainer = isMobile ? mainLifeScrollContainerSlides : mainLifeScrollContainer;
    if (targetContainer) {
      if (isMobile) {
        savedInnerScrollProgress = targetContainer.scrollLeft;
      } else {
        savedInnerScrollProgress = targetContainer.scrollTop;
      }
    }
    if (!isMousePaused) {
      scrollArrow.classList.remove("go-down-scroll");
      scrollStopButton.style.display = "none";
    }
    document.documentElement.style.scrollBehavior = "smooth";
  }
}

function toggleScrollArrow(atBottom) {
  if (atBottom) {
    scrollArrow.classList.add("go-down-up");
    scrollArrow.classList.remove("go-down-down");
    scrollArrow.classList.remove("go-down-scroll");
    scrollStopButton.style.display = "none";
  } else {
    scrollArrow.classList.add("go-down-down");
    scrollArrow.classList.remove("go-down-up");
    scrollArrow.classList.remove("go-down-scroll");
    scrollStopButton.style.display = "none";
  }
}

// 暫停滾動
window.addEventListener("wheel", () => {
  if (!isMousePaused) {
    stopScrollAnimation();
  }
});

window.addEventListener("touchmove", () => {
  if (!isMousePaused) {
    stopScrollAnimation();
  }
});

// 只要點擊畫面任何地方都會停止滾動
document.addEventListener("click", (e) => {
  if (
    scrollArrow.contains(e.target) ||
    document.querySelector(".music-up").contains(e.target) ||
    document.querySelector(".music-button").contains(e.target) ||
    document.querySelector(".music-down").contains(e.target) ||
    document.querySelector(".function").contains(e.target) ||
    document.querySelector(".function-hover").contains(e.target)
  ) {
    return;
  }

  // 其他點擊都會停止滾動
  if (!isMousePaused) {
    stopScrollAnimation();
  }
});


window.addEventListener("scroll", () => {
  if (isAtBottomOfPage()) {
    if (!isAtBottom) {
      toggleScrollArrow(true);
      isAtBottom = true;
    }
  } else {
    if (isAtBottom) {
      toggleScrollArrow(false);
      isAtBottom = false;
    }
  }
});

function pauseInternalScroll() {
  if (isInsideMainLifeScroll) {
    stopScrollAnimation();
    isPausedByMutation = true;
    isPausedByMouse = false;
  }
}