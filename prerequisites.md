# Laravel backend API fejlesztés előfeltételek

## Szükséges szoftverek: PHP, Composer, Laravel installer
A fenti szoftverek telepíthetők egyesével:
 - [XAMPP](https://www.apachefriends.org/hu/index.html)
 - [Composer](https://getcomposer.org)
 - Laravel installer az alábbi parancs futtatásával:
 
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
<summary>Ez utóbbi esetben előfordulhat, hogy <b>a szerver nem indul el</b>...</summary>

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

## Adatbázis-kezelő
Az előadás és a gyakorlatok során **SQLite**-ot fogunk használni, de a későbbiekben szükség lehet robosztusabb adatbázis-kezelő (pl. MySQL) használatára is. Ez az XAMPP csomagnak a részét képezi vagy külön fel kell telepíteni.

## Visual Studio Code beállítása
A fejelsztéshez Visual Studio Code-ot fogunk használni. *Alternatív népszerű fejlesztői környezet a PHPStorm.*

### Minimálisan ajánlott VS Code extension-ök
- **PHP Intelephense** (intelligens kódkiegészítés)
- **Laravel Extra Intellisense** (intellisense Laravel funkciókhoz)
- **Laravel Snippets** (kódkiegészítés Laravel funkciókhoz)
- **Thunder Client** (API teszteléshez, *alternatíva: Postman*)
