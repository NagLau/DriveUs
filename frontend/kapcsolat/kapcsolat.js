document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;
            if (name && email && message) {
                var subject = "Kapcsolatfelvétel - " + name;
                var body = "Név: " + name + "\n" +
                           "E-mail: " + email + "\n\n" +
                           "Üzenet:\n" + message;
                var mailtoLink = "mailto:driveus.car.rent@gmail.com?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                window.location.href = mailtoLink;
                document.getElementById('contact-form').reset();
                alert('Üzenet elküldve! Hamarosan válaszolunk.');
            } else {
                alert('Kérjük, töltse ki az összes mezőt!');
            }
        });
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }