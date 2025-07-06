# HT Roadside Assistance - Deployment Guide

This guide provides instructions for setting up the HT Roadside Assistance platform both locally and on GoDaddy cPanel hosting.

## Local Development Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL 5.7 or higher

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd htroadside
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment variables**
   Copy the `.env.example` file to `.env` and update the following settings:
   ```
   APP_NAME="HT Roadside Assistance"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=htroadside
   DB_USERNAME=your_mysql_username
   DB_PASSWORD=your_mysql_password
   
   # Note: If you've configured MySQL to use port 3308, update DB_PORT accordingly
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations and seed the database**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the website**
   Open your browser and navigate to `http://localhost:8000`

## GoDaddy cPanel Deployment

### Prerequisites
- GoDaddy hosting account with cPanel access
- Economy plan or higher
- Domain configured to point to your hosting

### Deployment Steps

1. **Prepare your project for production**
   - Update your `.env` file with production settings:
     ```
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://yourdomain.com
     
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=your_cpanel_database_name
     DB_USERNAME=your_cpanel_database_username
     DB_PASSWORD=your_cpanel_database_password
     
     MAIL_MAILER=smtp
     MAIL_HOST=your_mail_host
     MAIL_PORT=587
     MAIL_USERNAME=your_email@yourdomain.com
     MAIL_PASSWORD=your_email_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=info@yourdomain.com
     MAIL_FROM_NAME="HT Roadside Assistance"
     ```

2. **Build assets for production**
   ```bash
   npm run build
   ```

3. **Create a ZIP archive of your project**
   - Include all files except:
     - `node_modules/`
     - `.git/`
     - `.github/`
     - `.idea/`
     - `.vscode/`
     - `storage/framework/cache/*`
     - `storage/framework/sessions/*`
     - `storage/framework/views/*`

4. **Upload to GoDaddy cPanel**
   - Log in to your GoDaddy cPanel
   - Navigate to File Manager
   - Go to the `public_html` directory (or create a subdirectory if you want to install in a subfolder)
   - Upload and extract your ZIP archive

5. **Configure the database**
   - In cPanel, go to MySQL Databases
   - Create a new database and user
   - Assign the user to the database with all privileges
   - Update your `.env` file with these credentials

6. **Set proper permissions**
   - Set directories to 755:
     ```bash
     find /path/to/your/laravel/root/directory -type d -exec chmod 755 {} \;
     ```
   - Set files to 644:
     ```bash
     find /path/to/your/laravel/root/directory -type f -exec chmod 644 {} \;
     ```
   - Make storage and bootstrap/cache directories writable:
     ```bash
     chmod -R 775 /path/to/your/laravel/root/directory/storage
     chmod -R 775 /path/to/your/laravel/root/directory/bootstrap/cache
     ```

7. **Run migrations**
   - Connect to your server via SSH (if available) and run:
     ```bash
     php artisan migrate --seed
     ```
   - If SSH is not available, you can use a tool like [Laravel Shift's Artisan Anywhere](https://laravelshift.com/artisan-anywhere)

8. **Configure cPanel for Laravel**
   - Create a `.htaccess` file in your root directory with the following content:
     ```
     <IfModule mod_rewrite.c>
         RewriteEngine On
         RewriteRule ^(.*)$ public/$1 [L]
     </IfModule>
     ```
   - Alternatively, you can point your domain directly to the `public` folder

9. **Clear caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```

10. **Set up cron job for scheduled tasks**
    - In cPanel, go to Cron Jobs
    - Add a new cron job that runs every minute:
      ```
      * * * * * cd /path/to/your/laravel/root/directory && php artisan schedule:run >> /dev/null 2>&1
      ```

11. **Test your website**
    - Visit your domain to ensure everything is working correctly
    - Test all major functionality

## Troubleshooting

### Common Issues on GoDaddy

1. **500 Internal Server Error**
   - Check your `.htaccess` file
   - Verify file permissions
   - Check error logs in cPanel

2. **Database Connection Issues**
   - Verify database credentials in `.env`
   - Check if your database user has proper permissions

3. **White Screen / Blank Page**
   - Enable error reporting in `index.php`
   - Check PHP error logs in cPanel

4. **Assets Not Loading**
   - Verify asset paths in your templates
   - Check if the `public` directory is properly configured

## Maintenance

### Regular Maintenance Tasks

1. **Keep your application updated**
   ```bash
   composer update
   npm update
   ```

2. **Monitor error logs**
   - Check cPanel logs regularly for errors

3. **Backup your database**
   - Use cPanel's backup tools to regularly backup your database

4. **Update security patches**
   - Keep PHP and all dependencies up to date

For additional support, please contact your developer or refer to the Laravel documentation at https://laravel.com/docs.
