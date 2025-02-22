# 3. modul workshop - Laravel modellek, migrációk és validáció

Ebben a modulban megnézzük, hogyan kell modelleket létrehozni, migrációkat kezelni és adatok generálásával tesztelni a backendünket Laravelben. Emellett foglalkozunk az adatok validációjával is.

> [!NOTE]  
> **Cél:**  
> - Egy új `Task` modellt hozunk létre migrációval, factory-val és kontrollerrel együtt.
> - Definiáljuk és futtatjuk a migrációkat az adatbázisban.
> - Faker segítségével tesztadatokat generálunk.
> - Validáljuk a beérkező adatokat a `store()` metódusban.

## Modell létrehozása

A `Task` modell létrehozásához futtassuk az alábbi parancsot:

```sh
php artisan make:model Task -mfc --api
```

Ez létrehozza az alábbi állományokat:
- `app/Models/Task.php` (Modell)
- `database/migrations/xxxx_xx_xx_xxxxxx_create_tasks_table.php` (Migráció)
- `database/factories/TaskFactory.php` (Factory)
- `app/Http/Controllers/TaskController.php` (Controller)

A `Task` modellben (`app/Models/Task.php`) engedélyezzük a tömeges hozzárendelést:

```php
protected $fillable = ['title', 'description', 'completed'];
```

## Migráció létrehozása és futtatása

A `tasks` tábla sémáját az imént generált migrációs fájlban (`database/migrations/..._create_tasks_table.php`) kell szerkeszteni:

```php
public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}
```

A migrációk futtatása:

```sh
php artisan migrate
```

## Tesztadatok generálása

A `database/factories/TaskFactory.php` fájlban adjuk meg az alábbi `definition` metódust:

```php
public function definition(): array
{
    return [
        'title' => fake()->sentence,
        'description' => fake()->paragraph,
        'completed' => fake()->boolean,
    ];
}
```

Adatok generálása a `DatabaseSeeder` osztályban (`database/seeders/DatabaseSeeder.php`):

```php
public function run(): void
{
    Task::factory(50)->create();
}
```

Seeder futtatása:

```sh
php artisan db:seed
```

## API Útvonalak definiálása

A `routes/api.php` fájlban adjuk hozzá az alábbi 2 sort:

```php
use App\Http\Controllers\TaskController;
Route::apiResource('tasks', TaskController::class);
```

Ellenőrizzük a létrehozott végpontokat:

```sh
php artisan route:list
```

## Validáció a Controllerben (`app/Http/Controllers/TaskController.php`)

A `TaskController` `store()` metódusában biztosítsuk, hogy csak megfelelő adatok kerüljenek az adatbázisba!

```php
public function store(Request $request)
{
    $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

    $task = Task::create($validatedData);

    return response()->json($task, 201);
}
```



## Store metódus tesztelése Thunder Clientben

**A teszteléshez indítsuk el a Laravel szervert!**

```sh
php artisan serve
```

---

Thunder Clientben hozzunk létre egy új kérést az alábbi adatokkal:

#### Tesztelés **hibás** adatokkal:
- **Method:** POST
- **URL:** `http://127.0.0.1:8000/api/tasks`
- **Body (JSON):**
  ```json
  {
    "title": "",
    "description": 12345,
    "completed": "nem igaz"
  }
  ```
- **Várt válasz:** HTTP 422 (Unprocessable Content), validációs hibaüzeneteket tartalmazó JSON objektum.

#### Tesztelés **helyes** adatokkal:
- **Method:** POST
- **URL:** `http://127.0.0.1:8000/api/tasks`
- **Body (JSON):**
  ```json
  {
    "title": "Learning Laravel",
    "description": "It is very interesting",
    "completed" : false
  }
  ```
- **Várt válasz:** HTTP 201 (Created), a létrehozott task JSON objektuma.

