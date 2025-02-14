# 1. modul workshop - Laravel telepítése

- Laravel telepítése
- Projekt inicializálása
- Fake userek generálása
- GET endpoint létrehozása
- artisan szerver futtatása
- GET endpoint tesztelése böngészőben

> [!NOTE]  
> **Cél:**  
> Minden szükséges eszköz telepítve legyen a számítógépen: Composer, parancssori PHP, Laravel installer, Visual Studio Code! Legyen létrehozva egy Laravel projekt, telepítve legyen az api környezet! Értenünk kell egy Laravel projekt felépítését, valamint azt, hogy milyen mappákat, fájlokat tartalmaz! Hozzunk létre fake usereket a teszteléshez és egy egyszerű GET endpointtal adjuk vissza az összes usert!

<hr />

## Laravel projekt telepítése

- Hozz létre új Laravel projektet! Lép be a kívánt mappába, majd futtasd le a következő parancsot:

  ```sh
  laravel new project-name
  ```

- Ha valamelyik előfeltétel nem teljesül és nem fut le a telepítő, akkor [innen](https://laravel.com/docs/11.x/installation#installing-php) telepíthet az összeset egy lépésben.
- Ha nincs feltelepítve [Visual Studio Code](https://code.visualstudio.com/), akkor azt is telepítsd!

## Legenerált projektfájlok és mappák tanulmányozása


## Projekt inicializálása

- A projekt mappáját nyisd meg Visual Studio Code-ban!
- Kered meg és tanulmányozd az említett mappákat és állományokat! 
- Nyiss egy terminált ablakot! A legegyszerűbb VS Code-ban: **View > Terminal**
- Telepítsd a backend környezetet a következő paranccsal:

  ```sh
  php artisan install:api
  ```

  - A telepítés végén a migrációk lefuttatásához kér engedélyt. Válaszolj **yes**-szel!

## Fake userek generálása

- Keresd meg és szerkesztd a következő fájlt: `database/seeders/DatabaseSeeder.php`:

  Vedd ki a kommentet az alábbi sor elől:
  ```php
  User::factory(10)->create();
  ```

- A terminálban futtasd le a következő parancsot:

  ```sh
  php artisan db:seed
  ```

## Endpoint létrehozása
- Keresd meg a `routes/api.php` fájlt, és írd bele a következő kódot:

  ```php
  Route::get('/users', function () {
    return User::all();
  });
  ```
- A User modell használatához importálni kell a User modellt a fájl elején:
  ```php
  use App\Models\User;
  ```

## Szerver elindítása és a route tesztelése

Terminálban futtasd le a következő parancsot:
```sh
php artisan serve
```
- A szerver elindítása után a terminálban megjelenik a következő üzenet:

  ```sh
  INFO Server running on [http://127.0.0.1:8000](http://127.0.0.1:8000).
  ```
  
Egy böngészőben nyisd meg a következő URL-t: [http://127.0.0.1:8000/api/users](http://127.0.0.1:8000/api/users) és ellenőrizd, hogy egy usereket tartalmazó JSON-t kapunk-e vissza.

