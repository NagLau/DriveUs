document
  .getElementById("contact-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;
    if (name && email && message) {
      var subject = "Kapcsolatfelvétel - " + name;
      var body =
        "Név: " +
        name +
        "\n" +
        "E-mail: " +
        email +
        "\n\n" +
        "Üzenet:\n" +
        message;
      var mailtoLink =
        "mailto:driveus.car.rent@gmail.com?subject=" +
        encodeURIComponent(subject) +
        "&body=" +
        encodeURIComponent(body);
      window.location.href = mailtoLink;
      document.getElementById("contact-form").reset();
      alert("Üzenet elküldve! Hamarosan válaszolunk.");
    } else {
      alert("Kérjük, töltse ki az összes mezőt!");
    }
  });

function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    { pageLanguage: "hu" },
    "google_translate_element"
  );
}

document.addEventListener("DOMContentLoaded", () => {

  const menuIcon = document.querySelector('.menu-icon');
  const closeIcon = document.querySelector('.close-icon');
  const nav = document.querySelector('header nav');

  if (menuIcon && closeIcon && nav) {
    menuIcon.addEventListener('click', function() {
      nav.classList.add('active');
      console.log("Hamburger menü megnyitva");
    });

    closeIcon.addEventListener('click', function() {
      nav.classList.remove('active');
      console.log("Hamburger menü bezárva");
    });
  } else {
    console.error("Hiba: A menu-icon, close-icon vagy nav elem nem található!");
  }
});