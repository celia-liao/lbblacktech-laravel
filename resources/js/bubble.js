function hexToRgba(hex, alpha) {
  if (!hex) {
    return `rgba(255,210,213,${alpha})`; // �鞱身憿讛𠧧
  }

  let bigint = parseInt(hex.substring(1), 16);
  let r = (bigint >> 16) & 255;
  let g = (bigint >> 8) & 255;
  let b = bigint & 255;
  return `rgba(${r},${g},${b},${alpha})`;
}


  // �冽��詨�銝��见蔣��
  const randomIndex = Math.floor(Math.random() * bubble_videos.length);
  const selectedVideo = bubble_videos[randomIndex];

  document.dispatchEvent(new CustomEvent("videoSelected", { detail: selectedVideo }));

  // 閮剔蔭敶梁�
  const videoElement = document.querySelector(".main-video-area video");
  videoElement.src = selectedVideo.src;

  // �湔鰵�厰����
  // const feedButton = document.querySelector(".main-bobs-buttons .feed");
  // feedButton.textContent = selectedVideo.text;


  const videoArea = document.querySelector(".main-video-area");
  if (selectedVideo.ratio) {
    videoArea.classList.add(selectedVideo.ratio);
  }

  const muteBtn = document.getElementById("muteBtn");
  if (muteBtn) {
    if (selectedVideo.sound) {
      muteBtn.style.display = "block"; // �㕑��單�憿舐內
    } else {
      muteBtn.style.display = "none"; // �∟���黸��
    }
  }



function i() {
  var canvas,
    ctx,
    width,
    height,
    bubbles,
    animateHeader = true;
  initHeader();
  function initHeader() {
    canvas = document.getElementById("header_canvas");

    window_resize();
    ctx = canvas.getContext("2d");

    if (canvas.width === 0 || canvas.height === 0) {
      requestAnimationFrame(initHeader);
      return;
    }

    // �嘥��𡝗部瘜�
    bubbles = [];
    var num = width * 0.04;
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
    var panel = document.getElementById("thumbnail_canvas");
    width = panel.offsetWidth;
    height = panel.offsetHeight;

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

      _this.alpha = 0; // 敺𧼮��券�𤩺��见�
      _this.alpha_target = 0.1 + Math.random() * 0.9; // ��蝯��𤩺�摨�
      _this.alpha_change = 0.005 + Math.random() * 0.005; // 瘛∪��笔漲
      _this.scale = 0.2 + Math.random() * 1; // 瘞�部憭批�
      _this.scale_change = Math.random() * 0.002; // 瘞�部憭批�霈𠰴��笔漲
      _this.speed = 0.1 + Math.random() * 0.7; // 瘞�部銝𠰴��笔漲
      _this.scale = Math.min(_this.scale, 2.2);
    }

    // 蝜芾ˊ瘞�部
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
      ctx.fillStyle = hexToRgba(typeof bubble_ball !== "undefined" ? bubble_ball : null, Math.min(_this.alpha, 1)); //憿讛𠧧
      ctx.fill();
    };
  }
}

window.addEventListener("load", i);