// 抓網址參數
const urlParams = new URLSearchParams(window.location.search);

// 取得 utm_medium，若無則預設為 'link'
const utmMedium = urlParams.get('utm_medium') || 'link';

// 取得 utm_source，若無則從子網域或 pathname 推斷
let utmSource = urlParams.get('utm_source');

if (!utmSource) {
  // 嘗試從子網域取得
  const hostname = window.location.hostname; // e.g., "length-20181225.lbblacktech.com"
  const subdomain = hostname.split('.')[0];  // e.g., "length-20181225"
  utmSource = subdomain.split('-')[0] || 'unknown'; // e.g., "length"
}

// 更新 a 連結 href
const link = document.getElementById('dynamic-link');
if (link) {
  const originalUrl = new URL(link.href);
  originalUrl.searchParams.set('utm_source', utmSource);
  originalUrl.searchParams.set('utm_medium', utmMedium);
  link.href = originalUrl.toString();
}
