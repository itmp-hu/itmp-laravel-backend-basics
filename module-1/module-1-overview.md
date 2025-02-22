# Laravel Backend fejlesztés: 1. modul - Alapismeretek

## Backend és Frontend
A webfejlesztés két fő területe a **Backend** és **Frontend**.

- **Backend (szerveroldali fejlesztés)**: A háttérrendszer amely az adatok kezeléséért, az üzleti logika végrehajtásáért és az API-k biztosításáért felel. Ez tartalmazza az adatbázist, szerveroldali programokat és API-kat. 

- **Frontend (kliensoldali fejlesztés)**: Az a rész, amelyet a felhasználók látnak és interakcióba lépnek vele. HTML, CSS és JavaScript segítségével épül fel, gyakran modern keretrendszerekkel, például Angular, React vagy Vue.js.

### REST API

A backend és frontend kommunikációja leggyakrabban **REST API-k** segítségével történik, ahol a frontend kéréseket küld a backendhez, amely válaszokat küld vissza általában **JSON** formátumban, amelyek könnyen feldolgozhatók kliensoldalon.

A REST (Representational State Transfer) egy architekturális stílus, amelyet webszolgáltatások fejlesztésére használnak. A REST API-k HTTP protokollt használnak az adatok küldésére és fogadására, az alábbi HTTP metódusok segítségével:
- **GET** – Adatok lekérdezése
- **POST** – Új erőforrás létrehozása
- **PUT/PATCH** – Létező erőforrás frissítése
- **DELETE** – Erőforrás törlése

## Bevezetés a Laravelbe

### Mi az a Laravel?
A Laravel egy modern PHP keretrendszer, amely megkönnyíti a webalkalmazások fejlesztését egy egyszerű és elegáns szintaxissal. A Laravel számos beépített funkcióval rendelkezik, mint például az Eloquent ORM, Artisan CLI, Blade templating rendszer, valamint API fejlesztést támogató eszközök.

### Miért érdemes Laravel-t használni?
- Egyszerű szintaxis és gyors fejlesztés
- MVC (Model-View-Controller) alapú architektúra
- Erőteljes ORM (Eloquent) az adatbázis kezeléséhez
- Artisan CLI a gyors parancssori műveletekhez
- Beépített hitelesítési és jogosultságkezelési megoldások
- Könnyű API fejlesztés és támogatás a RESTful architektúrához
- Nagyon jól használható [dokumentáció](https://laravel.com/docs)

### Szükséges szoftverek: **PHP, Composer, Laravel installer**

- **PHP**: A Laravel PHP nyelven íródik, ezért először telepíteni kell a PHP-t.
- A **Composer** egy PHP csomagkezelő, amely lehetővé teszi külső könyvtárak és függőségek egyszerű telepítését, kezelését és frissítését egy projektben. A `composer.json` fájlban meghatározhatók a szükséges csomagok, amelyeket a `composer install` vagy `composer update` parancs telepít és frissít a **vendor** mappában.
- **Laravel Installer**: A Laravel telepítéséhez szükséges parancssori eszköz.

**Telepítés**

A fenti szoftverek telepíthetők egyesével:
 - [XAMPP](https://www.apachefriends.org/hu/index.html)
 - [Composer](https://getcomposer.org)
 - Laravel installer - a Composer telepítése után az alábbi parancs futtatásával:
 
    ```sh
    composer global require laravel/installer
    ```
---

 ...vagy a Laravel dokumentációjában található script segítségével (*Windows, Linux vagy macOS operációs rendszerre*) egy lépésben [innen](https://laravel.com/docs/11.x/installation#installing-php).

Például Windows-ban PowerShellt kell indítani **rendszergazdaként**, majd ott lefuttatni az alábbi parancsot:
```powershell
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

<details>
<summary>Ez utóbbi esetben a számítógép konfigurációjától függően előfordulhat, hogy <b>a szerver nem indul el</b>...</summary>

Ha a szerver az alábbi hibaüzenettel nem indul el:

```sh
Failed to listen on 127.0.0.1:8000 (reason: ?)
Failed to listen on 127.0.0.1:8001 (reason: ?)
...
```

Keressük meg a `php.ini` fájlt a következő helyen:

```sh
c:\Users\<username>\.config\herd-lite\bin\php.ini 
```

és töröljük ki az 'E' betűt a `variables_order` sorban:

```php
variables_order = "EGPCS"
helyett
variables_order = "GPCS"
```
</details>


### Laravel fejlesztés elindítása
Új projekt létrehozása:

```sh
laravel new project-name
```
<details>
<summary>A telepítés során az alábbi kérdésekre kell válaszolni:</summary>

- Would you like to install a starter kit? **Válasz**: none
- Which testing framework do you prefer? **Válasz**: tetszőleges (monst nem fogunk automata teszteket írni semelyik redszerben)
- Would you like to initialize a Git repository? **Válasz**: tetszőleges. Ha szerétnénk verziókezelést használni, akkor igen, egyébként nem.
- Which database will your application use? **Válasz**: sqlite
- Would you like to run the default database migrations? **Válasz**: yes.
 
</details>

A Laravel legújabb verzióiban alapártelmezésben már nincs benne az API fejlesztés támogatása, ezért a következő parancs futtatásával telepíteni kell:

```sh
cd project-name
php artisan install:api
```

### Lokális fejlesztői szerver
A Laravel beépített szerverét az alábbi paranccsal indíthatjuk el:

```sh
php artisan serve
```

Ez a szerver alapértelmezetten az alábbi címen lesz elérhető: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### A Laravel mappastruktúra

A Laravel keretrendszer jól strukturált mappaszerkezettel rendelkezik. Egy egyszerű backend fejlesztése során az alábbi mappákat használjuk leggyakrabban:

**1. app/**
Az alkalmazás fő logikáját tartalmazza:
- **Models/** – Az adatbázis modellek itt helyezkednek el.
- **Http/Controllers/** – A vezérlők (Controllers), amelyek a CRUD műveleteket kezelik.

**2. config/**
Az alkalmazás konfigurációs fájljait tartalmazza, például `database.php` az adatbáziskapcsolatokhoz.

**3. database/**
Az adatbázissal kapcsolatos fájlok:
- **migrations/** – Az adatbázis táblák létrehozásához és módosításához.
- **seeders/** – Tesztadatok beszúrására.
- **database.sqlite** – SQLite adatbázisfájl, amely kis fejlesztési projektekhez használható.

**4. routes/**
Az alkalmazás útvonalai:
- **api.php** – A REST API végpontokat itt definiáljuk.
- **web.php** – A webalkalmazások végpontjait itt definiáljuk. (Ezt backendben nem használjuk.)

**5. vendor/**
A Composer által telepített külső csomagok tárolására szolgál. Ez a mappa benne van a `.gitignore`-ban, így nem kerül a git repository-ba.

Egy frissen klónozott projekthez utólag telepítendők a csomagok a következő paranccsal:
```sh
composer install
```

**6. A főkönyvtárban lévő fontos állományok:**
- **.env** – Környezeti változók beállításai, például adatbáziskapcsolat.
- **artisan** – Laravel parancssori segédeszköz.
- **composer.json** – A csomagfüggőségek meghatározása.


## Az első végpont létrehozása
A Laravelben a REST API végpontokat a `routes/api.php` fájlban definiáljuk.

A következő kód egy egyszerű végpontot definiál, amely a "Hello, World!" üzenetet adja vissza:

```php
Route::get('/greeting', function () {
    return 'Hello, World!';
});
```

Ha még nem fut a Laravel fejlesztői szerver, akkor először egy terminál ablakban indítsuk el:
```sh
php artisan serve
```

Teszteljük le a végpontot egy böngészőben: [http://127.0.0.1:8000/api/greeting](http://127.0.0.1:8000/api/greeting)

## User management
A Laravel alapértelmezésben tartalmazza a felhasználókezelést. Egy frissen telepített projektben létezik a `User` modell illetve hozzá kapcsolódóan több osztály is.

A gyakorlat végén találunk egy bónusz példát, amelyben a **UserFactory** osztály segítségével létrehozunk teszteléshez használható fake felhasználókat és egy egyszerű GET endpointtal visszaadjuk az összes usert.
