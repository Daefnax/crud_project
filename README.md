
## 📦 Требования

- PHP >= 8.1
- Composer
- MySQL

## 🚀 Установка

```bash
composer install
cp .env.example .env
php artisan key:generate
```

## ⚙️ Настройка

1. Создай базу данных в MySQL.
2. Укажи настройки подключения в `.env`:
   ```env
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
3. Запусти миграции:
   ```bash
   php artisan migrate
   ```

4. (Опционально) Заполни тестовые данные:
   ```bash
   php artisan db:seed
   ```

## 🧪 Тесты

```bash
php artisan test
```
