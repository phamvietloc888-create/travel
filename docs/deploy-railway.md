# Deploy Laravel Travel App to Railway

This repository now includes a Docker-based deployment setup intended for a quick public demo.

## What is included

- `Dockerfile`: builds frontend assets and runs the Laravel app in a container
- `docker/start-container.sh`: creates the storage link and optionally runs migrations
- `railway.json`: configures Railway health checks via `/up`
- `.env.railway.example`: production environment variable template

## Important limitation

This repo does **not** currently include the full database schema for core tables such as `tours`, `destinations`, and `bookings`.

That means a fresh Railway database will not be enough by itself unless you also:

1. Import your current MySQL database export, or
2. Add the missing migrations before deploying

## Railway steps

1. Push this project to GitHub.
2. In Railway, create a new project from that GitHub repo.
3. Add a MySQL service in the same Railway project.
4. Copy values from `.env.railway.example` into Railway Variables.
5. Fill `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` from the Railway MySQL service.
6. Set `APP_URL` to your Railway public domain.
7. Generate one Laravel app key locally:

   ```bash
   php artisan key:generate --show
   ```

8. Paste that value into `APP_KEY` on Railway.
9. Leave `RUN_MIGRATIONS=false` unless your Railway MySQL database already has the missing base tables or you later add the missing migrations.
10. Deploy.

## Recommended Railway variables

```env
APP_ENV=production
APP_DEBUG=false
FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
RUN_MIGRATIONS=false
```

## Uploads and images

- Uploaded files are stored under `storage/app/public`
- The container startup script runs `php artisan storage:link`
- If you redeploy often, use a persistent volume or object storage later for long-term uploaded media

## After deploy

Check these URLs:

- `/`
- `/up`
- `/admin`

If the home page returns a database error, your Railway app is up but the database schema/data has not been imported yet.
