function hexToRgba(hex, alpha) {
    if (!hex) {
      return `rgba(255,210,213,${alpha})`; // 預設顏色
    }
  
    let bigint = parseInt(hex.substring(1), 16);
    let r = (bigint >> 16) & 255;
    let g = (bigint >> 8) & 255;
    let b = bigint & 255;
    return `rgba(${r},${g},${b},${alpha})`;
  }
    // 隨機選取一個影片
    const randomIndex = Math.floor(Math.random() * bubble_videos.length);
    const selectedVideo = bubble_videos[randomIndex];
  
    document.dispatchEvent(new CustomEvent("videoSelected", { detail: selectedVideo }));
  
    // 設置影片
    const videoElement = document.querySelector(".main-video-area video");
    videoElement.src = selectedVideo.src;
  
    // 更新按鈕文字
    const feedButton = document.querySelector(".main-bobs-buttons .feed");
    feedButton.textContent = selectedVideo.text;
  
  
    const videoArea = document.querySelector(".main-video-area");
    if (selectedVideo.ratio) {
      videoArea.classList.add(selectedVideo.ratio);
    }
  
    const muteBtn = document.getElementById("muteBtn");
    if (muteBtn) {
      if (selectedVideo.sound) {
        muteBtn.style.display = "block"; // 有聲音時顯示
      } else {
        muteBtn.style.display = "none"; // 無聲時隱藏
      }
    }

  
  
  function i() {
    var canvas,
      ctx,
      width,
      height,
      bubbles,
      animateHeader = true;
    
    console.log('初始化泡泡動畫...');
    initHeader();
    
    function initHeader() {
      canvas = document.getElementById("header_canvas");
      
      if (!canvas) {
        console.error('找不到 header_canvas 元素');
        return;
      }
      
      console.log('找到 canvas 元素:', canvas);
  
      window_resize();
      ctx = canvas.getContext("2d");
  
      if (canvas.width === 0 || canvas.height === 0) {
        console.log('Canvas 尺寸為 0，重新初始化...');
        requestAnimationFrame(initHeader);
        return;
      }
      
      console.log('Canvas 尺寸:', canvas.width, 'x', canvas.height);
  
      // 初始化泡泡
      bubbles = [];
      var num = width * 0.04;
      console.log('創建泡泡數量:', num);
      for (var i = 0; i < num; i++) {
        var c = new Bubble();
        bubbles.push(c);
      }
      animate();
    }
  
    function animate() {
      if (animateHeader) {
        ctx.clearRect(0, 0, width, height);
        for (var i in bubbles) {
          bubbles[i].draw();
        }
      }
      requestAnimationFrame(animate);
    }
    
    function window_resize() {
      // 嘗試多種方式獲取尺寸
      var panel = document.getElementById("thumbnail_canvas");
      if (!panel) {
        // 如果找不到 thumbnail_canvas，使用 header_canvas 的父元素
        panel = document.getElementById("header_canvas").parentElement;
      }
      
      if (!panel) {
        // 如果還是找不到，使用 window 尺寸
        width = window.innerWidth;
        height = window.innerHeight;
      } else {
        width = panel.offsetWidth;
        height = panel.offsetHeight;
      }
      
      // 確保最小尺寸
      if (width === 0) width = window.innerWidth;
      if (height === 0) height = window.innerHeight;
      
      console.log('設置 Canvas 尺寸:', width, 'x', height);
  
      canvas.width = width;
      canvas.height = height;
  
      bubbles = [];
      var num = width * 0.04;
      for (var i = 0; i < num; i++) {
        var c = new Bubble();
        bubbles.push(c);
      }
    }
    
    window.onresize = function () {
      window_resize();
    };
    
    function Bubble() {
      var _this = this;
      (function () {
        _this.pos = {};
        init();
      })();
      
      function init() {
        _this.pos.x = Math.random() * width;
  
        var startZone = Math.random();
        if (startZone < 0.5) {
          _this.pos.y = height + Math.random() * 100;
        } else {
          _this.pos.y = Math.random() * height * 0.7;
        }
  
        _this.alpha = 0; // 從完全透明開始
        _this.alpha_target = 0.1 + Math.random() * 0.9; // 最終透明度
        _this.alpha_change = 0.005 + Math.random() * 0.005; // 淡入速度
        _this.scale = 0.2 + Math.random() * 1; // 氣泡大小
        _this.scale_change = Math.random() * 0.002; // 氣泡大小變化速度
        _this.speed = 0.1 + Math.random() * 0.7; // 氣泡上升速度
        _this.scale = Math.min(_this.scale, 2.2);
      }
  
      // 繪製氣泡
      this.draw = function () {
        if (_this.pos.y < -_this.scale * 10 || _this.alpha <= 0) {
          init();
        }
  
        _this.pos.y -= _this.speed;
  
        if (_this.alpha < _this.alpha_target) {
          _this.alpha += _this.alpha_change;
        }
  
        if (_this.pos.y < height * 0.3) {
          _this.alpha_change = 0.005 + Math.random() * 0.002;
          _this.alpha -= _this.alpha_change;
        }
  
        _this.scale += _this.scale_change;
        _this.scale = Math.max(0.2, Math.min(_this.scale, 5));
  
        ctx.beginPath();
        ctx.arc(
          _this.pos.x,
          _this.pos.y,
          _this.scale * 10,
          0,
          2 * Math.PI,
          false
        );
        
        // 檢查 bubble_ball 變量
        const bubbleColor = typeof window.bubble_ball !== "undefined" ? window.bubble_ball : null;
        console.log('泡泡顏色:', bubbleColor);
        
        ctx.fillStyle = hexToRgba(bubbleColor, Math.min(_this.alpha, 1)); //顏色
        ctx.fill();
      };
    }
  }
  
  window.addEventListener("load", i);
  