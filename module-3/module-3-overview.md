# Laravel Backend fejlesztés: 3. modul - Modell, migráció, adatok generálása, validáció

- Modell létrehozása; `$fillable` attribútum
- Migráció létrehozása és futtatása
- Adatok generálása teszteléshez (Factory és DatabaseSeeder)
- Összes API útvonal definiálása egy függvény segítségével
- POST és PUT/PATCH metódusokban kapott adatok validációja

## Modell - /app/Models/
A modell a Laravel egyik alapvető eleme, amely az adatbázis táblákhoz kapcsolódó objektumokat és azok műveleteit kezeli. A `User` modell például a `users` táblát reprezentálja, és lehetővé teszi az adatok lekérdezését, módosítását és törlését az Eloquent ORM-en keresztül.

**Új modell létrehozása:**

```sh
php artisan make:model [options] <name>
```

A modell létrehozásával egy időben további - az adott modellhez kapcsolódó - osztályokat is létrehozhatunk. Segítséget a `php artisan help make:model` paranccsal kaphatunk.


<details>
<summary>Példa: Task modell létrehozása controller, factory osztályokkal és migrációval együtt.</summary>

```sh
php artisan make:model Task -mfc --api
```

Ahol az **m** a migráció, az **f** a factory és a **c** a controller létrehozását jelenti. A **--api** opcióval a controller-t API-controllerként hozza létre benne a megfelelő metódusokkal.
</details>

### $fillable property
A `$fillable` egy tömb a Laravel Eloquent modellekben, amely meghatározza, hogy mely oszlopok tömeges hozzárendelése (mass assignment) van engedélyezve. A tömeges hozzárendelés azt jelenti, hogy egy tömbből egyszerre több oszlop értékét is be lehet állítani anélkül, hogy egyesével kellene megadni őket. Biztonsági okokból alapértelmezetten tiltott a tömeges hozzárendelés, hogy megakadályozza a rosszindulatú felhasználók által végzett illetéktelen adatbevitelt (Mass Assignment Vulnerability).

A `$fillable` tömböt a modellekben kell megadni. Csak azok az oszlopok frissíthetők tömeges hozzárendeléssel, amelyeket itt engedélyeztünk. Például a `User` modellben alapértelmezetten fel van töltve a `$fillable` tömb, így lehetséges a `name`, `email` és `password` mezők frissítése.

Tömeges hozzárendelést a rekordok létrehozásakor használt `create()` és a frissítéskor használt `update()` metódus valósít meg.

<details>
<summary>Engedélyezzük a Task modellben a tömeges hozzárandelést</summary>

```php
protected $fillable = ['title', 'description', 'completed'];
```

Innentől a `title`, `description` és `completed` mezők frissíthetőek a `create()` és `update()` metódusokban.

</details>

## Migráció - /database/migrations/
A migrációk az adatbázis sémájának verziókezelésére szolgálnak. Segítségükkel programkódból lehet létrehozni, módosítani és törölni adatbázis táblákat. Például a `create_users_table` migráció tartalmazza az oszlopok definiálását, mint például a név, e-mail és jelszó mezőket.

Ha a modellel együtt nem hoztunk létre migrációt, akkor a `php artisan make:migration` paranccsal tudjuk utólag létrehozni.

A migráció elnevezése fontos, mivel a Laravel megpróbálja kitalálni belőle, hogy mit szeretnénk csinálni és automatikusan annak megfelelő függvényeket hoz létre.

<details>
<summary>Példa migráció: tasks tábla létrehozásához</summary>

```sh
php artisan make:migration create_tasks_table
```
</details>

Egy migrációs állomány két metódust tartalmaz:
- `up()`: Ez a metódus a migráció futtatásakor indul el, és egy táblát hoz létre, oszlopokat ad hozzá, vagy módosítja azokat.
- `down()`: Ez a metódus a migráció visszavonásakor indul el, és az `up()` metódusban elvégzett módosításokat visszaállítja.

Az `up()` metódusban a `Schema` osztályt használjuk az adatbázis táblák (`Schema::create`) vagy oszlopok (`Schema:table`) létrehozásához. *Megfelelően elnevezett migráció esetén ezeket a Laravel automatikusan létrehozza.*

**Oszlopok hozzáadása:** Például a `$table->string('name')` egy `varchar` típusú `name` nevű vagy a `$table->integer('age')` egy `integer` típusú `age` nevű mezőt hoz létre.

<details>
<summary>Példa migráció: tasks tábla létrehozására</summary>

```php
return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
```
</details>

### Migráció futtatása
A migráció futtatásához használjuk a `migrate` parancsot:

```sh
php artisan migrate
```

A migráció visszavonásához használjuk a `migrate:rollback` parancsot:

```sh
php artisan migrate:rollback
```

## Adatok generálása teszteléshez

A teszteléshez használtható fiktív adatok generálása 3 lépésben történik:
1. Factory létrehozása.
2. Factory meghívása a DatabaseSeeder osztályban.
3. DatabaseSeeder futtatása artisan parancs segítségével.

### 1. Factory - /database/factories/
A Laravelban a fiktív adatok generálására a `Factory` osztályt használjuk. Az innen elérhető `Faker` segítségével létrehozhatunk véletlenszerű adatokat, például neveket, e-maileket, telefonszámokat stb.

Ha a modellel együtt nem hoztunk létre factory-t, akkor a `php artisan make:factory` paranccsal tudjuk utólag létrehozni.

<details>
<summary>Példa: factory létrehozása a Task modellhez</summary>

```sh
php artisan make:factory TaskFactory --model=Task
```
</details>

A factory oszály `definition()` metódusában adhatjuk meg, hogy milyen adatokat szeretnénk generálni. Ehhez a `fake()` metódust használjuk.

<details>
<summary>Példa: fake() metódus használata a TaskFactory-ban</summary>

```php
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'completed' => fake()->boolean
        ];
    }
```
A fenti példában a `fake()->sentence` egy véletlenszerű mondatot, a `fake()->paragraph` egy bekezdést, a `fake()->boolean` pedig egy logikai igaz/hamis értéket generál.
</details>

### 2. Factory használata a DatabaseSeederben - /database/seeders/DatabaseSeeder.php

A DatabaseSeeder Laravelben egy alapértelmezett seeder osztály, amelyet az adatbázis inicializálására és tesztadatok feltöltésére használnak.

- Lehetővé teszi az adatbázis gyors feltöltését előre definiált adatokkal.
- Segít a fejlesztőknek valósághű adatokkal dolgozni anélkül, hogy manuálisan kellene feltölteni az adatbázist.
- Újratelepíthetővé és konzisztenssé teszi az adatbázist a fejlesztési folyamat során.

**Használata**

A DatabaseSeeder osztály a `database/seeders/DatabaseSeeder.php` fájlban található. Itt lehet meghívni a factory-kat, hogy létrehozzák a szükséges adatokat.

<details>
<summary>Példa: factory használata a DatabaseSeederben</summary>

```php
public function run(): void
    {
        User::factory(10)->create();
        Task::factory(50)->create();
    }
```

A fenti két utasítás létrehoz 10 véletlenszerű felhasználót és 50 taskot.
</details>

### 3. Seeder futtatása

Az alábbi artisan parancs futtatja a DatabaseSeeder osztályt és tölti fel ténylegesen az adatbázist:

```sh
php artisan db:seed
```

Ha az adatbázis összes tábláját előbb törölni szeretnénk, használhatjuk az alábbi parancsot. Ez törli az adatbázist, újra lefuttatja az összes migrációt, majd a seedert is egy lépésben:

```sh
php artisan migrate:fresh --seed
```

## Összes API útvonal definiálása - /routes/api.php

Hasonlóan a users végpontokhoz létrehozhatjuk a taskokhoz tartozó végpontokat is. Azonban ahelyett, hogy ezeket egyesével létrehoznánk egy metódus segítségével egy lépésben létrehozhatjuk az összes végpontot. Ehhez a `Route::apiResource` metódust használjuk:

```php
Route::apiResource('tasks', TaskController::class);
```

Ne feledkezzünk meg a TaskController importálásáról a fájl elején:

```php
use App\Http\Controllers\TaskController;
```

Ellenőrizzük az így létrejött végpontokat:

```sh
php artisan route:list
```

## Validálás

### **Miért van szükség validálásra Laravelben?**  

A **validálás** azért fontos, mert biztosítja, hogy az alkalmazásba érkező adatok **helyesek**, **biztonságosak**, és **megfelelnek az elvárásoknak**.  

**Miben segít a validálás?**

1. **Adatintegritás biztosítása**  
   Példa: A felhasználók csak érvényes e-mail címet adhassanak meg.  
   ```php
   'email' => 'required|email'
   ```
   Ha ezt nem ellenőriznénk, a felhasználók akár `"valami"` értéket is beírhatnának az e-mail mezőbe.  

2. **Biztonság növelése**  
   - Megakadályozhatja a **rosszindulatú bemeneteket** (pl. XSS, SQL injection).  
   - Példa: Egy szövegmezőben ne lehessen kártékony JavaScript kódot futtatni.  

3. **Felhasználói élmény javítása**  
   - A rendszer azonnal visszajelzést ad a hibás adatokról.  
   - Példa: Egy jelszó legyen legalább 8 karakter hosszú.  
   ```php
   'password' => 'required|min:8'
   ```

4. **Az alkalmazás stabilabb működése**  
   - Ha nem megfelelő adatokat fogad el a rendszer, az hibákhoz vezethet az alkalmazás működésében.  
   - Példa: Ha egy termék ára `"valami"` szövegként kerülne be az adatbázisba, akkor a számítások során hiba keletkezne.  

---

### **Hogyan működik a validálás Laravelben?**  
 
A Laravel `validate()` metódusa egyszerűen használható:  

```php
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    $user = User::create($validatedData);

    return response()->json($user, 201);
}
```
**Mit csinál ez a validálás?**  
- **`name`**: Kötelező, szöveges, max. 255 karakter.  
- **`email`**: Kötelező, e-mail formátum, egyedi a `users` táblában.  
- **`password`**: Kötelező, min. 8 karakter hosszú.  

## **Gyakori validálási szabályok**  

Laravel rengeteg beépített validálási szabályt biztosít:  

| Szabály               | Leírás |
|-----------------------|--------|
| `required`            | Kötelező mező |
| `string`              | Szöveges formátum |
| `email`               | Érvényes e-mail cím |
| `min:8`               | Minimum 8 karakter hosszú |
| `max:255`             | Maximum 255 karakter hosszú |
| `integer`             | Egész szám |
| `numeric`             | Szám |
| `unique:table,column` | Egyedi érték az adott oszlopban |
| `exists:table,column` | Léteznie kell az adott táblában |

Az **összes szabály** a dokumentációban [itt](https://laravel.com/docs/11.x/validation#available-validation-rules) található.