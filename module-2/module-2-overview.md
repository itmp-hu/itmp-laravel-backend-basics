# Laravel Backend fejlesztés: 2. modul - CRUD műveletek

- Controller létrehozása
- Route-ok létrehozása
- CRUD műveletek implementálása, Eloquent ORM használata
- API tesztelés

## Controller - /app/Http/Controllers/
A Controller osztály a HTTP kérések feldolgozásáért és az üzleti logika végrehajtásáért felelős. A `UserController` például fogadja a kliens kéréseit, végrehajtja a megfelelő adatbázis műveleteket, és visszaküldi az eredményt JSON formátumban.

Új (üres) controller létrehozása:
```sh
php artisan make:controller <name>
```

Új (API metódusokat tartalmazó) controller létrehozása:
```sh
php artisan make:controller <name> --api
```

## Route - /routes/api.php
A route-ok határozzák meg, hogy egy adott URL-re érkező kérés mely controller metódushoz lesz irányítva. Az `api.php` fájlban találhatók az API végpontokhoz tartozó route-ok, amelyek segítségével az egyes CRUD műveletek végrehajthatók.

**Fontos:** Az `api.php` fájlban definiált végpontok automatikusan prefixelődnek a `/api` előtaggal.

Példa route létrehozására:
```php
Route::get('/users', [UserController::class, 'index']);
```

Az így létrejött végpont az alábbi címen érhető el: `http://127.0.0.1:8000/api/users`. A **get** kérést a `UserController` osztály `index()` metódusa fogja kiszolgálni.

<details>
<summary>Összes CRUD végpont létrehozása</summary>

```php
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
```
</details>

### A controller osztályban lévő metódusok és a CRUD műveletek megfeleltetése

| Metódus | CRUD művelet |
| --- | --- |
| index() | GET /users |
| show() | GET /users/{id} |
| store() | POST /users |
| update() | PUT /users/{id} |
| destroy() | DELETE /users/{id} |

## Eloquent ORM használata a modell osztályokban
A Laravel Eloquent ORM-et használva a modell osztályok segítségével könnyedén lehet adatbázis műveleteket végrehajtani SQL lekérdezések írása nélkül.

*Modellek létrehozásával a 3. modulban foglalkozunk.*

### UserControllerben használt Eloquent ORM metódusok

- `User::all()`: Az összes user rekord lekérése.
- `User::findOrFail($id)`: Egy adott user lekérése ID alapján, hiba esetén kivételt dob (404).
- `User::find($id)`: Egy adott user lekérése ID alapján, ha nem létezik, akkor null értéket ad vissza.
- `User::create($data)`: Statikus metódus. Új user létrehozása a megadott adatokkal.
- `$user->update($data)`: A meglévő user adatok frissítése.
- `$user->delete()`: A user törlése az adatbázisból.

## API tesztelés Postman vagy Thunder Client segítségével

- [Thunder Client](https://www.thunderclient.com/) VS Code bővítmény
    - könnyű és gyors megoldás egyszerű API tesztelésre
    - az ingyenes verzió erősen korlátozott
- [Postman](https://www.postman.com/)
    - profi eszköz összetett API tesztelésre
