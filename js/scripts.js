const dropdownHeader = document.getElementById("duration-dropdown-header");
const dropdownList = document.getElementById("duration-dropdown-list");
const content = document.getElementById("content");
const weekLists = document.querySelectorAll(".week-list");
const durations = document.querySelectorAll(".tab-pane");
const carousels = document.querySelectorAll(".carousel");
const btn_prices = document.querySelectorAll('.sticky-results ul.results li');
const modale = document.querySelector(".modale_container");
const main = document.querySelector('main');
const sticky_outers = document.querySelectorAll(".sticky-results_outer");
const sticky_bgs = document.querySelectorAll(".sticky_bg");
let screenSize = "small";

const getCarouselProperties = (weekList) => {
  const currentContainerWidth = main.offsetWidth;
  const marginWidth = currentContainerWidth - 150 - 40;
  const visibleItemCount = Math.floor(marginWidth / 85.83);
  const carouselWidth = visibleItemCount* 85.83;
  return {
    'itemCount' : visibleItemCount,
    'containerWidth' : carouselWidth + 150,
    'carouselWidth' : carouselWidth,
  }

}

dropdownHeader.querySelector("span.selected_value").textContent =
  dropdownList.querySelector("li").textContent;

dropdownHeader.addEventListener("click", () => {
  dropdownList.classList.toggle("show");
  dropdownHeader.classList.toggle("active");
});

dropdownList.addEventListener("click", (event) => {
  if (event.target.tagName === "LI") {
    closeStickies();
    const selectedValue = event.target.getAttribute("data-value");

    const panels = content.querySelectorAll(".tab-pane");
    panels.forEach((pane) => {
      pane.classList.add("hidden");
    });

    const selectedDiv = content.querySelector(`[data-id="${selectedValue}"]`);
    selectedDiv.classList.remove("hidden");

    dropdownHeader.querySelector("span.selected_value").textContent =
      event.target.textContent;

    dropdownList.classList.remove("show");
    dropdownHeader.classList.remove("active");
  }
});

document.addEventListener("click", (event) => {

  if (event.target === modale || modale.contains(event.target)) return;
  if (
    !dropdownHeader.contains(event.target) &&
    !dropdownList.contains(event.target)
  ) {
    dropdownList.classList.remove("show");
    dropdownHeader.classList.remove("active");
  }

  if (
    !event.target.closest(".sticky-results.show") &&
    !event.target.closest(".result_price") &&
    screenSize === "small"
  ) {
    closeStickies();
  }
});

const closeStickies = () => {
  const currentPane = document.querySelector(".tab-pane:not(.hidden)");
  const stickies = currentPane.querySelectorAll(".sticky-results.show");
  
  stickies.forEach((sticky) => {
    const id = sticky.getAttribute("data-id");
    const price_btn = currentPane
      .querySelector(`.result[data-value="${id}"]`)
      .querySelector(".result_price");
    if (screenSize === "large") {
      const outer = currentPane.querySelector(".sticky-results_outer");
      const minHeight = outer.offsetHeight;
      outer.style.minHeight = `${minHeight}px`;
      setTimeout(() => {
        outer.style.minHeight = 0;
      }, 500);
    } else {
      const outer = currentPane.querySelector(".sticky-results_outer");
      outer.classList.remove('full');
    }
    price_btn.classList.remove("selected");
    sticky.classList.remove("show");
  });
};

durations.forEach((duration) => {
  const results = duration.querySelectorAll(".result");
  results.forEach((result) => {
    const weekValue = result.getAttribute("data-value");
    const relatedSticky = duration.querySelector(
      `.sticky-results[data-id="${weekValue}"]`
    );
    if (relatedSticky) {
      const price_btn = result.querySelector(".result_price");
      const closeStickyBtn = relatedSticky.querySelector(
        ".sticky-results__close-btn"
      );
      price_btn.addEventListener("click", () => {
        closeStickies();
        if (screenSize === "small") {
          const outer = duration.querySelector(".sticky-results_outer");
          outer.classList.add('full');
        }
        if (screenSize === "small") {
          relatedSticky.scrollIntoView({
            behavior: "smooth",
            block: "nearest",
            inline: "center",
          });
        }        
        relatedSticky.classList.add("show");
        price_btn.classList.add("selected");
      });
      closeStickyBtn.addEventListener("click", () => {
        if (screenSize === "small") {
          relatedSticky.classList.remove("show");
          price_btn.classList.remove("selected");
          const outer = duration.querySelector(".sticky-results_outer");
          outer.classList.remove('full');
        }
      });
    }
  });
});

const loadCarousel = () => {

  weekLists.forEach((weekList) => {

    const properties = getCarouselProperties(weekList);
    const wrapper = weekList.querySelector(".carousel-wrapper");
    const carousel = weekList.querySelector(".carousel");
    const prevBtn = weekList.querySelector(".carouselBtn.prev");
    const nextBtn = weekList.querySelector(".carouselBtn.next");
    const visibleItemCount = carousel.children.length < properties.itemCount ? carousel.children.length : properties.itemCount;
    let currentIndex = 0;
    const delay = 500;
    let isDragging = false;
    let mouseMove = false;
    let startPosition = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let sensitivity = 2;
    let currentPosition = 0;
    const currentTransition = window.getComputedStyle(carousel).transition;

    if (screenSize === 'large') {
      weekList.style.maxWidth = `${properties.containerWidth}px`;
      wrapper.style.maxWidth = `${properties.carouselWidth}px`;
      sticky_outers.forEach((sticky) => {
        sticky.style.maxWidth = `${properties.containerWidth}px`;
      })
      sticky_bgs.forEach((sticky) => {
        sticky.style.maxWidth = `${properties.containerWidth}px`;
      })
    } else {
      weekList.style.maxWidth = 'none';
      wrapper.style.maxWidth = 'none';
      sticky_outers.forEach((sticky) => {
        sticky.style.maxWidth = 'none';
      })
      sticky_bgs.forEach((sticky) => {
        sticky.style.maxWidth = 'none';
      })
    }   

    const clickHandler = (callback, delay) => {
      let lastClickTime = 0;
      let fastclick = false;

      return () => {
        const now = Date.now();
        if (now - lastClickTime < delay) {
          fastclick = true;
        } else {
          fastclick = false;
        }

        callback(fastclick);
        lastClickTime = now;
      };
    };

    nextBtn.addEventListener(
      "click",
      clickHandler((fastclick) => {
        if (fastclick) {
          if (
            currentIndex + visibleItemCount <
            carousel.children.length - visibleItemCount
          ) {
            currentIndex += visibleItemCount;
            updateCarousel();
          } else if (
            currentIndex + visibleItemCount <
            carousel.children.length
          ) {
            currentIndex = carousel.children.length - visibleItemCount;
            updateCarousel();
          }
        } else {
          if (currentIndex < carousel.children.length - visibleItemCount) {
            currentIndex++;
            updateCarousel();
          }
        }
      }, delay)
    );

    prevBtn.addEventListener(
      "click",
      clickHandler((fastclick) => {
        if (fastclick) {
          if (currentIndex - visibleItemCount >= 0) {
            currentIndex -= visibleItemCount;
            updateCarousel();
          } else {
            currentIndex = 0;
            updateCarousel();
          }
        } else {
          if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
          }
        }
      }, delay)
    );

    const toggleBtn = () => {
      const length = carousel.children.length;
      let classe = "";
      if (currentIndex === 0) {
        classe = "prev";
      } else if (currentIndex === length - visibleItemCount) {
        classe = "next";
      }
      weekList.querySelectorAll(".carouselBtn").forEach((btn) => {
        if (btn.classList.contains(classe)) {
          btn.classList.add("disabled");
        } else {
          btn.classList.remove("disabled");
        }
      });
    };

    const updateCarousel = () => {
      const itemWidth = carousel.querySelector(".carousel-item").offsetWidth;
      const translateX = -currentIndex * itemWidth;
      carousel.style.transform = `translateX(${translateX}px)`;
      prevTranslate = translateX;
      toggleBtn();
      return translateX;
    };

    updateCarousel();

    carousel.addEventListener("mousedown", (e) => {
      if (screenSize === "small") return;

      isDragging = true;
      startPosition = e.clientX;
      carousel.style.transition = "none";
    });

    carousel.addEventListener("mousemove", (e) => {

      if (screenSize === "small") return;
      if (!isDragging) return;

      carousel.querySelectorAll('.button_inner .icon').forEach((btn)=> {
        btn.style.opacity = "0";
      })
      mouseMove = true;
      currentPosition = e.clientX;
      const diff = currentPosition - startPosition;
      currentTranslate = prevTranslate + diff / sensitivity;
      carousel.style.transform = `translateX(${currentTranslate}px)`;
    });

    carousel.addEventListener("mouseup", (e) => {

      if (screenSize === "small") return;
      carousel.style.transition = currentTransition;
      if (!isDragging) return;
      isDragging = false;
      if (!mouseMove) return;
      mouseMove = false;

      const diff = (startPosition - currentPosition) / sensitivity;
      if (diff > 0) {
        const newIndex = Math.floor(diff / 40);
        if (currentIndex + newIndex < carousel.children.length - newIndex - visibleItemCount) {
          currentIndex = currentIndex + newIndex;
        } else if (currentIndex + visibleItemCount < carousel.children.length) {
          currentIndex = carousel.children.length - visibleItemCount;
        }
        prevTranslate = updateCarousel();
      } else if (diff < 0) {
        const newIndex = Math.ceil(diff / 40);
        if (currentIndex + newIndex > 0) {
          currentIndex = currentIndex + newIndex;
        } else {
          currentIndex = 0;
        }
        prevTranslate = updateCarousel();
      }

      setTimeout(() => {
        carousel.querySelectorAll('.button_inner .icon').forEach((btn)=> {
          btn.style.opacity = "1";
        })
      }, 500);
    });

    carousel.addEventListener("mouseleave", (e) => {
      if (screenSize === "small") return;
      if (isDragging) {
        carousel.dispatchEvent(new MouseEvent("mouseup"));
      }
    });
  });
};

btn_prices.forEach((btn) => {
  btn.addEventListener('click', () => {
    modale.classList.add('show');
    modale.querySelector('.modale_inner').scrollIntoView({
      behavior: "smooth",
      block: "start",
      inline: "center",
    });
    document.dispatchEvent(
      new CustomEvent("setIndex", {
        detail: { index: btn.querySelector('.sticky-result_price').getAttribute('option-value') },
      }),
    );
  })
})

modale.addEventListener('click', (event) => {
  const innerModale = modale.querySelector('.modale');
  if (event.target !==  innerModale && !innerModale.contains(event.target)) {
    modale.classList.remove('show');
  }
})
modale.querySelector('.modale__close-btn').addEventListener('click', (event) => {
    modale.classList.remove('show');
})

const updateScreenSize = () => {
  screenSize = window.innerWidth >= 700 ? "large" : "small";
  loadCarousel();
};

window.onresize = updateScreenSize;
updateScreenSize();

loadCarousel();

const loadOffersCarousel = () => {
  const offersCarousel = document.querySelector('.offers_carousel');

  if (!offersCarousel) return;
  const offersContainer = offersCarousel.querySelector('.offers_carousel-container');
  const currentTransition = window.getComputedStyle(offersContainer).transition;
  const items = offersCarousel.querySelectorAll('.offers_carousel-item');
  const prevButton = offersCarousel.querySelector('.dot.prev:not(.active)');
  const nextButton = offersCarousel.querySelector('.dot.next:not(.active)');
  const goToButton = offersCarousel.querySelector('.goto-essential');
  let isDragging = false;
  let startPosition = null;

  let currentIndex = 0;

  document.addEventListener(
    "setIndex",
      (e) => {
        const option = e.detail.index;
        offersContainer.style.transition = "none";
        if (option === 'a') {
          goToSlide(0);
        } else if (option === 'b') {
          goToSlide(1);
        }
        offersContainer.style.transition = currentTransition;
      },
      false,
    );

  offersContainer.addEventListener("mousedown", (e) => {
      isDragging = true;
      startPosition = e.clientX;
    });

    offersContainer.addEventListener("mousemove", (e) => {
  
      if (isDragging) {
        
        const newPosition = e.clientX;
        if (newPosition < startPosition) {
          if (currentIndex !== 1) goToSlide(1);
        } else if (newPosition > startPosition) {
          if (currentIndex !== 0) goToSlide(0);
        }
      }
    });
  
    offersContainer.addEventListener("mouseup", (e) => {
  
      if (isDragging) {
        isDragging = false;
        startPosition = null;
      }
  
    });
  
    offersContainer.addEventListener("mouseleave", (e) => {
      if (isDragging) {
        offersContainer.dispatchEvent(new MouseEvent("mouseup"));
      }
    });
  

  const goToSlide = (index) => {
    currentIndex = index;
    const translateX = -currentIndex * 100;
    offersContainer.style.transform = `translateX(${translateX}%)`;
    offersContainer.scrollIntoView({
      behavior: "smooth",
      block: "start",
      inline: "center",
    });
  }

  prevButton.addEventListener('click', () => {
    if (currentIndex === 1) {
      goToSlide(0);
    }
  });

  nextButton.addEventListener('click', () => {
    if (currentIndex === 0) {
      goToSlide(1);
    }
  });

  goToButton.addEventListener('click', () => {
    if (currentIndex === 0) {
      goToSlide(1);
    }
  });
}

loadOffersCarousel();


forceLandscapeOrientation = () => {
  if (window.screen.orientation) {
    screen.orientation.lock('landscape');
  }
}

const modalImage = document.querySelector('.offer_img-container');
if (modalImage) {
  modalImage.addEventListener('click', () => {

    const img = modale.querySelector('.img_container');
    img.classList.toggle('large');
    
    forceLandscapeOrientation();
  });
}