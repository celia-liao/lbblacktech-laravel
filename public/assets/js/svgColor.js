
    // 檢查必要的顏色變量是否存在
    if (typeof loading_color !== 'undefined') {
        // 設定 loading 顏色
        document.documentElement.style.setProperty("--loading-color", loading_color)
    }

    // 按鈕樣式設置
    function setupButtonStyle (button, color) {
        if (!button || !color) return
        button.style.backgroundColor = color
        button.style.outline = `5px solid ${color}`

        const hoverColor = lightenColor(color, 0.9)
        button.addEventListener("mouseenter", () => {
            button.style.backgroundColor = hoverColor
            button.style.outline = `5px solid ${hoverColor}`
        })
        button.addEventListener("mouseleave", () => {
            button.style.backgroundColor = color
            button.style.outline = `5px solid ${color}`
        })
    }

    function lightenColor (hex, opacity = 0.7) {
        if (!hex || typeof hex !== 'string') return 'rgba(0, 0, 0, 0.7)'
        const match = hex.match(/\w\w/g)
        if (!match || match.length < 3) return 'rgba(0, 0, 0, 0.7)'
        
        let [r, g, b] = match.map(x => parseInt(x, 16))
        return `rgba(${r}, ${g}, ${b}, ${opacity})`
    }

    // 只有在變量存在時才設置按鈕樣式
    if (typeof handshake_button !== 'undefined') {
        setupButtonStyle(document.querySelector(".main-bobs-buttons .hand"), handshake_button)
    }
    if (typeof videos_button !== 'undefined') {
        setupButtonStyle(document.querySelector(".main-bobs-buttons .feed"), videos_button)
    }

    // 設定標題顏色
    if (typeof title_color !== 'undefined') {
        [
            [".nav-logo-text-title", title_color],
            [".nav-logo-text-subtitle", title_color],
            [".main-film h2", title_color],
            [".right", title_color]
        ].forEach(([selector, color]) => {
            const el = document.querySelector(selector)
            if (el) el.style.color = color
        })

        document.querySelectorAll(".main-life-title-container h2").forEach(el => el.style.color = title_color)
    }

    // 設定 timeline 相關顏色
    if (typeof coverName_dayNumbers_dayTimeline !== 'undefined') {
        [
            [".coverName_dayNumbers_dayTimeline", "fill", coverName_dayNumbers_dayTimeline],
            ["#day", "color", coverName_dayNumbers_dayTimeline],
            [".day", "color", coverName_dayNumbers_dayTimeline],
            [".main-life-sticky-age-line .line", "backgroundColor", coverName_dayNumbers_dayTimeline],
            [".line-move", "backgroundColor", coverName_dayNumbers_dayTimeline]
        ].forEach(([selector, prop, color]) => {
            document.querySelectorAll(selector).forEach(el => {
                el.style[prop] = color
            })
        })

        const rippleColor = coverName_dayNumbers_dayTimeline + '88'

        document.querySelectorAll('.ripple-circle').forEach(el => {
            el.style.background = rippleColor
        })
    }

    // 設定 header_love 顏色
    if (typeof header_love !== 'undefined') {
        document.querySelectorAll(".header-love").forEach(el => el.setAttribute("fill", header_love))
    }

    // 設定 footer 相關顏色
    if (typeof footer_background !== 'undefined') {
        const sloganElement = document.querySelector("footer .slogan")
        if (sloganElement) {
            sloganElement.style.background = footer_background
        }
        const mainLetterElement = document.querySelector(".main-letter")
        if (mainLetterElement) {
            mainLetterElement.style.backgroundImage = `
                url("https://lbblacktech.com/assets/img/letter/direction.webp"),
                url("https://lbblacktech.com/assets/img/letter/background.webp"),
                linear-gradient(to bottom, #fff1e500, ${footer_background})
            `
        }
    }
    // const rightElement = document.querySelector(".right");
    // if (rightElement) {
    //     rightElement.style.background = footer_background;
    // }

    // 設定腳印顏色
    if (typeof header_footprint !== 'undefined') {
        document.querySelectorAll(".header-footprint").forEach(el => el.setAttribute("fill", header_footprint))
    } else {
        // 如果没有定义，使用粉红色
        document.querySelectorAll(".header-footprint").forEach(el => el.setAttribute("fill", "#FF69B4"))
    }
    console.log('footprint_all', footprint_all)
    if (typeof footprint_all !== 'undefined') {

        document.querySelectorAll(".footprint_all path").forEach(el => el.setAttribute("fill", footprint_all))
    } else {
        // 如果没有定义，使用浅粉红色
        document.querySelectorAll(".footprint_all path").forEach(el => el.setAttribute("fill", "#FFB6C1"))
    }

    // 設定 function 相關顏色
    if (typeof function_color !== 'undefined') {
        // 設定 `.function-svg` `fill` 顏色
        document.querySelectorAll(".function-svg").forEach(el => el.setAttribute("fill", function_color))
        // svg 邊框
        document.querySelectorAll(".function-stroke").forEach(el => el.setAttribute("stroke", function_color))
        // 音樂名稱
        const functionNameElement = document.querySelector(".function-content-name")
        if (functionNameElement) functionNameElement.style.color = function_color
        // 沉浸式觀賞
        const functionBrowseTitleElement = document.querySelector(".function-content-browse-title")
        if (functionBrowseTitleElement) functionBrowseTitleElement.style.color = function_color
    }

    if (typeof function_background !== 'undefined') {
        // function 顏色
        const functionHoverElement = document.querySelector(".function-hover")
        if (functionHoverElement) functionHoverElement.style.background = function_background
        const functionContentElement = document.querySelector(".function-content")
        if (functionContentElement) functionContentElement.style.borderTop = `4px solid ${function_background}`
    }

    // 設定 dayText_dayAge 相關顏色
    if (typeof dayText_dayAge !== 'undefined') {
        document.querySelectorAll(".main-life-scroll-container-slide h3, .main-life-scroll-container-slide h4, .main-life-scroll-container-slide h5, .line-dot")
            .forEach(el => el.style.color = dayText_dayAge)
    }

    // 設定背景顏色
    if (typeof bubble_background !== 'undefined') {
        const bubbleBackgroundElement = document.querySelector(".single-thumbnail-card")
        if (bubbleBackgroundElement) bubbleBackgroundElement.style.background = bubble_background
    }


// Footer 腳印動畫
document.addEventListener("DOMContentLoaded", () => {
    let hasStarted = false
    console.log(buttonStates)
    const targetSection = document.querySelector(".main-letter-footprint")

    if (!targetSection) return

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting && !hasStarted) {
            hasStarted = true

            const footprint = document.querySelector(".footer-footprint");
            if (footprint) {
                footprint.classList.add("animate");
            }

            // 檢查是否為非沉浸式手機模式
            const isMobile = window.innerWidth <= 768;
            
            // 需要從 new-scroll.js 中獲取 buttonStates 的值
            const isImmersiveMode = window.buttonStates === true;

            // 只在非沉浸式手機模式下執行優化邏輯
            if (isMobile && !isImmersiveMode) {
                optimizeMobileFootprintAnimation(footprint);
            }

            observer.disconnect()
        }
    }, {
        threshold: window.innerWidth <= 768 ? 0.1 : 0.3,
        rootMargin: window.innerWidth <= 768 ? "0px 0px -100px 0px" : "0px 0px -200px 0px"
    })

    observer.observe(targetSection)
})

// 優化手機版腳印動畫的函數
function optimizeMobileFootprintAnimation(footprintElement) {
    if (!footprintElement) return;

    // 獲取所有腳印元素
    const footprintGroups = footprintElement.querySelectorAll('g');
    if (footprintGroups.length === 0) return;

    // 獲取容器的位置信息
    const containerRect = footprintElement.getBoundingClientRect();
    const viewportHeight = window.innerHeight;

    // 找到第一個在視窗內可見的腳印元素
    let firstVisibleIndex = -1;
    
    footprintGroups.forEach((group, index) => {
        const groupRect = group.getBoundingClientRect();
        
        // 檢查元素是否在視窗內可見（至少部分可見）
        const isVisible = groupRect.top < viewportHeight && groupRect.bottom > 0;
        
        if (isVisible && firstVisibleIndex === -1) {
            firstVisibleIndex = index;
        }
    });

    // 如果沒有找到可見元素，使用第一個元素
    if (firstVisibleIndex === -1) {
        firstVisibleIndex = 0;
    }

    // 動態調整 CSS 動畫延遲
    footprintGroups.forEach((group, index) => {
        if (index === firstVisibleIndex) {
            // 第一個可見元素立即顯示（無延遲）
            group.style.animationDelay = '0s';
        } else if (index > firstVisibleIndex) {
            // 後續元素按順序延遲，但間隔更短
            const adjustedDelay = (index - firstVisibleIndex) * 0.1; // 20ms 間隔
            group.style.animationDelay = `${adjustedDelay}s`;
        } else {
            // 前面的元素也立即顯示
            group.style.animationDelay = '0s';
        }
    });

    // 可選：添加一個標記，表示已優化
    footprintElement.setAttribute('data-mobile-optimized', 'true');
}

// 監聽沉浸式模式切換
document.addEventListener('DOMContentLoaded', () => {
    const immersiveButton = document.querySelector('.go-down-scroll');
    const scrollArrow = document.querySelector('.go-down');
    
    // 監聽沉浸式模式按鈕點擊
    if (immersiveButton) {
        immersiveButton.addEventListener('click', () => {
            // 當切換到沉浸式模式時，重置腳印動畫
            setTimeout(() => {
                const footprint = document.querySelector('.footer-footprint');
                if (footprint && footprint.hasAttribute('data-mobile-optimized')) {
                    footprint.removeAttribute('data-mobile-optimized');
                    // 重置所有動畫延遲
                    const groups = footprint.querySelectorAll('g');
                    groups.forEach(group => {
                        group.style.animationDelay = '';
                    });
                }
            }, 100); // 稍微延遲以確保 buttonStates 已更新
        });
    }

    // 監聽退出沉浸式模式按鈕點擊
    if (scrollArrow) {
        scrollArrow.addEventListener('click', () => {
            // 當退出沉浸式模式時，重新應用優化（如果是手機版）
            setTimeout(() => {
                const isMobile = window.innerWidth <= 768;
                const isImmersiveMode = window.buttonStates === true;
                
                if (isMobile && !isImmersiveMode) {
                    const footprint = document.querySelector('.footer-footprint');
                    if (footprint && footprint.classList.contains('animate')) {
                        optimizeMobileFootprintAnimation(footprint);
                    }
                }
            }, 100);
        });
    }
});

// 信封逐字動畫
document.addEventListener("DOMContentLoaded", function () {
    const targetElement = document.querySelector(".main-letter-left-area-paper p")
    if (!targetElement) return

    // 先全部顯示
    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            targetElement.innerHTML = text // 直接顯示完整內容
            observer.disconnect() // 只觸發一次後停止觀察
        }
    }, {
        threshold: 0.3
    })

    // targetElement.innerHTML = ""; // 清空內容
    // let index = 0;
    // let hasStarted = false;

    // function typeEffect() {
    //     if (index < text.length) {
    //         const span = document.createElement("span");
    //         span.textContent = text.charAt(index);
    //         span.style.opacity = "0";
    //         span.style.animation = `fadeIn 0.5s ${index * 0.05}s forwards`; // 逐字淡入
    //         targetElement.appendChild(span);

    //         index++;
    //         requestAnimationFrame(() => setTimeout(typeEffect, 50)); // 控制速度
    //     }
    // }

    // const observer = new IntersectionObserver(entries => {
    //     if (entries[0].isIntersecting && !hasStarted) {
    //         hasStarted = true;
    //         typeEffect();
    //         observer.disconnect();
    //     }
    // }, { threshold: 0.3 });

    observer.observe(document.querySelector(".main-letter"))
})