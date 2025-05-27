# Tesztjegyzőkönyv

| Mező | Tartalom |
|:---|:---|
| **Teszt ID** | LOG-001 |
| **Teszt neve** | Bejelentkezés érvényes adatokkal |
| **Teszt leírás** | Ellenőrizzük, hogy a felhasználó sikeresen be tud-e jelentkezni helyes adatokkal. |
| **Tesztelő neve** | Gyura Gabriella |
| **Teszt dátuma** | 2025-04-15 |
| **Előfeltételek** | A tesztelt felhasználó adatai léteznek az adatbázisban. |
| **Tesztlépések** | 1. Nyisd meg a bejelentkezési oldalt.<br>2. Add meg az érvényes e-mail címet és jelszót.<br>3. Kattints a "Bejelentkezés" gombra. |
| **Várt eredmény** | A rendszer átirányít a "profilom" oldalra, ahol megjelennek a felhasználó adatai. |
| **Kapott eredmény** | A rendszer sikeresen átirányította a "profilom" oldalra, az adatok helyesen jelennek meg. |
| **Teszt státusza** | Passed |

| Mező | Tartalom |
|:---|:---|
| **Teszt ID** | REG-001 |
| **Teszt neve** | Regisztráció érvényesen kitöltött mezőkkel |
| **Teszt leírás** | Ellenőrizzük, hogy a felhasználó sikeresen tud-e regisztrálni helyes adatok megadásával. |
| **Tesztelő neve** | Gyura Gabriella |
| **Teszt dátuma** | 2025-04-15 |
| **Előfeltételek** | A regisztrálandó e-mail cím még nem szerepel az adatbázisban. |
| **Tesztlépések** | 1. Nyisd meg a regisztrációs oldalt.<br>2. Töltsd ki az összes kötelező mezőt érvényes adatokkal (pl. név, e-mail cím, jelszó, jelszó megerősítése) és fogadd el az ÁSZF-et.<br>3. Kattints a "Regisztráció" gombra. |
| **Várt eredmény** | A rendszer sikeresen létrehozza a felhasználói fiókot és egy "Sikeres regisztráció" üzenetet ír ki a képernyőre. |
| **Kapott eredmény** | A rendszer sikeresen létrehozta a fiókot és "Sikeres regisztráció" üzenetet írt ki a képernyőre. |
| **Teszt státusza** | Passed |