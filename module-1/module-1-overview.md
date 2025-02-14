# Laravel Backend fejlesztés: 1. modul - Alapismeretek

## Backend és Frontend
A webfejlesztésben két fő terület létezik: **Backend** és **Frontend**.

- **Backend (szerveroldali fejlesztés)**: A háttérrendszer, amely az adatok kezeléséért, üzleti logika végrehajtásáért és az API-k biztosításáért felel. Ez tartalmazza az adatbázist, szerveroldali programokat és API-kat. 

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
- Nagyon jól használható dokumentáció

### Szükséges szoftverek: **PHP, Composer, Laravel installer**

- **PHP**: A Laravel a PHP nyelven íródik, ezért először telepíteni kell a PHP-t.
- A **Composer** egy PHP csomagkezelő, amely lehetővé teszi külső könyvtárak és függőségek egyszerű telepítését, kezelését és frissítését egy projektben. A `composer.json` fájlban meghatározhatók a szükséges csomagok, amelyeket a `composer install` vagy `composer update` parancs telepít és frissít a **vendor** mappában.
- **Laravel Installer**: A Laravel telepítéséhez szükséges parancssori eszköz.

**Telepítés:**
A fenti szoftverek egyesével is telepíthetők, de a Laravel dokumentációjában található script segítségével egy lépésben telepíthető mindhárom [innen](https://laravel.com/docs/11.x/installation#installing-php).

<details>
<summary>Nyitsd le a Windows telepítő scripthez!</summary>

Windows-ban PowerShellt kell indítani **rendszergazdaként**, majd ott lefuttatni az alábbi parancsot:

```powershell
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```
</details>

*Egyéb operációs rendszerekre (macOS, Linux) szintén kimásolható a szükséges parancs a fenti linkről.*

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

Ez a szerver az alábbi címen lesz elérhető: [http://127.0.0.1:8000](http://127.0.0.1:8000)

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