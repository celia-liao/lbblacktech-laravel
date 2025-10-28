// ===========================
// 毛孩紀念網站 - 共用設定檔
// ===========================

// 獲取當前頁面的 slug
function getCurrentSlug() {
    // 從 URL 路徑中提取 slug
    const path = window.location.pathname;
    const slug = path.substring(1); // 移除開頭的 /
    return slug || 'ruby-20130701'; // 預設值
}

// 獲取圖片基礎路徑
function getImageBasePath() {
    // 優先使用從 Blade 傳遞的路徑
    if (window.PET_ASSETS && window.PET_ASSETS.imagePath) {
        return window.PET_ASSETS.imagePath;
    }
    // 備用方案：從 URL 生成路徑
    const slug = getCurrentSlug();
    return `/storage/pets/${slug}/image`;
}

// API 調用函數
async function fetchPetData() {
    try {
        const slug = getCurrentSlug();
        
        const response = await fetch(`/api/pet-data/${slug}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            return result.data;
        } else {
            throw new Error(result.message || 'API 回應錯誤');
        }
    } catch (error) {
        throw error;
    }
}

// 網站設定
async function getWebsiteSetting(data) {
    window.targetNumber = data.website_setting.target_number;
    window.duration = data.website_setting.duration;
    window.pictureNum = data.website_setting.corridor_random_image_count;
    window.startDateStr = data.website_setting.creation_date;
    document.querySelector(".footer-time").textContent = targetNumber;
}

// 網站樣式
async function getWebsiteStyle(data) {
    window.loading_color = data.website_style.loading_color;
    window.coverName_dayNumbers_dayTimeline = data.website_style.cover_name_color;
    window.header_love = data.website_style.header_love_color;
    window.header_footprint = data.website_style.header_footprint_color;
    window.dayText_dayAge = data.website_style.day_text_color;
    window.title_color = data.website_style.title_color;
    window.handshake_button = data.website_style.handshake_button_color;
    window.videos_button = data.website_style.videos_button_color;
    window.bubble_ball = data.website_style.bubble_ball_color;
    window.bubble_background = data.website_style.bubble_background;
    window.footprint_all = data.website_style.footprint_color;
    window.footer_background = data.website_style.footer_background_color;
    window.function_color = data.website_style.function_color;
    window.function_background = data.website_style.function_background_color;
    
    // 設定 main-letter 的背景色
    const mainLetterElement = document.querySelector('main .main-letter');
    if (mainLetterElement && window.footer_background) {
        mainLetterElement.style.backgroundImage = `url("https://lbblacktech.com/assets/img/letter/direction.webp"), url("https://lbblacktech.com/assets/img/letter/background.webp"), linear-gradient(to bottom, rgba(255, 241, 229, 0), ${window.footer_background})`;
    }
}

// 生命軌跡
async function getTimeline(data) {
    const lifeData = [];
    for (const event of data.timeline) {
        if(!event.is_ending) {
            let obj = {
                age: event.age,
                title: event.event_title,
                text: event.event_description,
                background: `${getImageBasePath()}/main/life/background/${event.background}`,
                image: `${getImageBasePath()}/main/life/photo/${event.event_photo}`,
                originalImage: `${getImageBasePath()}/main/life/photo/original/${event.original_image}`
            }
            lifeData.push(obj);
        } else {
            let obj = {
                age: event.age,
                ending: event.event_title,
            }
            lifeData.push(obj);
        }
    }
    window.lifeData = lifeData;
}

// 記憶迴廊
async function getCorridor(data) {

    const corridor_images = []
    const corridor_medias = [];
    const corridor_image = [];
    const corridor_media = [];

    for (const event of data.life_slides) {
        corridor_image.push(event.life_slide_image);
        corridor_media.push(event.life_slide_media);
    }

    const minLength = Math.min(corridor_image.length, corridor_media.length)

    for (let i = 0; i < minLength; i++) {
        const imageName = corridor_image[i] || `film_${String(i + 1).padStart(2, '0')}.webp`
        const videoName = corridor_media[i] 

        corridor_images.push(imageName);
        corridor_medias.push(videoName);
    }



    window.corridor_images = corridor_images;
    window.corridor_videos = corridor_medias;
}

// 照片資料 (用相片集)
async function getPhotoGallery(data) {

    // 封面照片
    window.header_imageList = data.photos.header.map(image => {
        return `${getImageBasePath()}/header/photo/${image}`;
    });


    // 泡泡照片
    const bubble_images_small = data.photos.bubble_small || []
    const bubble_images_large = data.photos.bubble_large || []
    
    const bubble_imagePaths = []
    
    const maxLength = Math.max(bubble_images_small.length, bubble_images_large.length)
    
    for (let i = 0; i < maxLength; i++) {
        const imageName = bubble_images_small[i] || `bubble_${String(i + 1).padStart(2, '0')}.webp`
        const largeImageName = bubble_images_large[i] || `bubble_${String(i + 1).padStart(2, '0')}.webp`

        
        bubble_imagePaths.push({
            large: `${getImageBasePath()}/main/bobs/photo/original/${largeImageName}`,
            small: `${getImageBasePath()}/main/bobs/photo/${imageName}`
        });
    }
    
    window.bubble_imagePaths = bubble_imagePaths;

    window.dispatchEvent(new CustomEvent('bubbleImagesReady', { 
        detail: { bubble_imagePaths } 
    }));
    
    updateBubbleImages(bubble_imagePaths);
}

// 直接更新泡泡图片的函数
function updateBubbleImages(bubble_imagePaths) {
    
    if (!bubble_imagePaths || bubble_imagePaths.length === 0) {
        return;
    }

    // 随机选择4张图片
    const randomImages = bubble_imagePaths.sort(() => 0.5 - Math.random()).slice(0, 4);

    // 查找所有泡泡元素
    const allBobs = document.querySelectorAll(".main-bobs-area-box a");

    allBobs.forEach((item, index) => {
        const selectedImage = randomImages[index];
        const img = item.querySelector("img");

        if (selectedImage && img) {
            item.href = selectedImage.large;
            item.setAttribute("data-pswp-src", selectedImage.large);
            // 添加 Fancybox 屬性
            item.setAttribute("data-fancybox", "bubble-gallery");
            img.src = selectedImage.small;
        }
    });

}

async function getVideoGallery(data) {
    // 封面影片 - 轉換為完整路徑的數組
    if (data.videos && data.videos.header) {
        let headerArray = data.videos.header;
        
        // 如果不是數組，嘗試轉換
        if (!Array.isArray(headerArray)) {
            if (typeof headerArray === 'object' && headerArray !== null) {
                headerArray = Object.values(headerArray);
            } else {
                headerArray = [];
            }
        }
        
        // 處理每個項目，生成完整路徑
        window.header_videos = headerArray.map(video => {
            // 如果是字符串，直接加上基礎路徑
            if (typeof video === 'string') {
                return `${getImageBasePath()}/header/photo/${video}`;
            }
            // 如果是對象，取出 video_path
            return `${getImageBasePath()}/header/photo/${video.video_path || video}`;
        });
    } else {
        window.header_videos = [];
    }
}

async function getPet(data) {
    // 毛孩名字
    const petNameElement = document.querySelector(".main-img-name-area-pet");
    if (petNameElement) {
        petNameElement.textContent = data.pet.pet_name;
    }

    // 標語
    const sloganElement = document.querySelector(".main-img-area-slogan h1");
    if (sloganElement) {
        sloganElement.innerHTML = data.pet.slogan;
    }

    // 信件內容
    const letterContent = data.letter.letter_content;
    if (letterContent) {
        const letterTextElement = document.querySelector(".main-letter-left-area-paper p");
        if (letterTextElement) {
            letterTextElement.innerHTML = letterContent;
        }
    }
}

// 按鈕資料
async function getPetButtons(data) {
    const petButtons = data.pet_buttons;

    if (!petButtons || petButtons.length === 0) {
        return;
    }

    const buttonsContainer = document.querySelector('.main-bobs-buttons');
    if (!buttonsContainer) {
        return;
    }

    // 清除現有的按鈕（保留 mute 按鈕）
    const existingButtons = buttonsContainer.querySelectorAll('button:not(.mute-feed)');
    existingButtons.forEach(button => button.remove());

    // 如果陣列裡有圖片就這樣創建一個圖片按鈕＋一個影片按鈕
    if (petButtons.some(button => button.button_type === 'image')) {
        const imageButtonData = petButtons.find(button => button.button_type === 'image');
        const imageButton = document.createElement('button');
        imageButton.className = 'hand';
        imageButton.innerHTML = imageButtonData.button_text;
        imageButton.dataset.buttonId = imageButtonData.button_id;
        imageButton.dataset.buttonType = 'image';
        imageButton.dataset.mediaPath = imageButtonData.media_path;
        buttonsContainer.appendChild(imageButton);

        // 從所有影片按鈕中隨機挑選一個
        const videoButtons = petButtons.filter(button => button.button_type === 'video');
        if (videoButtons.length > 0) {
            const randomIndex = Math.floor(Math.random() * videoButtons.length);
            const videoButtonData = videoButtons[randomIndex];
            
            const videoButton = document.createElement('button');
            videoButton.className = 'feed';
            videoButton.innerHTML = videoButtonData.button_text;
            videoButton.dataset.buttonId = videoButtonData.button_id;
            videoButton.dataset.buttonType = 'video';
            videoButton.dataset.mediaPath = videoButtonData.media_path;
            videoButton.dataset.videoRatio = videoButtonData.ratio;
            videoButton.dataset.videoSound = videoButtonData.sound;
            buttonsContainer.appendChild(videoButton);
        }
    }
    // 如果陣列裡面全是影片就隨便挑兩個影片做成影片按鈕
    else if (petButtons.every(button => button.button_type === 'video')) {
        const videoButtons = petButtons.sort(() => 0.5 - Math.random()).slice(0, 2);
        videoButtons.forEach(buttonData => {
            const videoButton = document.createElement('button');
            videoButton.className = 'feed';
            videoButton.innerHTML = buttonData.button_text;
            videoButton.dataset.buttonId = buttonData.button_id;
            videoButton.dataset.buttonType = 'video';
            videoButton.dataset.mediaPath = buttonData.media_path;
            videoButton.dataset.videoRatio = buttonData.ratio;
            videoButton.dataset.videoSound = buttonData.sound;
            buttonsContainer.appendChild(videoButton);
        });
    }

    // 根據當前顯示的影片按鈕的 sound 設定來初始化 mute 按鈕狀態
    const muteBtn = document.querySelector("#muteBtn");
    if (muteBtn) {
        // 檢查當前顯示的影片按鈕是否有聲音
        const displayedVideoButtons = buttonsContainer.querySelectorAll('button.feed[data-video-sound]');
        let hasVideoWithSound = false;
        
        displayedVideoButtons.forEach(button => {
            const videoSound = button.dataset.videoSound === 'true';
            if (videoSound) {
                hasVideoWithSound = true;
            }
        });
        
        if (hasVideoWithSound) {
            // 有影片有聲音，顯示靜音圖標（因為影片一開始是靜音的）
            muteBtn.style.visibility = "visible";
            muteBtn.style.opacity = 1;
            const muteBtnImg = muteBtn.querySelector('img');
            if (muteBtnImg) {
                muteBtnImg.src = `${window.PET_ASSETS.iconPath}/volume-xmark-solid.svg`;
            }
        } else {
            // 沒有影片有聲音，隱藏 mute 按鈕
            muteBtn.style.visibility = "hidden";
            muteBtn.style.opacity = 0;
        }
    }
}


async function initializePetWebsite() {
    try {
        // 初始化時隱藏 mute 按鈕
        const muteBtn = document.querySelector("#muteBtn");
        if (muteBtn) {
            muteBtn.style.visibility = "hidden";
            muteBtn.style.opacity = 0;
        }
        
        // loading 已在 HTML 中初始化，直接開始載入資料
        const data = await fetchPetData();
        
        await getWebsiteSetting(data);
        await getWebsiteStyle(data);
        await getTimeline(data);
        await getCorridor(data);
        await getVideoGallery(data);
        await getPhotoGallery(data);
        await getPet(data);
        await getPetButtons(data);

        await import(window.PET_ASSETS.jsFiles.day);
        await import(window.PET_ASSETS.jsFiles.newScroll);
        await import(window.PET_ASSETS.jsFiles.lifeSlides);
        await import(window.PET_ASSETS.jsFiles.main);
        
        // 等待一下确保 main.js 的事件监听器已经设置
        await new Promise(resolve => setTimeout(resolve, 100));

        await import(window.PET_ASSETS.jsFiles.videoOrImg);
        await import(window.PET_ASSETS.jsFiles.bubble);
        await import(window.PET_ASSETS.jsFiles.svgColor);
        await import(window.PET_ASSETS.jsFiles.footerSlogan);
        await import(window.PET_ASSETS.jsFiles.utm);
        await import(window.PET_ASSETS.jsFiles.music);
        await import(window.PET_ASSETS.jsFiles.function);
        await import(window.PET_ASSETS.jsFiles.copyright);
        
        // 觸發生命軌跡事件
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('lifeSlidesReady'));
        }, 2000);
    } catch (err) {
        console.error('initializePetWebsite 發生錯誤:', err);
        console.error('錯誤堆疊:', err.stack);
    }
}

// DOM Ready 後啟動
document.addEventListener("DOMContentLoaded", () => {
    // 載入完整的 loading2.js 來處理 loading 移除
    import(window.PET_ASSETS.jsFiles.loading2);

    initializePetWebsite();
});



