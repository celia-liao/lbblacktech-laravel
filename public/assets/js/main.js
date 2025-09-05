// 泡泡區域動畫��
let mainBobs = document.querySelector(".main-bobs");
let bob1 = mainBobs.querySelector(".main-bobs-area-box-1-bob");
let bob2 = mainBobs.querySelector(".main-bobs-area-box-2-bob");
let bob3 = mainBobs.querySelector(".main-bobs-area-box-3-bob");
let bob4 = mainBobs.querySelector(".main-bobs-area-box-4-bob");
let bobImg = mainBobs.querySelector(".main-bobs-buttons");

window.addEventListener("resize", refreshBob);
window.addEventListener("load", refreshBob);
let nowDevice = "";
function refreshBob() {
  if (!mainBobs || !bob1 || !bob2 || !bob3 || !bob4 || !bobImg) {
    return;
  }

  if (window.innerWidth > 768 && nowDevice !== "d") {
    nowDevice = "d";

    bob1.setAttribute("data-aos-delay", "0");
    bob2.setAttribute("data-aos-delay", "450");
    bob3.setAttribute("data-aos-delay", "150");
    bob4.setAttribute("data-aos-delay", "300");
    bob1.setAttribute("data-aos", "scale-class");
    bob2.setAttribute("data-aos", "scale-class");
    bob3.setAttribute("data-aos", "scale-class");
    bob4.setAttribute("data-aos", "scale-class");
    bobImg.setAttribute("data-aos-delay", "450");
    bobImg.setAttribute("data-aos-acthor", ".main-bobs");
    AOS.refresh();
  } else if (window.innerWidth <= 768 && nowDevice !== "p") {
    nowDevice = "p";
    bob1.setAttribute("data-aos-delay", "0");
    bob2.setAttribute("data-aos-delay", "0");
    bob3.setAttribute("data-aos-delay", "0");
    bob4.setAttribute("data-aos-delay", "0");
    bob1.setAttribute("data-aos", "scale-class-move");
    bob2.setAttribute("data-aos", "scale-class-move");
    bob3.setAttribute("data-aos", "scale-class-move");
    bob4.setAttribute("data-aos", "scale-class-move");
    bobImg.setAttribute("data-aos-acthor", ".main-bobs-area-box-4-bob");
    bobImg.setAttribute("data-aos-delay", "0");
    AOS.refresh();
  }
}

// 監聽泡泡圖片準備好事件，而不是 DOMContentLoaded
window.addEventListener("bubbleImagesReady", function (event) {
  console.log('🎉 收到 bubbleImagesReady 事件！', event.detail);
  const bubble_imagePaths = event.detail.bubble_imagePaths;
  
  if (!bubble_imagePaths || bubble_imagePaths.length === 0) {
    console.warn('泡泡圖片數組為空，無法更新圖片');
    return;
  }

  const randomImages = bubble_imagePaths.sort(() => 0.5 - Math.random()).slice(0, 4);

  const allBobs = document.querySelectorAll(".main-bobs-area-box a");

  allBobs.forEach((item, index) => {
    const selectedImage = randomImages[index];
    const img = item.querySelector("img");

    if (selectedImage && img) {
      item.href = selectedImage.large;
      item.setAttribute("data-pswp-src", selectedImage.large);
      img.src = selectedImage.small;
    }
  });

  const loadPromises = Array.from(allBobs).map((item) => {
    return new Promise((resolve) => {
      const img = new Image();
      img.src = item.href;

      img.onload = () => {
        let imgWidth = img.naturalWidth;
        let imgHeight = img.naturalHeight;
        let maxWidth = window.innerWidth * 0.7;
        let maxHeight = window.innerHeight * 0.7;

        let aspectRatio = imgWidth / imgHeight;
        if (window.innerWidth > 768) {
          if (imgWidth > maxWidth) {
            imgWidth = maxWidth;
            imgHeight = imgWidth / aspectRatio;
          }
          if (imgHeight > maxHeight) {
            imgHeight = maxHeight;
            imgWidth = imgHeight * aspectRatio;
          }
        } else {
          maxHeight = window.innerHeight * 0.6;

          if (imgHeight > maxHeight) {
            imgHeight = maxHeight;
            imgWidth = imgHeight * aspectRatio;
          }
        }
        item.setAttribute("data-pswp-width", imgWidth);
        item.setAttribute("data-pswp-height", imgHeight);
        resolve();
      };

      img.onerror = () => {
        console.error(`图片加载失败: ${item.href}`);
        resolve();
      };
    });
  });

  Promise.all(loadPromises).then(() => {
    console.log('泡泡圖片配置完成，開始初始化 PhotoSwipe');
    
    const lightboxBoB = new PhotoSwipeLightbox({
      gallery: ".gallery-bobs",
      children: "a",
      pswpModule: PhotoSwipe,
      showHideAnimationType: "none",
      maxZoomLevel: 2,
      secondaryZoomLevel: 2,
      counter: false,
      preload: [allBobs.length, allBobs.length],
      tapAction: (p, o) => {
        if (o.target.closest(".pswp__img")) {
          return;
        }
        lightboxBoB.pswp.close();
      },
    });
    
    // 添加調試信息
    lightboxBoB.on('uiRegister', function() {
      console.log('泡泡 PhotoSwipe 實例已初始化');
    });
    
    lightboxBoB.on('firstUpdate', function() {
      console.log('泡泡 PhotoSwipe 首次更新完成');
    });
    
    lightboxBoB.init();
    console.log('泡泡 PhotoSwipe 初始化完成');
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // 移除原來的泡泡圖片更新邏輯，現在由自定義事件處理
  // 保留其他 DOMContentLoaded 邏輯（如果有）
});

// 互動功能
let feedBtn = document.querySelector(".feed");
let handBtn = document.querySelector(".hand");
let bobsArea = document.querySelector(".main-bobs-area-img");
let bobsImg = document.querySelector(".main-bobs-area-img .bg-img");
let bobsImgHand = document.querySelector(".main-bobs-area-img .hand-img");
let bobsVideoArea = document.querySelector(".main-video");
let bobsVideo = document.querySelector(".main-video-area video");
let handAudio = document.querySelector("#handAudio");
let feedAudio = document.querySelector("#feedAudio");
let muteBtn = document.querySelector("#muteBtn");
let muteBtnImg = document.querySelector("#muteBtn img");
let currentAction = null;
let timeoutId;
let isMuted = false;
const preloadHandImg = new Image();
// preloadHandImg.src = "./image/main/interaction/photo/hand-n.webp'";
preloadHandImg.src = `${window.PET_ASSETS.imagePath}/main/interaction/photo/hand-n.webp`;

muteBtn.addEventListener("click", () => {
  const videoElement = document.querySelector(".main-video-area video");

  if (!videoElement) return;

  // ���敶梁��𣈯𨺗����
  videoElement.muted = !videoElement.muted;

  // �湔鰵�𣈯𨺗�厰��𣇉�
  muteBtnImg.src = videoElement.muted
    ? `${window.PET_ASSETS.imagePath}/volume-xmark-solid.svg`
    : `${window.PET_ASSETS.imagePath}/volume-high-solid.svg`;
});


function stopCurrentAction() {
  if (timeoutId) {
    clearTimeout(timeoutId);
    timeoutId = null;
  }

  if (bobsVideoArea) {
    bobsVideoArea.classList.remove("view");
  }
  if (bobsVideo) {
    bobsVideo.classList.remove("view");
    bobsVideo.pause();
    bobsVideo.currentTime = 0;
  }

  if (bobsImgHand) {
    bobsImgHand.style.animation = ``;
    bobsImgHand.src = `${window.PET_ASSETS.imagePath}/main/interaction/photo/hand-p.webp`;
  }

  bobsImg.style.opacity = ``;

  if (window.innerWidth <= 768) {
    bobsArea.style.zIndex = ``;
  }

  // �𨀣迫�單��剜𦆮
  handAudio.pause();
  handAudio.currentTime = 0;
  feedAudio.pause();
  feedAudio.currentTime = 0;

  currentAction = null;
}
feedBtn.addEventListener("click", () => {
  muteBtn.style.visibility = "visible";
  muteBtn.style.opacity = 1;
  if (currentAction === "feed") return;

  stopCurrentAction();
  currentAction = "feed";

  if (bobsVideoArea) {
    bobsVideoArea.style.display = "flex";
    requestAnimationFrame(() => {
      bobsVideoArea.classList.add("view");
    });
  }

  if (bobsVideo) {
    bobsVideo.currentTime = 0;
    bobsVideo.play();
    requestAnimationFrame(() => {
      bobsVideo.classList.add("view");
    });
  }

  if (!isMuted) {
    feedAudio.currentTime = 0;
    feedAudio.play();
  }

  if (window.innerWidth <= 768) {
    bobsArea.style.zIndex = 6;
  } else {
    bobsArea.style.zIndex = ``;
  }

  // timeoutId = setTimeout(() => {
  //   if (bobsVideoArea) {
  //     bobsVideoArea.classList.remove("view");
  //   }
  //   if (bobsVideo) {
  //     bobsVideo.classList.remove("view");
  //     bobsVideo.pause();
  //   }
  //   stopCurrentAction();

  // }, 4400);


  if (bobsVideo) {
    // �嗅蔣��偘�曄����嚗�嘑銵屸黸�讛�皜�膄�蓥�
    bobsVideo.addEventListener("ended", () => {
      if (bobsVideoArea) {
        bobsVideoArea.classList.remove("view");
      }
      if (bobsVideo) {
        bobsVideo.classList.remove("view");
        bobsVideo.pause();
        bobsVideo.currentTime = 0; // �滩身敶梁��啗絲暺�
      }
      stopCurrentAction();
    });
  }
});

// �⊥��厰�鈭衤辣
handBtn.addEventListener("click", () => {
  muteBtn.style.visibility = "unset";
  muteBtn.style.opacity = 1;
  if (currentAction === "hand") return;
  stopCurrentAction();
  currentAction = "hand";

  const timestamp = new Date().getTime();
  const randomChance = Math.random();

  if (bobsImgHand) {
    if (randomChance <= 0.2 && preloadHandImg.src) {
      bobsImgHand.src = preloadHandImg.src;
      bobsImgHand.style.animation = `animation-hand-up 2.8s linear 0s`;
    } else {
      bobsImgHand.src = `${window.PET_ASSETS.imagePath}/main/interaction/photo/hand-p.webp`;
      bobsImgHand.style.animation = `animation-hand-down 2.8s linear 0s`;
    }
  }

  if (!isMuted) {
    handAudio.currentTime = 0;
    handAudio.play();
  }

  bobsImg.style.opacity = `1`;

  // �𧢲���身摰� zIndex
  if (window.innerWidth <= 768) {
    bobsArea.style.zIndex = 6;
  } else {
    bobsArea.style.zIndex = ``;
  }

  bobsImg.src = `${window.PET_ASSETS.imagePath}/main/interaction/heart.gif?${timestamp}`;

  timeoutId = setTimeout(() => {
    stopCurrentAction();
  }, 3200);
});

if (bobsVideoArea) {
  bobsVideoArea.addEventListener("transitionend", function (e) {
    if (
      e.propertyName === "opacity" &&
      getComputedStyle(bobsVideoArea).opacity === "0"
    ) {
      bobsVideoArea.style.display = "";
    }
  });
}
if (bobsVideo) {
  bobsVideo.addEventListener("transitionend", function (e) {
    if (
      e.propertyName === "opacity" &&
      getComputedStyle(bobsVideo).opacity === "0"
    ) {
      bobsVideo.currentTime = 0;
    }
  });
}

if (bobsImg) {
  bobsImg.addEventListener("transitionend", function (e) {
    if (
      e.propertyName === "opacity" &&
      getComputedStyle(bobsImg).opacity === "0"
    ) {
      bobsImg.src = `${window.PET_ASSETS.imagePath}/main/interaction/air.png`;
    }
  });
}

// 皛穃���
let mainLife = document.querySelector(".main-life-scroll-container");
let lifeSlides = mainLife.querySelector(".main-life-scroll-container-slides");
let lifeAllSlide = lifeSlides.querySelectorAll(
  ".main-life-scroll-container-slide"
);
let line = document.querySelector(".main-life-sticky-age-line .line");
let lineContainer = document.querySelector(".main-life-scroll-container");
let lineDotAll = document.querySelectorAll(".line-dot");
let lineMove = document.querySelector(".line-move");
let nowTop = null;
let prevIndex = 0;

lifeSlides.addEventListener("scroll", function() {
  if (window.innerWidth > 768) return;

  const scrollLeft = lifeSlides.scrollLeft;
  const slideWidth = lifeSlides.offsetWidth;
  const totalItems = lineDotAll.length;
  const step = 100 / (totalItems - 1);
  const currentIndex = Math.round(scrollLeft / slideWidth);

  // 皛穃�蝘餃�
  lineMove.style.top  = '50%';
  lineMove.style.left = `${currentIndex * step}%`;
  // 摮睃��嗅�雿滨蔭蝯� new-scroll.js 雿輻鍂
  window.currentLineMovePosition = `${currentIndex * step}%`;

  if (currentIndex > prevIndex) {
    //  �穃𢰧皛𡢅��芣��啁�銝��潦�屸�鈭柴��
    lineDotAll[currentIndex].style.opacity = 1;
    lifeAllSlide[currentIndex].classList.add("add-move");
  } else if (currentIndex < prevIndex) {
    // �穃椰皛𡢅��𠰴��ａ�����潦�𣬚�皛���
    lineDotAll[prevIndex].style.opacity = 0;
    lifeAllSlide[prevIndex].classList.remove("add-move");
  }
  // �湔鰵 prevIndex
  prevIndex = currentIndex;

  // ��敺䔶���炎皜�
  if (currentIndex === totalItems - 1) {
    onLastPage();
  } else {
    document.querySelectorAll('h3.fadeIn').forEach(h3 =>
      h3.classList.remove('visible')
    );
  }
});

// 獢屸𢒰��遝�閧𧙗��
mainLife.addEventListener("scroll", function () {
  if (window.innerWidth <= 768) return;
  lifeAllSlide.forEach((item, index) => {
    if (mainLife.scrollTop >= item.offsetTop - (item.offsetHeight / 4) * 3) {
      if (!item.classList.contains("add-move")) {
        mainLife.scrollTo({
          top: item.offsetTop,
          behavior: "smooth",
        });
        item.classList.add("add-move");
        dotMove(index, 1);
      }
    } else if (
      mainLife.scrollTop <= item.offsetTop + item.offsetHeight * 0.2 &&
      item.classList.contains("add-move")
    ) {
      item.classList.remove("add-move");
      dotMove(index - 1, 0);
      mainLife.scrollTo({
        top: lifeAllSlide[index - 1].offsetTop,
        behavior: "smooth",
      });
    }
  });
});

let isResize = false;
window.addEventListener("load", function () {
  if (window.innerWidth > 768 && line && lineContainer) {
    if (lineContainer.offsetHeight > 0) {
      line.style.height = `${lineContainer.offsetHeight * 0.65}px`;
    }
  } else {
    if (line) {
      line.style.height = ``;
    }
  }
});
window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    if (line && lineContainer) {
      if (lineContainer.offsetHeight > 0) {
        line.style.height = `${lineContainer.offsetHeight * 0.7}px`;
      }
    }
    if (isResize) {
      isResize = false;

      if (lineMove) {
        lineMove.style.left = ``;
        if (nowTop) {
          lineMove.style.top = nowTop;
        }
      }
    }
  } else {
    line.style.height = ``;
    if (!isResize) {
      if (lineMove) {
        lineMove.style.top = `50%`;
        isResize = true;
        if (nowTop) {
          lineMove.style.left = nowTop;
        }
      }
    } else {
    }
  }
});


const mainLifeScrollContainer = document.querySelector(
  ".main-life-scroll-container"
);


let scrollTimeout = null;
function goTop() {
  if (mainLifeScrollContainer) {
    mainLifeScrollContainer.scrollTop = 0;
    if (scrollTimeout) {
      clearTimeout(scrollTimeout);
    }
    scrollTimeout = setTimeout(() => {
      mainLifeScrollContainer.scrollTop = 0;
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

function onLastPage() {
  // console.log("撌脣��娍�敺䔶����");

  // <section class="main-life gallery-life"> �臬炏�ａ��恍𢒰
  const section = document.querySelector(".main-life.gallery-life");

  if (!section) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          console.log("�ａ��恍𢒰嚗���啁洵銝����");
          // dotMove(0, 1); // �𧼮�蝚砌���
          goTop();
          observer.disconnect(); // �𨀣迫���嚗屸��漤�銴�孛��
        }
      });
    },
    { threshold: 0 } // 閮剖��� 0嚗𣬚訜 <section> 摰���ａ��恍𢒰��孛��
  );

  observer.observe(section);
}

// 甇脫彍皛烐▼
window.dotMove = function (i, n) {
  if (lifeAllSlide.length == lineDotAll.length) {
    const totalItems = lineDotAll.length;
    const step = 100 / (totalItems - 1);

    if (window.innerWidth > 768) {
      lineMove.style.top = `${i * step}%`;
      lineMove.style.left = '';
      // 摮睃��嗅�雿滨蔭蝯� new-scroll.js 雿輻鍂
      window.currentLineMovePosition = `${i * step}%`;
    } else {
      lineMove.style.top = '50%';
      lineMove.style.left = `${i * step}%`;
      // 摮睃��嗅�雿滨蔭蝯� new-scroll.js 雿輻鍂
      window.currentLineMovePosition = `${i * step}%`;
      
      // �𧢲����嚗����遝�訫�撠齿�雿滨蔭
      const slideWidth = lifeSlides.offsetWidth;
      lifeSlides.scrollTo({
        left: i * slideWidth,
        behavior: "smooth"
      });
    }

    if (lineDotAll[i] && i !== 0 && n === 1) {
      lineDotAll[i].style.opacity = 1;
    } else if (lineDotAll[i] && i < lineDotAll.length - 1 && n === 0) {
      lineDotAll[i + 1].style.opacity = 0;
    }

    nowTop = `${i * step}%`;

    if (lifeAllSlide[i]) {
      if (window.innerWidth > 768) {
        mainLife.scrollTo({
          top: lifeAllSlide[i].offsetTop,
          behavior: "smooth"
        });
      }
    }
    if (i === totalItems - 1) {
      onLastPage();
    }else {
      // �ａ���敺䔶����蝘駁膄 visible
      const h3 = document.querySelector('h3.fadeIn');
      if (h3) {
        h3.classList.remove('visible');
      }
    }
  }
};



// �笔𦶢餈游�
const lifeAreaAll = document.querySelectorAll(
  ".main-life-scroll-container-slide"
);

// 生命軌跡初始化函數
function initializeLifeSlides() {
  // 重新獲取生命軌跡元素
  const lifeSlides = document.querySelector(".main-life-scroll-container-slides");
  const lifeAllSlide = lifeSlides ? lifeSlides.querySelectorAll(".main-life-scroll-container-slide") : [];
  
  console.log('初始化生命軌跡，找到', lifeAllSlide.length, '個slide');
  
  if (!lifeAllSlide || lifeAllSlide.length === 0) {
    console.log('生命軌跡尚未生成，等待中...');
    // 如果還沒有生成，等待一下再試
    setTimeout(initializeLifeSlides, 500);
    return;
  }

  lifeAllSlide.forEach((item, index) => {
    console.log('檢查 slide', index + 1, item);
    
    // 嘗試多種可能的选择器
    let rightSlide = item.querySelector(".main-life-scroll-container-slide-right a");
    if (!rightSlide) {
      rightSlide = item.querySelector("a");
    }
    if (!rightSlide) {
      rightSlide = item.querySelector("img")?.parentElement;
    }
    
    console.log('找到的 rightSlide', rightSlide);

    if (rightSlide && rightSlide.querySelector("img")) {
      // 添加 Fancybox 屬性
      rightSlide.setAttribute("data-fancybox", "life-gallery");
      rightSlide.setAttribute("data-caption", `生命軌跡 ${index + 1}`);
      console.log('設定生命軌跡圖片', index + 1, rightSlide.href);
      const img = new Image();
      img.src = rightSlide.href;
      img.onload = () => {
        let imgWidth = img.naturalWidth;
        let imgHeight = img.naturalHeight;
        let maxWidth = window.innerWidth * 0.7;
        let maxHeight = window.innerHeight * 0.7;

        let aspectRatio = imgWidth / imgHeight;
        if (window.innerWidth > 768) {
          if (imgWidth > maxWidth) {
            imgWidth = maxWidth;
            imgHeight = imgWidth / aspectRatio;
          }
          if (imgHeight > maxHeight) {
            imgHeight = maxHeight;
            imgWidth = imgHeight * aspectRatio;
          }
        } else {
          maxHeight = window.innerHeight * 0.6;

          if (imgHeight > maxHeight) {
            imgHeight = maxHeight;
            imgWidth = imgHeight * aspectRatio;
          }
        }
        rightSlide.setAttribute("data-pswp-width", imgWidth);
        rightSlide.setAttribute("data-pswp-height", imgHeight);
        rightSlide.setAttribute("data-pswp-src", rightSlide.href);
      };

      img.onerror = () => {
        console.error(`�𣇉��㰘�憭望�: ${rightSlide.href}`);
      };
    }
  });

  // 初始化 PhotoSwipe
  const lifeAreaAll = document.querySelectorAll(".main-life-scroll-container-slide");
  lifeAreaAll.forEach((item, index) => {
    const lightboxLife = new PhotoSwipeLightbox({
      gallery: `.gallery-life .life-${index + 1}`,
      children: "a",
      pswpModule: PhotoSwipe,
      showHideAnimationType: "none",
      maxZoomLevel: 2,
      secondaryZoomLevel: 2,
      counter: false,
      tapAction: (p, o) => {
        if (o.target.closest(".pswp__img")) {
          return;
        }
        lightboxLife.pswp.close();
      },
    });
    lightboxLife.init();
  });
  
  console.log('生命軌跡初始化完成');
}

// 監聽生命軌跡生成完成事件
document.addEventListener("DOMContentLoaded", function () {
  console.log('DOMContentLoaded 觸發，開始生命軌跡初始化');
  // 延遲執行，等待生命軌跡生成
  setTimeout(initializeLifeSlides, 1000);
});

// 也監聽 window load 事件作為備用
window.addEventListener("load", function () {
  console.log('Window load 觸發，檢查生命軌跡');
  setTimeout(initializeLifeSlides, 500);
});

// 監聽自定義事件，當生命軌跡生成完成時觸發
window.addEventListener("lifeSlidesReady", function () {
  console.log('收到 lifeSlidesReady 事件');
  initializeLifeSlides();
});

const fit = document.querySelector("#fit-1");
const fit1Img = document.querySelector("#fit-1 img");
const fit2Img = document.querySelector("#fit-2 img");
let firstFit = false;

const sloganBox = document.querySelector(".slogan-box");
const continued = document.querySelector(".continued");

const observerFit = new MutationObserver((mutationsList) => {
  const timestamp = new Date().getTime();
  for (const mutation of mutationsList) {
    if (mutation.type === "attributes" && mutation.attributeName === "class") {
      if (fit.classList.contains("aos-animate") && !firstFit) {
        if (fit1Img) {
          fit1Img.src = `./image/footer/up-fit.gif?${timestamp}`;
        }
        setTimeout(() => {
          if (fit2Img) {
            fit2Img.src = `./image/footer/down-fit.gif?${timestamp}`;
          }
        }, 5200);

        /// 嚙踝蕭 �躰ㄐ�牐�憿舐內 .slogan-box �� .continued ��辣�脫綉��
        // 瑼Ｘ䰻�臬炏�箸�璈毺��墧�瘚詨�璅∪�
        const isMobile = window.innerWidth <= 768;
        const isImmersiveMode = window.buttonStates === true;
        
        if (isMobile && !isImmersiveMode) {
          // �𧢲����瘝㗇絡撘𧶏�蝡见朖憿舐內
          setTimeout(() => {
            sloganBox?.classList.add("show");
          }, 1500);

          setTimeout(() => {
            continued?.classList.add("show");
          }, 1900);
        } else {
          // 獢屸𢒰���瘝㗇絡撘𤩺芋撘𧶏�雿輻鍂撱園�
          setTimeout(() => {
            sloganBox?.classList.add("show");
          }, 5000);

          setTimeout(() => {
            continued?.classList.add("show");
          }, 5400);
        }
      }
    }
  }
});

observerFit.observe(fit, { attributes: true });

//�喳㫲�閧𧞄
const loadingOverlayPage = document.querySelector(".loading-overlay");

const mainLetterFootprint = document.querySelector(".main-letter-footprint");
const sloganH2 = document.querySelector(".slogan-box h2");
const sloganPeople = document.querySelector(".slogan-people img");
const sloganPet = document.querySelector(".slogan-pet img");

let isLoadingOverlayHidden = false;
let isMainLetterFootprintVisible = false;

const checkLoadingOverlay = () => {
  if (getComputedStyle(loadingOverlayPage).display === "none") {
    isLoadingOverlayHidden = true;
    triggerAnimationIfReady();
  }
};

const observerTitle = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        isMainLetterFootprintVisible = true;
        triggerAnimationIfReady();
        observerTitle.unobserve(entry.target);
      }
    });
  },
  {
    threshold: 0.5,
  }
);

if (mainLetterFootprint) {
  observerTitle.observe(mainLetterFootprint);
}
function triggerAnimationIfReady() {
  if (isLoadingOverlayHidden && isMainLetterFootprintVisible) {
    sloganH2.classList.add("aos-animate");
    sloganPeople.classList.add("aos-animate");
    sloganPet.classList.add("aos-animate");
  }
}

const loadingObserver = new MutationObserver(checkLoadingOverlay);

loadingObserver.observe(loadingOverlayPage, {
  attributes: true,
  attributeFilter: ["style"],
});

document.addEventListener("DOMContentLoaded", () => {
  if (loadingOverlayPage) {
    checkLoadingOverlay();
  }
});




let isDragging = false;
let totalSlides = lifeAllSlide.length;

// 皛烐▼�𡝗𠗊嚗𡁏�曌䭾�銝�
lineMove.addEventListener("mousedown", (e) => {
  isDragging = true;
  document.body.style.userSelect = "none";
});

// 皛烐▼�𡝗𠗊嚗𡁏�曌䭾𦆮��
document.addEventListener("mouseup", () => {
  if (isDragging) {
    isDragging = false;
    document.body.style.userSelect = "";
  }
});

// 皛烐▼�𡝗𠗊嚗𡁏�曌删宏��
document.addEventListener("mousemove", (e) => {
  if (!isDragging) return;

  const containerRect = lineMove.parentElement.getBoundingClientRect();
  let percentage;

  if (window.innerWidth > 768) {
    const offsetY = e.clientY - containerRect.top;
    percentage = offsetY / containerRect.height;
    lineMove.style.top = `${Math.max(0, Math.min(1, percentage)) * 100}%`;
  } else {
    const offsetX = e.clientX - containerRect.left;
    percentage = offsetX / containerRect.width;
    lineMove.style.left = `${Math.max(0, Math.min(1, percentage)) * 100}%`;
  }

  const clamped = Math.max(0, Math.min(1, percentage));
  const index = Math.round(clamped * (totalSlides - 1));
  dotMove(index, 1);
});

// �𧢲�閫豢綉�𡝗𠗊
lineMove.addEventListener("touchstart", () => {
  isDragging = true;
}, { passive: true });

document.addEventListener("touchend", () => {
  isDragging = false;
});

document.addEventListener("touchmove", (e) => {
  if (!isDragging) return;

  const touch = e.touches[0];
  const containerRect = lineMove.parentElement.getBoundingClientRect();
  let percentage;

  if (window.innerWidth > 768) {
    const offsetY = touch.clientY - containerRect.top;
    percentage = offsetY / containerRect.height;
    lineMove.style.top = `${Math.max(0, Math.min(1, percentage)) * 100}%`;
  } else {
    const offsetX = touch.clientX - containerRect.left;
    percentage = offsetX / containerRect.width;
    lineMove.style.left = `${Math.max(0, Math.min(1, percentage)) * 100}%`;
  }

  const clamped = Math.max(0, Math.min(1, percentage));
  const index = Math.round(clamped * (totalSlides - 1));
  dotMove(index, 1);
}, { passive: true });

// 确保事件监听器被正确设置
window.addEventListener("resize", refreshBob);
window.addEventListener("load", refreshBob);
