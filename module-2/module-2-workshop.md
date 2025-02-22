# 2. modul workshop - Laravel CRUD backend készítése

Ebben a modulban megnézzük hogyan kell egy egyszerű CRUD (Create, Read, Update, Delete) műveleteket tartalmazó backendet készíteni Laravelben, majd az elkészült végpontokat tesztelni Thunder Client segítségével.

> [!NOTE]  
> **Cél:**  
> - Az 1. modulban elkezdett felhasználó kezelést átdolgozzuk majd definiáljuk a hiányzó CRUD végpontokat. 
> - Létrehozzuk a `UserController` osztályt és az egyes végpontokhoz a megfelelő Controller metódusokat hívjuk meg.
> - A Thunder Client VS Code bővítménnyel teszteljük a végpontokat.


## Controller Létrehozása

Hozzunk létre egy Controller osztályt a CRUD műveletekhez! Ehhez egy terminal ablakban futtassuk le a következő parancsot:

```sh
php artisan make:controller UserController --api
```

A generált Controller (`app/Http/Controllers/UserController.php`) a `--api` beállításnak köszönhetően tartalmazza a szükséges (de még üres) metódusokat.

## CRUD műveletek implementálása a Controllerben

Írjuk meg a `UserController` osztály metódusait! 

<details>
<summary>Segítség: metódusok implementálása</summary>

```php
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        //TODO: validate the request!!!
        
        $user = User::create($request->all());
        
        return response()->json($user, 201);
    }
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //TODO: validate the request!!!

        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->noContent();
    }
}
```
</details>

## API Útvonalak Definiálása

Nyissuk meg a `routes/api.php` fájlt, és definiáljuk benne a végpontokat! Minden egyes végponthoz rendeljük hozzá a `UserController` osztály megfelelő metódusát!

<details>
<summary>Segítség: API végpontok definiálása</summary>

```php
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::patch('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
```
</details>

## API Tesztelése

Ha még nem fut, indítsuk el a Laravel beépített szerverét!

```sh
php artisan serve
```

Ezután használhatjuk a létrehozott API végpontokat a Thunder Client requestekben!

- **GET** `/api/users` – Összes felhasználó lekérdezése
- **POST** `/api/users` – Új felhasználó létrehozása
- **GET** `/api/users/{id}` – Egy felhasználó lekérdezése
- **PUT vagy PATCH** `/api/users/{id}` – Felhasználó adatainak módosítása
- **DELETE** `/api/users/{id}` – Felhasználó törlése

*Szükség esetén a létrehozott végpontok listázásához adjuk ki egy terminál ablakban a `php artisan route:list` parancsot.*