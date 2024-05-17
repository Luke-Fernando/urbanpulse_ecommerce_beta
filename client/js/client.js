class Client {

    constructor() { }

    scrollProducts() {
        const scrollTargetItems = document.querySelectorAll("[data-product-move-target]");
        const scrollTargets = [...scrollTargetItems];
        scrollTargets.forEach((target) => {
            if (target != null) {
                let parent = target.parentNode;
                let targetAttVal = target.getAttribute("data-product-move-target");
                let leftBtn = document.querySelector(`[data-product-move-left="${targetAttVal}"]`);
                let rightBtn = document.querySelector(`[data-product-move-right="${targetAttVal}"]`);
                let startPos;
                let endPos;
                let marginLeft = 0;

                // btn click
                leftBtn.addEventListener("click", function () {
                    if (marginLeft < -100) {
                        marginLeft = marginLeft + 100;
                        target.style.marginLeft = `${marginLeft}%`;
                    } else if (marginLeft == -100) {
                        marginLeft = marginLeft + 100;
                        target.style.marginLeft = `${marginLeft}px`;
                    }
                });
                rightBtn.addEventListener("click", function () {
                    let targetWidth = target.offsetWidth;
                    let parentWidth = parent.offsetWidth;
                    let showAmount = parentWidth + ((marginLeft * -1) / 100) * parentWidth;
                    if (parentWidth < targetWidth && showAmount < targetWidth) {
                        marginLeft = marginLeft - 100;
                        target.style.marginLeft = `${marginLeft}%`;
                    }
                });
                // btn click
                // touch
                parent.addEventListener("touchstart", function (e) {
                    startPos = [...e.changedTouches][0].pageX;
                });
                parent.addEventListener("touchend", function (e) {
                    let targetWidth = target.offsetWidth;
                    let parentWidth = parent.offsetWidth;
                    endPos = [...e.changedTouches][0].pageX;
                    let touchDistance = endPos - startPos;
                    if (touchDistance <= -30) {
                        let showAmount = parentWidth + ((marginLeft * -1) / 100) * parentWidth;
                        if (parentWidth < targetWidth && showAmount < targetWidth) {
                            marginLeft = marginLeft - 100;
                            target.style.marginLeft = `${marginLeft}%`;
                        }
                    }
                    if (touchDistance >= 30) {
                        if (marginLeft < -100) {
                            marginLeft = marginLeft + 100;
                            target.style.marginLeft = `${marginLeft}%`;
                        } else if (marginLeft == -100) {
                            marginLeft = marginLeft + 100;
                            target.style.marginLeft = `${marginLeft}px`;
                        }
                    }
                });
                // touch
            }
        });
    }

    changeBannerHome() {
        const bannerNavigators = document.querySelectorAll("[banner-arrow]");
        const banners = document.querySelectorAll("[data-banner]");
        const mainBanner = document.getElementById("main-banner");
        let banner = 0;
        let currentMargin = 0;

        if (mainBanner != null) {
            bannerNavigators.forEach((navigator) => {
                if (navigator != null) {
                    navigator.addEventListener("click", function () {
                        let navigateDirection = navigator.getAttribute("banner-arrow");
                        if (navigateDirection == "right") {
                            if (banner == banners.length - 1) {
                                banner = 0;
                            } else {
                                banner++;
                            }
                        } else if (navigateDirection == "left") {
                            if (banner == 0) {
                                banner = banners.length - 1;
                            } else {
                                banner--;
                            }
                        }
                        currentMargin = 0;
                        currentMargin = currentMargin + 100 * banner;
                        mainBanner.style.marginLeft = `-${currentMargin}%`;
                    });
                }
            });

            setInterval(function () {
                if (banner == banners.length - 1) {
                    banner = 0;
                } else {
                    banner++;
                }
                currentMargin = 0;
                currentMargin = currentMargin + 100 * banner;
                mainBanner.style.marginLeft = `-${currentMargin}%`;
            }, 5000);
        }
    }

    changeProductImage() {
        const selectors = document.querySelectorAll("[data-product-image-selector]");
        const primaryImg = document.querySelector("[data-image-primary]");
        selectors.forEach((selector) => {
            if (selector != null) {
                selector.addEventListener("click", event => {
                    let image = event.target.querySelector("img");
                    let source = image.getAttribute("src");
                    let primaryImage = primaryImg.querySelector("img");
                    primaryImage.setAttribute("src", source);
                })
            }
        })
    }
}


export default Client;