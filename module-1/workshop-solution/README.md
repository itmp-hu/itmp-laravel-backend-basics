# Szükséges lépések a projekt klónozása után:

1. A `.env.example` fájl lemásolása `.env` néven
2. Szükséges csomagok telepítése: `composer install`
3. Alkalmazás kulcsok generálása: `php artisan key:generate`
4. Migrációk futtatásra: `php artisan migrate`
5. Adatbázis seedelése: `php artisan db:seed`
6. A szerver indítása: `php artisan serve`