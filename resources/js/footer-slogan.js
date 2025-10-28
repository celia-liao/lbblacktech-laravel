// ===========================
// 毛孩紀念網站 - 底部日曆動畫：點擊出現新日曆
// ===========================

const calendar = document.getElementById("footerCalendar");
const original = document.querySelector(".calendar-original");
const again = document.querySelector(".calendar-again");
const ripple = document.getElementById("rippleEffect");
const calendarDayText = document.getElementById("calendar-again-day");

// 點擊 footer-calendar 事件
if (calendar) {
    calendar.addEventListener("click", () => {
        // 隱藏 ripple 效果
        if (ripple) ripple.classList.add("ripple-hidden");

        // 播放原本日曆淡出動畫
        if (original) original.classList.add("fade-out");

        // 顯示新的日曆
        if (again) again.style.display = "block";
    });
}

// 日期計算與插入
if (typeof window.startDateStr !== "undefined") {
    const startDate = new Date(window.startDateStr);
    const today = new Date();
    const diffTime = today - startDate;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24) + 1);

    if (calendarDayText) {
        calendarDayText.textContent = `${diffDays}`;
    }
}

const footerConclusion = document.querySelector(".footer-conclusion");

if (calendar) {
    calendar.addEventListener("click", () => {
        if (ripple) ripple.classList.add("ripple-hidden");
        if (original) original.classList.add("fade-out");
        if (again) again.style.display = "block";

        if (footerConclusion) {
            setTimeout(() => {
                footerConclusion.classList.add("show");

                // 找到 h2 > span，延遲再讓 span 淡入
                const span = footerConclusion.querySelector("h2 span");
                if (span) {
                    setTimeout(() => {
                        span.classList.add("show-span");
                    }, 800); // 可以視情況調整延遲時間
                }
            }, 500);
        }
    });
}

// 立即執行初始化
(function initFooterDay() {
    const dayElement = document.querySelector(
        ".calendar-original .footer-time.day"
    );
    if (dayElement && typeof window.targetNumber !== "undefined") {
        dayElement.textContent = window.targetNumber;
    }
})();
