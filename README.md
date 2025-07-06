# HT Roadside - Roadside Assistance Service Platform

A comprehensive roadside assistance service platform built with Laravel, featuring service request management, payment processing, real-time assistance tracking, and a fully-featured blog system with newsletter functionality.




## sample logins
Admin user: admin@htroadside.com (password: admin123)
Service provider: provider@htroadside.com (password: provider123)
Customer: customer@htroadside.com (password: customer123)


## Features

### User Features
- User registration and authentication
- Service request creation and tracking
- Real-time service status updates
- Payment processing
- Service history
- Emergency contact management
- Service provider ratings and reviews
- Profile management
- Blog with categorized articles and search functionality
- Newsletter subscription and management
- Feedback submission

### Admin Features
- Dashboard with analytics
- User management
- Service request management
- Payment tracking
- Service provider management
- Job application processing
- Website settings management
- Reports and analytics
- Blog post management (create, edit, delete)
- Blog category and tag management
- Comment moderation
- Newsletter subscriber management
- Feedback review and management

### Service Provider Features
- Service request acceptance
- Real-time location tracking
- Payment collection
- Service history
- Performance metrics
- Profile management

## Requirements

- PHP >= 8.1
- MySQL >= 5.7
- Node.js >= 16
- Composer
- XAMPP (for local development)

## Installation

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd htroadside
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create new database named 'htroadside'
   - Update .env file with database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=htroadside
     DB_USERNAME=root
     DB_PASSWORD=
     ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database with Initial Data (Optional)**
   ```bash
   # Seed database with sample data including blog categories, tags, and posts
   php artisan db:seed
   ```

8. **Start Development Servers**
   ```bash
   # Terminal 1 - Laravel development server
   php artisan serve

   # Terminal 2 - Vite development server
   npm run dev
   ```

9. **Access the Application**
   - Frontend: http://localhost:8000
   - Blog: http://localhost:8000/blog
   - Admin Panel: http://localhost:8000/admin
   - Admin Blog Management: http://localhost:8000/admin/blog

## Development

### Directory Structure
- `app/` - Core application code
- `resources/` - Views, assets, and frontend resources
- `database/` - Migrations and seeders
- `routes/` - Application routes
- `public/` - Publicly accessible files
- `config/` - Configuration files

### Key Commands
```bash
# Run migrations
php artisan migrate

# Create new migration
php artisan make:migration migration_name

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller ControllerName

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run tests
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## Security

If you discover any security-related issues, please email security@htroadside.com instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
