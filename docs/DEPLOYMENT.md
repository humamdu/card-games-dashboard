# Deployment

## Server Requirements

- PHP 8.1+
- Composer 2+
- MySQL 8+ or compatible database
- Web server pointing to `public/`

## Production Build

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Environment

Set these variables in production:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://your-domain.example
DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=card_games_dashboard
DB_USERNAME=...
DB_PASSWORD=...
```

## Operational Notes

- Use HTTPS and secure cookies at the reverse proxy/web server layer.
- Run database backups because all round history is persisted.
- Add authentication middleware before public deployment if the dashboard should not be publicly writable.
- Use queue workers if future notifications or exports are introduced.
