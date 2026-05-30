# Quick Start Guide

Get the Class Schedule Management System running in 5 minutes!

## Prerequisites Checklist

Before starting, ensure you have:

- [ ] PHP 8.2+ installed: `php --version`
- [ ] Composer installed: `composer --version`
- [ ] Node.js 18+ installed: `node --version`
- [ ] PostgreSQL running (or MySQL)
- [ ] Git installed: `git --version`

## 5-Minute Setup

### 1. Clone & Navigate (1 min)

```bash
git clone <your-repo-url>
cd laravel-schedule-system
```

### 2. Install Dependencies (2 min)

```bash
composer install
npm install
```

### 3. Configure Environment (1 min)

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=schedule_system
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

Create database:

```bash
createdb schedule_system  # PostgreSQL
# OR
mysql -u root -p -e "CREATE DATABASE schedule_system;"  # MySQL
```

### 4. Run Database Setup (1 min)

```bash
php artisan migrate:fresh --seed
```

## Start Developing

### Terminal 1: Laravel Server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

### Terminal 2: Frontend Build (Optional)

```bash
npm run dev
```

## Default Credentials

**Admin Dashboard**
- Email: `admin@classschedule.com`
- Password: `password123`

**Student Account**
- Email: `john.doe@student.com`
- Password: `password123`

## What You Get

✅ Full admin dashboard with statistics
✅ Complete CRUD for all resources
✅ Schedule conflict detection
✅ Student schedule viewing
✅ Report generation
✅ User authentication

## Testing Key Features

### 1. Login as Admin

1. Go to http://localhost:8000
2. Click "Login"
3. Enter: `admin@classschedule.com` / `password123`
4. Explore the admin dashboard

### 2. Create a Schedule

1. Click "Schedules" in sidebar
2. Click "Create Schedule"
3. Fill form with sample data (already seeded)
4. Click Save

### 3. View Student Schedule

1. Log out
2. Log in as `john.doe@student.com` / `password123`
3. Click "My Schedule"
4. See enrolled classes

### 4. Generate Reports

1. Log in as admin
2. Click "Reports"
3. Try generating conflict reports, instructor loads, etc.

## Common Issues & Fixes

### "SQLSTATE[HY000]: General error"

**Fix**: Check database credentials in `.env`

```bash
php artisan tinker
# In tinker:
>>> DB::connection()->getPdo();
# Should succeed without error
```

### "Class not found" or "Migration not found"

**Fix**:

```bash
composer dump-autoload
php artisan cache:clear
```

### Port 8000 already in use

**Fix**: Use different port

```bash
php artisan serve --port=8001
```

### npm run dev shows errors

**Fix**:

```bash
npm install
npm run dev
```

## Next: Deploy to Railway

Ready to deploy? Follow [SETUP.md](SETUP.md) for complete Railway deployment guide.

### Quick Railway Steps:

1. Push to GitHub:
   ```bash
   git add .
   git commit -m "Initial commit"
   git push origin main
   ```

2. Go to [Railway.app](https://railway.app)

3. Connect your GitHub repo

4. Add PostgreSQL service

5. Set environment variables (Railway will provide database vars)

6. Watch deployment in Railway dashboard

7. Visit your live application!

## File Structure Reference

```
laravel-schedule-system/
├── app/                 # Application code
│   ├── Models/         # Database models
│   ├── Controllers/    # Route handlers
│   └── Services/       # Business logic
├── database/           # Migrations & seeds
├── resources/
│   ├── views/         # Blade templates
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript
├── routes/            # Application routes
├── .env.example       # Template environment
└── README.md          # Full documentation
```

## Useful Commands

```bash
# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName --resource

# Run tests
php artisan test

# Access database console
php artisan tinker

# Clear all caches
php artisan cache:clear

# View available routes
php artisan route:list
```

## Documentation

- **Complete Setup**: [SETUP.md](SETUP.md)
- **Full Documentation**: [README.md](README.md)
- **File Manifest**: [FILES_CREATED.md](FILES_CREATED.md)

## Support

Having issues? Check:

1. This file's "Common Issues" section
2. [SETUP.md](SETUP.md) Troubleshooting
3. [README.md](README.md) for detailed info
4. Laravel docs: https://laravel.com/docs

## Success Indicators

You'll know it's working when:

- ✅ `php artisan serve` starts without errors
- ✅ http://localhost:8000 loads login page
- ✅ Can login with provided credentials
- ✅ Admin dashboard shows statistics
- ✅ Can view sample schedules
- ✅ Conflict detection works

---

**You're ready to go!** 🚀

Start with: `php artisan serve` and visit http://localhost:8000
