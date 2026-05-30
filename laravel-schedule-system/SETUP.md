# Complete Setup Guide

This guide walks you through the complete setup of the Laravel Class Schedule Management System, from local development to Railway deployment.

## Table of Contents

1. [Local Development Setup](#local-development-setup)
2. [Database Configuration](#database-configuration)
3. [Running the Application](#running-the-application)
4. [Railway Deployment](#railway-deployment)
5. [Post-Deployment Steps](#post-deployment-steps)
6. [Troubleshooting](#troubleshooting)

## Local Development Setup

### Step 1: Prerequisites

Ensure you have installed:

- **PHP 8.2+** - [Download PHP](https://www.php.net/downloads)
- **Composer** - [Install Composer](https://getcomposer.org/download/)
- **Node.js 18+** - [Download Node.js](https://nodejs.org/)
- **PostgreSQL 12+** or **MySQL 8.0+**
- **Git** - [Download Git](https://git-scm.com/)

### Step 2: Clone the Repository

```bash
git clone https://github.com/yourusername/laravel-schedule-system.git
cd laravel-schedule-system
```

### Step 3: Install PHP Dependencies

```bash
composer install
```

This will install all Laravel packages and dependencies listed in `composer.json`.

### Step 4: Install Node Dependencies

```bash
npm install
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

This creates the `APP_KEY` in your `.env` file, which Laravel uses for encryption.

### Step 6: Create Environment File

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database connection.

## Database Configuration

### For PostgreSQL (Recommended)

Edit `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=schedule_system
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Create the database:

```bash
createdb schedule_system
```

### For MySQL

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schedule_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 7: Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This will:
1. Create all database tables
2. Seed sample data (admin user, subjects, instructors, rooms, sections, students, schedules)

**Note**: The `--seed` flag runs the seeders automatically. If you only want migrations:

```bash
php artisan migrate
```

## Running the Application

### Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Build Frontend Assets

In a separate terminal:

```bash
npm run dev
```

For production build:

```bash
npm run build
```

### Default Login Credentials

**Admin**:
- Email: `admin@classschedule.com`
- Password: `password123`

**Student**:
- Email: `john.doe@student.com`
- Password: `password123`

## Railway Deployment

### Step 1: Create Railway Account

1. Go to [Railway.app](https://railway.app)
2. Sign up with GitHub or email
3. Create a new project

### Step 2: Connect GitHub Repository

1. In Railway dashboard, click "New Project"
2. Select "Deploy from GitHub"
3. Connect your GitHub account
4. Select your repository
5. Railway will automatically detect it's a Laravel project

### Step 3: Add PostgreSQL Service

1. Click "Add" in the Railway dashboard
2. Search for "PostgreSQL"
3. Click to add PostgreSQL to your project

### Step 4: Set Environment Variables

In Railway project settings, add these variables:

```env
APP_NAME=Class Schedule System
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your_key_here
APP_URL=https://your-project.railway.app

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

DATABASE_URL=${{Postgres.DATABASE_URL}}

TIMEZONE=UTC

# Email Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@classschedule.com
```

**Important**: Generate APP_KEY locally first:

```bash
php artisan key:generate --show
```

Copy the key (including `base64:` prefix) and paste it in Railway as `APP_KEY`.

### Step 5: Configure Deployment

Railway will use the `Procfile` to deploy. Ensure it contains:

```
web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force
```

This tells Railway to:
1. Use Apache to serve the application from the `public/` directory
2. Run migrations automatically during deployment

### Step 6: Deploy

Push your code to GitHub:

```bash
git add .
git commit -m "Ready for Railway deployment"
git push origin main
```

Railway will automatically detect the push and start deployment. Watch the logs in the Railway dashboard.

### Step 7: Post-Deployment Database Setup

Once deployment is successful:

#### Option A: Using Railway CLI

```bash
railway login
railway shell
php artisan db:seed
```

#### Option B: Using SSH

```bash
railway shell
php artisan db:seed
```

#### Option C: Using Railway Dashboard

1. Go to your project in Railway
2. Click on the web service
3. Click "Deploy Logs" tab
4. Scroll to see the deployment details

The `release` command in Procfile automatically runs `migrate --force`, so database tables are created automatically.

## Post-Deployment Steps

### Step 1: Verify Deployment

1. Visit your Railway URL
2. Log in with admin credentials:
   - Email: `admin@classschedule.com`
   - Password: `password123`

### Step 2: Configure Domain (Optional)

In Railway:

1. Go to your project settings
2. Find the "Domains" section
3. Add your custom domain
4. Update DNS records as instructed

### Step 3: Set Up Email (Optional)

To enable email notifications:

1. Get SMTP credentials from [Mailtrap.io](https://mailtrap.io) or another provider
2. Update these in Railway environment variables:
   - `MAIL_HOST`
   - `MAIL_USERNAME`
   - `MAIL_PASSWORD`
   - `MAIL_FROM_ADDRESS`

### Step 4: Enable HTTPS

Railway automatically provides HTTPS for Railway domains. For custom domains, configure SSL in your DNS provider.

### Step 5: Setup Automated Backups

In Railway PostgreSQL service:

1. Go to PostgreSQL service
2. Enable backups in service settings
3. Set backup frequency (daily recommended)

## Troubleshooting

### Database Connection Issues

**Error**: `SQLSTATE[HY000]: General error: 1030 Got error 28 from storage engine`

**Solutions**:

1. Check PostgreSQL is running:
   ```bash
   pg_isready
   ```

2. Verify credentials in `.env`

3. Check database exists:
   ```bash
   psql -l
   ```

4. Recreate database:
   ```bash
   dropdb schedule_system
   createdb schedule_system
   php artisan migrate:fresh --seed
   ```

### Migration Errors

**Error**: `SQLSTATE[42P07]: Duplicate table`

**Solution**:

```bash
php artisan migrate:rollback
php artisan migrate
```

Or reset completely:

```bash
php artisan migrate:fresh --seed
```

### Permission Denied Errors

**Solution** (Local):

```bash
chmod -R 755 storage bootstrap/cache
php artisan config:cache
php artisan cache:clear
```

**Solution** (Railway):

Railway handles permissions automatically. If you see permission errors, clear cache:

```bash
railway shell
php artisan cache:clear
php artisan config:clear
```

### Composer Memory Issues

If you get memory exhaustion errors during deployment:

1. Locally, increase PHP memory:
   ```bash
   php -d memory_limit=-1 /usr/bin/composer install
   ```

2. In Railway, composer handles this automatically.

### Application Not Starting

**Check logs**:

```bash
# Local
php artisan tinker
# Test database connection

# Railway
railway logs web
railway logs --tail
```

**Common issues**:
- Missing `.env` file
- Wrong database credentials
- Missing migrations
- Wrong APP_KEY

### Schedule Conflicts Not Working

Ensure times are in 24-hour HH:MM format:
- `08:00` ✓ Correct
- `8:00` ✗ Wrong
- `20:30` ✓ Correct
- `8:30PM` ✗ Wrong

### Views Not Loading (Blade Template Errors)

Clear cache:

```bash
php artisan view:clear
php artisan cache:clear
```

Recompile:

```bash
npm run dev  # or build
```

## Development Tips

### Creating a New Migration

```bash
php artisan make:migration create_new_table
```

Edit in `database/migrations/` and run:

```bash
php artisan migrate
```

### Creating a New Model

```bash
php artisan make:model NewModel -m  # -m creates migration
```

### Creating a New Controller

```bash
php artisan make:controller NewController --resource
```

### Using Tinker (Interactive Shell)

```bash
php artisan tinker
>>> User::all()
>>> Schedule::where('status', 'active')->count()
```

### Running Tests

```bash
php artisan test
```

## Performance Optimization

### 1. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Enable Query Logging (Development Only)

In `.env`:

```env
DB_LOG_QUERIES=true
```

### 3. Database Indexing

Schedules are indexed on:
- `subject_id`
- `instructor_id`
- `section_id`
- `room_id`
- `(day_of_week, start_time, end_time)` - composite index

## Security Best Practices

1. **Environment Variables**: Never commit `.env` to git
2. **Database Passwords**: Use strong passwords in production
3. **Session Security**: Enable CSRF protection (default in Laravel)
4. **Role-Based Access**: Always check `auth()->user()->isAdmin()` for admin routes
5. **Input Validation**: All form inputs are validated
6. **SQL Injection Prevention**: Using Eloquent ORM with parameterized queries

## Next Steps

- Customize views in `resources/views/`
- Add more features following Laravel conventions
- Setup email notifications
- Configure log aggregation
- Setup monitoring and alerting
- Create API endpoints if needed

## Support

For issues:

1. Check this guide's Troubleshooting section
2. Review [Laravel Documentation](https://laravel.com/docs)
3. Check [Railway Docs](https://docs.railway.app)
4. Open an issue on your repository

---

**Deployment checklist**:

- [ ] PHP 8.2+ installed locally
- [ ] Composer installed
- [ ] Node.js installed
- [ ] PostgreSQL/MySQL running
- [ ] Repository cloned
- [ ] Dependencies installed (`composer install && npm install`)
- [ ] `.env` configured with database credentials
- [ ] APP_KEY generated (`php artisan key:generate`)
- [ ] Migrations run (`php artisan migrate:fresh --seed`)
- [ ] Assets built (`npm run build`)
- [ ] Local server tested (`php artisan serve`)
- [ ] GitHub repository connected to Railway
- [ ] PostgreSQL added to Railway project
- [ ] Environment variables set in Railway
- [ ] Procfile configured
- [ ] Code pushed to GitHub
- [ ] Railway deployment successful
- [ ] Database seeded in production
- [ ] Production login tested
- [ ] Backups configured
