# Class Schedule Management System

A comprehensive Laravel 12 application for managing educational institution class schedules, with support for Admin and Student roles.

## Features

### Admin Features
- **Dashboard**: Overview of system statistics and upcoming schedules
- **Schedule Management**: Create, read, update, delete class schedules with conflict detection
- **Subject Management**: Manage academic subjects and units
- **Section Management**: Organize student groups by course and year level
- **Room Management**: Track classroom resources and capacity
- **Instructor Management**: Manage faculty information
- **Student Management**: Register and manage student accounts and enrollment
- **Reporting**: 
  - Conflict reports (room, instructor, section overlaps)
  - Instructor workload reports
  - Room utilization reports
  - Export schedules to PDF and Excel

### Student Features
- **My Schedule**: View personal class schedule with subject, instructor, room, and time details
- **Dashboard**: Quick view of enrolled classes

## Technology Stack

- **Framework**: Laravel 12
- **Database**: PostgreSQL (recommended for Railway)
- **Authentication**: Laravel Breeze
- **Frontend**: Bootstrap 5
- **Reporting**: DomPDF & Maatwebsite Excel
- **Hosting**: Railway (or any PHP 8.2+ host)

## Requirements

- PHP 8.2 or higher
- Composer
- PostgreSQL or MySQL
- Node.js & NPM (for frontend build tools)

## Local Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd laravel-schedule-system
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=schedule_system
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### 4. Run migrations and seeders

```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Seed with default admin account
- Seed with sample subjects, sections, rooms, instructors, and students
- Create sample class schedules

### 5. Build assets

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 6. Start development server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Credentials

### Admin Account
- **Email**: admin@classschedule.com
- **Password**: password123

### Student Accounts
- **John Doe**: john.doe@student.com / password123
- **Jane Smith**: jane.smith@student.com / password123
- **Bob Johnson**: bob.johnson@student.com / password123

## Deployment on Railway

### Prerequisites
- Railway account (railway.app)
- PostgreSQL database (configured on Railway)

### Deployment Steps

#### 1. Connect Repository

1. Go to [Railway](https://railway.app)
2. Create a new project
3. Connect your GitHub repository

#### 2. Configure Environment Variables

In Railway dashboard, add these variables:

```env
APP_NAME="Class Schedule System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.railway.app

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

DATABASE_URL=${{Postgres.DATABASE_URL}}

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls

TIMEZONE=UTC
```

#### 3. Add PostgreSQL Service

1. In Railway, add a PostgreSQL service to your project
2. The environment variables above will be automatically populated

#### 4. Configure Web Service

Set the start command in Railway:

```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080
```

Or use Procfile (included):

```bash
web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force
```

#### 5. Deploy

Push your changes to GitHub. Railway will automatically deploy.

```bash
git add .
git commit -m "Deploy to Railway"
git push origin main
```

#### 6. Run Database Setup (First Deploy)

Once deployed, run seeders:

```bash
railway run php artisan db:seed
```

Or access the Railway CLI and run:

```bash
railway shell
php artisan db:seed
```

## File Structure

```
laravel-schedule-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Route controllers
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic services
│   └── Exports/              # Excel exports
├── database/
│   ├── migrations/           # Database schema
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript
├── routes/
│   └── web.php               # Web routes
├── public/
│   └── index.php             # Application entry point
├── .env.example              # Example environment file
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
└── README.md                 # This file
```

## Database Schema

### Users
- id, name, email, password, role (admin/student), is_active, timestamps

### Students
- id, user_id, student_number, full_name, email, section_id, course, year_level, enrollment_date, is_active, timestamps

### Instructors
- id, employee_id, full_name, email, contact_number, department, academic_rank, is_active, timestamps

### Subjects
- id, subject_code, subject_name, units, description, is_active, timestamps

### Sections
- id, section_code, section_name, course, year_level, student_capacity, is_active, timestamps

### Rooms
- id, room_number, building, capacity, room_type, has_projector, has_ac, is_active, timestamps

### Schedules
- id, subject_id, instructor_id, section_id, room_id, day_of_week, start_time, end_time, semester, academic_year, status, notes, timestamps

## API Routes

All routes require authentication and are prefixed with `/`:

### Admin Routes
- `GET /dashboard` - Admin dashboard
- `GET/POST/PUT/DELETE /subjects` - Subject CRUD
- `GET/POST/PUT/DELETE /sections` - Section CRUD
- `GET/POST/PUT/DELETE /rooms` - Room CRUD
- `GET/POST/PUT/DELETE /instructors` - Instructor CRUD
- `GET/POST/PUT/DELETE /students` - Student CRUD
- `GET/POST/PUT/DELETE /schedules` - Schedule CRUD
- `GET /reports` - Reports dashboard
- `GET /reports/conflicts` - Conflict report
- `GET /reports/instructor-load` - Instructor workload
- `GET /reports/room-utilization` - Room utilization
- `GET /reports/export-pdf` - Export PDF
- `GET /reports/export-excel` - Export Excel

### Student Routes
- `GET /dashboard` - Student dashboard
- `GET /my-schedule` - View personal schedule

### Authentication
- `POST /register` - Register new account
- `POST /login` - Login
- `POST /logout` - Logout
- `GET /profile` - View profile
- `PUT /profile` - Update profile

## Troubleshooting

### Database Connection Issues

**Error**: `SQLSTATE[HY000]: General error: 1030 Got error 28`

**Solution**: Check available disk space and database credentials.

### Migration Issues

**Error**: `SQLSTATE[42P07]: Duplicate table`

**Solution**: Clear cached migrations:

```bash
php artisan cache:clear
php artisan config:cache
```

### Permission Issues on Railway

**Solution**: Ensure the storage directory is writable:

```bash
chmod -R 775 storage bootstrap/cache
```

### Schedule Conflicts Not Detected

**Solution**: Ensure all schedule times are in HH:MM format (24-hour).

## Performance Optimization

1. **Caching**: Enable query caching for frequently accessed reports
2. **Indexing**: Database indexes are configured for day_of_week, start_time, and end_time
3. **Pagination**: All list views paginate results (15 per page)
4. **Lazy Loading**: Relationships use lazy loading with explicit eager loading where needed

## Security Features

- Role-based access control (Admin/Student)
- Password hashing with Laravel's default algorithm
- CSRF protection on all forms
- SQL injection prevention with parameterized queries
- Input validation on all forms
- Email verification available (can be enabled in config)

## Backup & Maintenance

### Regular Backups (Railway)

Use Railway's backup features or setup automated dumps:

```bash
pg_dump $DATABASE_URL > backup-$(date +%Y%m%d).sql
```

### Clearing Old Data

```bash
php artisan tinker
# Delete old schedules
Schedule::where('status', 'cancelled')->delete();
```

## Support & Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Breeze](https://laravel.com/docs/12.x/starter-kits#laravel-breeze)
- [Railway Documentation](https://docs.railway.app)
- [PostgreSQL Documentation](https://www.postgresql.org/docs)

## License

MIT License - see LICENSE file for details

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Push to the branch
5. Create a Pull Request

## Changelog

### Version 1.0.0
- Initial release
- Complete CRUD operations for all resources
- Admin dashboard with statistics
- Student schedule viewing
- Conflict detection system
- PDF/Excel export functionality
- Railway deployment ready
