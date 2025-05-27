document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM fully loaded and parsed'); 

  const menuIcon = document.querySelector('.menu-icon');
  const closeIcon = document.querySelector('.close-icon');
  const nav = document.querySelector('header nav');

  if (!menuIcon) {
    console.error('Menu icon not found!');
    return;
  }

  if (!closeIcon) {
    console.error('Close icon not found!');
    return;
  }

  if (!nav) {
    console.error('Navigation not found!');
    return;
  }

  console.log('Menu icon, close icon, and nav found'); 

  menuIcon.addEventListener('click', () => {
    console.log('Menu icon clicked'); 
    nav.classList.add('active');
  });

  closeIcon.addEventListener('click', () => {
    console.log('Close icon clicked'); 
    nav.classList.remove('active');
  });

  const navLinks = nav.querySelectorAll("a");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      console.log("Nav link clicked");
      nav.classList.remove("active");
    });
  });

  let currentSlide = 0;
  const slides = document.querySelectorAll(".slide");
  let autoSlideInterval;

  function moveSlide(direction) {
    slides[currentSlide].classList.remove("active");
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    slides[currentSlide].classList.add("active");
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      moveSlide(1);
    }, 4000);
  }

  if (slides.length > 0) {
    slides[0].classList.add("active");
    startAutoSlide();
  }

  const prevButton = document.getElementById("elozo");
  const nextButton = document.getElementById("kovetkezo");

  if (prevButton) {
    prevButton.addEventListener("click", () => {
      clearInterval(autoSlideInterval);
      moveSlide(-1);
      setTimeout(startAutoSlide, 4000);
    });
  }

  if (nextButton) {
    nextButton.addEventListener("click", () => {
      clearInterval(autoSlideInterval);
      moveSlide(1);
      setTimeout(startAutoSlide, 4000);
    });
  }

  const cards = document.querySelectorAll(".card");
  const fullTextOverlay = document.createElement("div");
  fullTextOverlay.classList.add("full-text-overlay");
  document.body.appendChild(fullTextOverlay);

  cards.forEach((card) => {
    card.addEventListener("click", function () {
      const fullText = card.querySelector("p").innerText;
      const fullTextContainer = document.createElement("div");
      fullTextContainer.classList.add("full-text-container");
      fullTextContainer.innerHTML = `<p>${fullText}</p>`;
      fullTextOverlay.innerHTML = "";
      fullTextOverlay.appendChild(fullTextContainer);
      fullTextOverlay.style.display = "flex";
    });
  });

  fullTextOverlay.addEventListener("click", function () {
    fullTextOverlay.style.display = "none";
  });
});