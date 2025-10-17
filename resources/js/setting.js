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
    const corridor_videos = [];
    const corridor_image = [];
    const corridor_video = [];

    for (const event of data.life_slides) {
        corridor_image.push(event.life_slide_image);
        corridor_video.push(event.life_slide_video);
    }

    const minLength = Math.min(corridor_image.length, corridor_video.length)

    for (let i = 0; i < minLength; i++) {
        const imageName = corridor_image[i] || `film_${String(i + 1).padStart(2, '0')}.webp`
        const videoName = corridor_video[i] || `film_${String(i + 1).padStart(2, '0')}.mp4`

        corridor_images.push(imageName);
        corridor_videos.push(videoName);
    }



    window.corridor_images = corridor_images;
    window.corridor_videos = corridor_videos;
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
    
    // 檢查 bubble videos 是否存在
    if (!data.videos.bubble) {
        console.error('data.videos.bubble 不存在');
        return;
    }
    
    // 將 bubble 轉換為陣列（如果它是物件）
    let bubbleArray = data.videos.bubble;
    if (!Array.isArray(bubbleArray)) {
        // 如果是物件，轉換為陣列
        if (typeof bubbleArray === 'object' && bubbleArray !== null) {
            bubbleArray = Object.values(bubbleArray);
        } else {
            console.error('data.videos.bubble 無法轉換為陣列');
            return;
        }
    }
    
    // 所有可用的 bubble videos
    const allBubbleVideos = bubbleArray.map(video => {
        return {
            src: `${getImageBasePath()}/main/interaction/photo/${video.video_path}`,
            text: video.text,
            ratio: video.ratio,
            sound: video.sound,
        }
    })
    
    // 隨機選取兩個不同的影片
    window.bubble_videos = selectRandomVideos(allBubbleVideos, 2);
    
    // 根據選取的影片創建按鈕
    createDynamicButtons();
}

// 隨機選取指定數量的不同影片
function selectRandomVideos(videos, count) {
    if (!videos || videos.length === 0) {
        return [];
    }
    
    // 如果影片數量少於需要的數量，返回所有影片
    if (videos.length <= count) {
        return [...videos];
    }
    
    // 隨機打亂並選取前 count 個
    const shuffled = [...videos].sort(() => Math.random() - 0.5);
    return shuffled.slice(0, count);
}

// 根據選取的影片創建按鈕
function createDynamicButtons() {
    if (!window.bubble_videos || window.bubble_videos.length === 0) {
        return;
    }
    
    const buttonsContainer = document.querySelector('.main-bobs-buttons');
    if (!buttonsContainer) {
        return;
    }
    
    // 清除現有的 feed 和 hand 按鈕
    const existingButtons = buttonsContainer.querySelectorAll('button.feed, button.hand');
    existingButtons.forEach(button => button.remove());
    
    // 根據選取的影片創建按鈕
    window.bubble_videos.forEach((video, index) => {
        const button = document.createElement('button');
        // 所有按鈕都使用 feed 類名
        button.className = 'feed';
        button.textContent = video.text;
        button.dataset.videoIndex = index; // 儲存影片索引
        button.dataset.videoSrc = video.src;
        button.dataset.videoRatio = video.ratio;
        button.dataset.videoSound = video.sound;
        
        // 為第一個和第二個按鈕設定顏色
        if (index === 0 && window.handshake_button) {
            button.style.backgroundColor = window.handshake_button;
            button.style.outlineColor = window.handshake_button;
            button.style.outline = `5px solid ${window.handshake_button}`;
            button.style.border = `2px solid #fedfd1`;
        } else if (index === 1 && window.videos_button) {
            button.style.backgroundColor = window.videos_button;
            button.style.outlineColor = window.videos_button;
            button.style.outline = `5px solid ${window.videos_button}`;
            button.style.border = `2px solid #fedfd1`;
        }
        
        // 插入到 mute 按鈕之前
        const muteBtn = buttonsContainer.querySelector('.mute-feed');
        if (muteBtn) {
            buttonsContainer.insertBefore(button, muteBtn);
        } else {
            buttonsContainer.appendChild(button);
        }
    });
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




async function initializePetWebsite() {
    try {
        // loading 已在 HTML 中初始化，直接開始載入資料
        const data = await fetchPetData();
        
        await getWebsiteSetting(data);
        await getWebsiteStyle(data);
        await getTimeline(data);
        await getCorridor(data);
        await getVideoGallery(data);
        await getPhotoGallery(data);
        await getPet(data);
        
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



