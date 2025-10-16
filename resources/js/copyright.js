window.addEventListener("scroll", function () {
    const footerRight = document.querySelector("footer .right");
    const scrollPosition = window.scrollY + window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;

    if (scrollPosition >= documentHeight - 10) {
        footerRight.style.display = "block";
    } else {
        footerRight.style.display = "none";
    }
});