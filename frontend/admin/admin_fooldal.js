let cars = JSON.parse(localStorage.getItem('cars')) || [
    { name: "Lamborghini Huracán", type: "sport", color: "zold", brand: "lamborghini", image: "../kepek/lambo.jpg", details: ["5.2L V10 motor", "631 LE", "0-100 km/h 2,9 másodperc", "Exkluzív olasz dizájn, lenyűgöző teljesítménnyel", "Luxus beltér, versenypályára optimalizált technológia"] },
    { name: "Toyota Camry", type: "csaladi", color: "fekete", brand: "toyota", image: "../kepek/toyota_camry.jpg", details: ["Hibrid motor", "208 LE", "2018–2023", "Alacsony fogyasztás, kiváló városi és autópályás vezetéshez", "Tágas, kényelmes belső tér prémium anyagokkal", "Adaptív tempomat és fejlett vezetéstámogató rendszerek"] },
    { name: "Aston Martin D9", type: "luxus", color: "szurke", brand: "astonmartin", image: "../kepek/bkep1.jpg", details: ["V12 szívómotor", "450–517 LE", "2004–2016", "Ikonikus brit luxusautó, elegáns és sportos megjelenással", "0-100 km/h 4,2 másodperc alatt, kézi és automata váltóval", "Bőr és karbon betétes belső tér, prémium hifi rendszerrel"] },
    { name: "Toyota Supra", type: "sport", color: "piros", brand: "toyota", image: "../kepek/bkep2.jpg", details: ["3.0L szívómotor", "280–320 LE", "2002–2020", "Hátsókerék-meghajtás, dinamikus vezetési élmény", "Legendás japán sportautó, kiváló teljesítménnyel és megbízhatósággal", "Állítható sportfutómű és aerodinamikus dizájn"] },
    { name: "Mercedes-Benz G63 AMG", type: "luxus", color: "fekete", brand: "mercedes", image: "../kepek/benz.jpg", details: ["4.0L V8 biturbó", "577 LE", "2019–2024", "Ikonikus off-road jármű, luxus és teljesítmény egyben", "Exkluzív belső tér, fűthető ülések és high-end hifi rendszer", "Összkerékhajtás és három differenciálzár a legkeményebb terepre"] },
    { name: "Tesla Model S Plaid", type: "luxus", color: "feher", brand: "tesla", image: "../kepek/tesla.jpg", details: ["Elektromos hajtás", "1020 LE", "2021–jelen", "0-100 km/h 2,1 másodperc alatt, futurisztikus technológia", "600+ km hatótáv, gyorstöltési lehetőség", "Full önvezető funkciók és központi érintőképernyő"] }
];

let archivedCars = JSON.parse(localStorage.getItem('archivedCars')) || [];

document.getElementById('usersLink').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('content').innerHTML = '';
});

document.getElementById('carsLink').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('content').innerHTML = `
        <h1>Autók Kezelése</h1>
        <div class="car-management">
            <div class="car-form">
                <h3>Új autó hozzáadása</h3>
                <label for="carName">Autó neve:</label>
                <input type="text" id="carName" placeholder="Pl. Lamborghini Huracán">
                <label for="carType">Típus:</label>
                <select id="carType">
                    <option value="sport">Sport autó</option>
                    <option value="csaladi">Családi autó</option>
                    <option value="teher">Teher autó</option>
                    <option value="luxus">Luxus autó</option>
                </select>
                <label for="carColor">Szín:</label>
                <select id="carColor">
                    <option value="fekete">Fekete</option>
                    <option value="feher">Fehér</option>
                    <option value="piros">Piros</option>
                    <option value="szurke">Szürke</option>
                    <option value="kek">Kék</option>
                    <option value="zold">Zöld</option>
                </select>
                <label for="carBrand">Márka:</label>
                <select id="carBrand">
                    <option value="lamborghini">Lamborghini</option>
                    <option value="toyota">Toyota</option>
                    <option value="astonmartin">Aston Martin</option>
                    <option value="mercedes">Mercedes-Benz</option>
                    <option value="tesla">Tesla</option>
                    <option value="audi">Audi</option>
                    <option value="bmw">BMW</option>
                    <option value="porsche">Porsche</option>
                    <option value="ferrari">Ferrari</option>
                    <option value="volkswagen">Volkswagen</option>
                    <option value="ford">Ford</option>
                    <option value="chevrolet">Chevrolet</option>
                    <option value="honda">Honda</option>
                    <option value="nissan">Nissan</option>
                    <option value="hyundai">Hyundai</option>
                    <option value="kia">Kia</option>
                    <option value="jaguar">Jaguar</option>
                    <option value="landrover">Land Rover</option>
                    <option value="lexus">Lexus</option>
                    <option value="mazda">Mazda</option>
                    <option value="subaru">Subaru</option>
                    <option value="volvo">Volvo</option>
                    <option value="bentley">Bentley</option>
                    <option value="rollsroyce">Rolls-Royce</option>
                    <option value="mclaren">McLaren</option>
                    <option value="bugatti">Bugatti</option>
                    <option value="maserati">Maserati</option>
                    <option value="alfa_romeo">Alfa Romeo</option>
                    <option value="citroen">Citroën</option>
                    <option value="peugeot">Peugeot</option>
                    <option value="renault">Renault</option>
                    <option value="skoda">Škoda</option>
                    <option value="seat">SEAT</option>
                    <option value="dodge">Dodge</option>
                    <option value="jeep">Jeep</option>
                    <option value="chrysler">Chrysler</option>
                    <option value="infiniti">Infiniti</option>
                    <option value="acura">Acura</option>
                    <option value="genesis">Genesis</option>
                </select>
                <label for="carImage">Kép feltöltése:</label>
                <input type="file" id="carImage" accept="image/*">
                <label for="carDetails">Részletek (ponttal elválasztva):</label>
                <textarea id="carDetails" placeholder="Pl. 5.2L V10 motor. 631 LE. 0-100 km/h 2,9 másodperc"></textarea>
                <button onclick="addCar()">Hozzáadás</button>
            </div>
            <div class="car-list" id="carListSection">
                <button id="showCarsBtn">Jelenlegi autók</button>
                <ul id="carList"></ul>
                <button id="showArchivedBtn">Archivált autók</button>
                <ul id="archivedList"></ul>
            </div>
        </div>
    `;
    document.getElementById('showCarsBtn').addEventListener('click', toggleCarList);
    document.getElementById('showArchivedBtn').addEventListener('click', toggleArchivedList);
    displayCars();
    displayArchivedCars();
});

function toggleCarList() {
    const carList = document.getElementById('carList');
    if (carList.style.display === 'none' || carList.style.display === '') {
        carList.style.display = 'block';
        document.getElementById('showCarsBtn').textContent = 'Jelenlegi autók elrejtése';
        displayCars();
    } else {
        carList.style.display = 'none';
        document.getElementById('showCarsBtn').textContent = 'Jelenlegi autók';
    }
}

function toggleArchivedList() {
    const archivedList = document.getElementById('archivedList');
    if (archivedList.style.display === 'none' || archivedList.style.display === '') {
        archivedList.style.display = 'block';
        document.getElementById('showArchivedBtn').textContent = 'Archivált autók elrejtése';
        displayArchivedCars();
    } else {
        archivedList.style.display = 'none';
        document.getElementById('showArchivedBtn').textContent = 'Archivált autók';
    }
}

function addCar() {
    const name = document.getElementById('carName').value.trim();
    const type = document.getElementById('carType').value;
    const color = document.getElementById('carColor').value;
    const brand = document.getElementById('carBrand').value;
    const imageInput = document.getElementById('carImage');
    const details = document.getElementById('carDetails').value.trim().split('.').map(d => d.trim()).filter(d => d);

    if (name && brand && imageInput.files.length > 0 && details.length > 0) {
        const file = imageInput.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const newCar = {
                name,
                type,
                color,
                brand,
                image: e.target.result,
                details
            };
            
            cars.push(newCar);
            localStorage.setItem('cars', JSON.stringify(cars));
            
            document.getElementById('carName').value = '';
            document.getElementById('carType').value = 'sport';
            document.getElementById('carColor').value = 'fekete';
            document.getElementById('carBrand').value = 'lamborghini';
            document.getElementById('carImage').value = '';
            document.getElementById('carDetails').value = '';
            
            if (document.getElementById('carList') && document.getElementById('carList').style.display === 'block') {
                displayCars();
            }
            alert('Autó sikeresen hozzáadva!');
        };
        
        reader.readAsDataURL(file);
    } else {
        alert('Kérlek, töltsd ki az összes mezőt és válassz ki egy képet!');
    }
}

function deleteCar(index) {
    const choice = prompt("Biztosan ki akarod törölni? Igen/Mégse/Archiválás");
    if (choice.toLowerCase() === 'igen') {
        cars.splice(index, 1);
        localStorage.setItem('cars', JSON.stringify(cars));
        displayCars();
    } else if (choice.toLowerCase() === 'archiválás') {
        archivedCars.push(cars[index]);
        cars.splice(index, 1);
        localStorage.setItem('cars', JSON.stringify(cars));
        localStorage.setItem('archivedCars', JSON.stringify(archivedCars));
        displayCars();
        displayArchivedCars();
    }
}

function publishCar(index) {
    cars.push(archivedCars[index]);
    archivedCars.splice(index, 1);
    localStorage.setItem('cars', JSON.stringify(cars));
    localStorage.setItem('archivedCars', JSON.stringify(archivedCars));
    displayCars();
    displayArchivedCars();
}

function displayCars() {
    const carList = document.getElementById('carList');
    if (carList) {
        carList.innerHTML = '';
        cars.forEach((car, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                ${car.name} (${car.brand}) - ${car.type}, ${car.color}
                <button onclick="deleteCar(${index})">Törlés/Archiválás</button>
            `;
            carList.appendChild(li);
        });
    }
}

function displayArchivedCars() {
    const archivedList = document.getElementById('archivedList');
    if (archivedList) {
        archivedList.innerHTML = '';
        archivedCars.forEach((car, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                ${car.name} (${car.brand}) - ${car.type}, ${car.color}
                <button onclick="publishCar(${index})">Közzététel</button>
            `;
            archivedList.appendChild(li);
        });
    }
}

document.getElementById('showCarsBtn').addEventListener('click', toggleCarList);
document.getElementById('showArchivedBtn').addEventListener('click', toggleArchivedList);
displayCars();
displayArchivedCars();

document.addEventListener("DOMContentLoaded", function () {
    let adminAttempts = 3;
    let adminLockout = localStorage.getItem("adminLockout");
    if (adminLockout) {
        let lockoutTime = new Date(adminLockout);
        let now = new Date();
        if (now < lockoutTime) {
            document.getElementById("admin-username").disabled = true;
            document.getElementById("admin-password").disabled = true;
            document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = true;
            document.getElementById("admin-attempts").textContent = `Próbáld újra ${Math.ceil((lockoutTime - now) / 60000)} perc múlva!`;
            setTimeout(() => {
                localStorage.removeItem("adminLockout");
                document.getElementById("admin-username").disabled = false;
                document.getElementById("admin-password").disabled = false;
                document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = false;
                document.getElementById("admin-attempts").textContent = "";
                adminAttempts = 3;
            }, lockoutTime - now);
        } else {
            localStorage.removeItem("adminLockout");
        }
    }

    document.getElementById("admin-login-form").addEventListener("submit", function(event) {
        event.preventDefault();
        const username = document.getElementById("admin-username").value;
        const password = document.getElementById("admin-password").value;
        if (username === "DriveUsAdmin" && password === "ADMIN2025") {
            localStorage.setItem("isAdminLoggedIn", "true");
            window.location.href = "admin_fooldal.html";
        } else {
            adminAttempts--;
            if (adminAttempts > 0) {
                document.getElementById("admin-attempts").textContent = `Hibás adatok! ${adminAttempts} próbálkozásod maradt.`;
            } else {
                document.getElementById("admin-attempts").textContent = "Próbáld újra 30 perc múlva!";
                document.getElementById("admin-username").disabled = true;
                document.getElementById("admin-password").disabled = true;
                document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = true;
                let lockoutTime = new Date();
                lockoutTime.setMinutes(lockoutTime.getMinutes() + 30);
                localStorage.setItem("adminLockout", lockoutTime);
                setTimeout(() => {
                    localStorage.removeItem("adminLockout");
                    document.getElementById("admin-username").disabled = false;
                    document.getElementById("admin-password").disabled = false;
                    document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = false;
                    document.getElementById("admin-attempts").textContent = "";
                    adminAttempts = 3;
                }, 30 * 60 * 1000);
            }
        }
    });
});

document.querySelector('.sidebar a[href="admin_bejelentkezes.html"]').addEventListener('click', function(e) {
    e.preventDefault();
    localStorage.removeItem('isAdminLoggedIn'); 
    window.location.href = '../profilom/profilom.html'; 
});