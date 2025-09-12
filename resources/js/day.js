function observeCounters() {
  const counter = document.getElementById("day");
  const counterArea = document.querySelector(".main-life-title-container-img");

  let currentNumber = 0;
  const increment = targetNumber / (duration / 16);

  function updateCounter() {
    currentNumber += increment;
    if (currentNumber >= targetNumber) {
      counter.textContent = targetNumber.toLocaleString();
    } else {
      counter.textContent = Math.floor(currentNumber).toLocaleString();
      requestAnimationFrame(updateCounter);
    }
  }

  const mutationObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (
        mutation.attributeName === "class" &&
        counterArea.classList.contains("aos-animate")
      ) {
        updateCounter();
        mutationObserver.disconnect();
      }
    });
  });

  mutationObserver.observe(counterArea, { attributes: true });
}

observeCounters();


// 歲數
const container = document.getElementById("line-dots-container");

const totalItems = lifeData.length;
document.documentElement.style.setProperty('--items-count', totalItems);

lifeData.forEach((item, index) => {
  const div = document.createElement("div");
  div.className = `line-dot line-dot-${index + 1}`;
  div.setAttribute("data-aos", "add-move");
  div.setAttribute("data-aos-duration", "800");
  div.setAttribute("data-index", index);
  
  const leftPercentage = (index / (totalItems - 1)) * 100;
  div.style.setProperty('--left-percentage', `${leftPercentage}%`);

  div.textContent = item.age;
  container.appendChild(div);
});

  

// 內容(圖片 文字)
const mainLifeScrollSlides = document.querySelector('.main-life-scroll-container-slides');

lifeData.forEach((item, index) => {
  const slide = document.createElement('div');
  slide.className = `main-life-scroll-container-slide life-${index + 1}`;
  slide.setAttribute('data-aos', 'add-move');
  slide.setAttribute('data-aos-duration', '800');

  if (item.title && item.text) {
    slide.innerHTML = `
      <div class="main-life-scroll-container-slide-left">
        <img src="${item.background}" alt="背景圖" />
        <span>
          <h4>${item.title}</h4>
          <h5>${item.text}</h5>
        </span>
      </div>
      <div class="main-life-scroll-container-slide-right">
        <a href="${item.originalImage}">
          <img src="${item.image}" alt="圖片" />
        </a>
      </div>
    `;
  } else if (item.ending) {
    slide.innerHTML = `
      <h3>${item.ending}</h3>
    `;
  }

  mainLifeScrollSlides.appendChild(slide);
});