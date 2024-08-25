# apache-laravel
Setup Laravel with Apache server and MySQL database on your domain.

## Apache Installation
### Step 1: Install Apache
```bash
sudo apt update
sudo apt install apache2
```
### Step 2: Verify Apache Installation
Check if Apache is running:

```bash
sudo systemctl status apache2
If Apache is not running, start it:

```bash
sudo systemctl start apache2
```
### Step 3: Configure Apache to Start on Boot
 To ensure Apache starts automatically on server boot:

```bash
sudo systemctl enable apache2
```
## Setup Laravel
### Step 1: Clone the Laravel Repository
Clone your Laravel repository:

```bash
git clone --depth 1 <repository_url> <destination_directory>
```
- <repository_url>: The URL of your Laravel repository.
- <destination_directory>: Directory where you want to clone the repository.
### Step 2: Install PHP and Required Extensions
Install PHP and necessary extensions:

```bash
sudo apt update
sudo apt install php php-cli php-mysql libapache2-mod-php php-xml php-mbstring
```
### Step 3: Configure Apache for Laravel
- #### Create a Virtual Host Configuration
Navigate to the sites-available directory and create a new configuration file for Laravel:

```bash
cd /etc/apache2/sites-available/
sudo nano yourdomain.com.conf
```
- ####  Add the following content, replacing yourdomain.com with your actual domain:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/<destination_directory>/public

    <Directory /var/www/html/<destination_directory>/public>
        AllowOverride All
        Require all granted
    </Directory>

    # Optional: Log directives
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
- #### Enable the Virtual Host and Necessary Modules
```bash
sudo a2ensite yourdomain.com.conf
sudo a2enmod rewrite
```
### Step 4: Disable Default Site (if necessary)
```bash
sudo a2dissite 000-default.conf
```
### Step 5: Reload Apache
 Apply the configuration changes by reloading Apache:

```bash
sudo systemctl reload apache2
```
## Install MySQL
### Step 1: Install MySQL
```bash
sudo apt update
sudo apt install mysql-server
```
### Step 2: Secure MySQL Installation
Run the MySQL secure installation script to improve security:

```bash
sudo mysql_secure_installation
```
### Step 3: Create a MySQL Database and User for Laravel
Log into MySQL as the root user:

```bash
sudo mysql -u root -p
```
Create a new database and user, and grant privileges:

```sql
CREATE DATABASE your_database_name;
CREATE USER 'your_database_user'@'localhost' IDENTIFIED BY 'your_database_password';
GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_database_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
### Step 4: Update Laravel Configuration
Update the .env file in your Laravel project to include the database credentials:

```bash
sudo nano /var/www/html/<destination_directory>/.env
```
Ensure the following lines are updated with your database information:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
### Step 5: Install Laravel Dependencies
Navigate to your Laravel project directory and install dependencies:

```bash
cd /var/www/html/<destination_directory>
composer install
```
### Step 6: Generate Application Key
Generate a new application key:

```bash
php artisan key:generate
```
### Step 7: Migrate Database (if needed)
Run migrations to set up your database schema:

```bash
php artisan migrate
```

## Configure Apache

To configure Apache to serve a website based on a domain name, you'll need to set up a Virtual Host. Here's how you can do it on Ubuntu:

### Step 1: Enable the rewrite module (optional but recommended)

This module allows URL rewriting, which is often needed for domain-based routing.

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Step 2: Create a Virtual Host Configuration File

#### Navigate to the sites-available directory:

```bash
cd /etc/apache2/sites-available/
```

#### Create a new configuration file for your domain:

- #### Replace yourdomain.com with your actual domain name.

```bash
sudo nano yourdomain.com.conf
```

- #### Add the following content to the file:

```apache
<VirtualHost *:80>
    ServerName apache-laravel.bimash.com.np

    ProxyPass /  http://localhost:8000/
    ProxyPassReverse /  http://localhost:8000/

    <Proxy *>
        Require all granted
    </Proxy>

    # Optional: Log directives for debugging
    ErrorLog ${APACHE_LOG_DIR}/proxy_error.log
    CustomLog ${APACHE_LOG_DIR}/proxy_access.log combined
</VirtualHost>

```

- #### Enable Required Apache Modules


```bash
sudo a2enmod proxy
sudo a2enmod proxy_http
```
- #### Save and Enable the Virtual Host


```bash
sudo a2ensite apache-laravel.bimash.com.np.conf
```

### Step 3: Disable Conflicting Sites

If there’s a default site that could conflict, disable it:

```bash
sudo a2dissite 000-default.conf
```

### Step 4: Reload Apache

Apply the configuration changes by reloading Apache:

```bash
sudo systemctl reload apache2
```

### Step 5: Check DNS

Ensure that the DNS for apache-laravel.bimash.com.np points to your server’s IP address.

### Step 6: Test the Configuration

Open a web browser and go to http://yourdomain.com. You should see the "Welcome to yourdomain.com" message you added in the index.html file.
If you need to use SSL (HTTPS), you can obtain and configure an SSL certificate using Let's Encrypt with Certbot. This is often required for modern web standards.



## Manual Deployment

### Step 1: Pull the Latest Changes

Navigate to your Laravel project directory and pull the latest changes:

``` bash
cd /path/to/your/apache-laravel/
git pull origin main
```
Adjust the branch name (main in this case) as needed.

### Step 2: Clear and Cache Configurations

Run Laravel's artisan commands to clear any cached configurations or views:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:clear
```
### Step 3: Reload Apache

To apply any changes to the Apache configuration, reload Apache:

```bash
sudo systemctl reload apache2
```
### Step 4: Check for Laravel Queue Workers or Background Jobs

If your application uses queue workers or background jobs, you might need to restart them. You can restart the Laravel queue workers with:

```bash
php artisan queue:restart
```
If you're using Supervisor or another process manager, restart those services as well.

### Step 5: Verify Changes

After reloading Apache and clearing the Laravel cache, visit your application’s URL to verify that the changes have been applied correctly.

## CI/CD Pipeline Deployment

```yaml
name: 🚀 Deploy Laravel
on:
  push:
    branches:
      - main

jobs:
  web-deploy:
    name: 🎉 Deploy
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v2

      - name: Set up PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1.2'

      - name: Install Composer dependencies
        run: composer install --no-interaction --no-suggest

      - name: Set up SSH
        uses: webfactory/ssh-agent@v0.7.0
        with:
          ssh-private-key: ${{ secrets.SSH_PRIVATE_KEY }}

      - name: Deploy to Azure VM
        run: |
          ssh -o StrictHostKeyChecking=no azureuser@20.51.207.28 << 'EOF'
          cd apache/apache-laravel/
          git pull origin main || { echo 'Git pull failed'; exit 1; }
          php artisan config:cache || { echo 'Config cache failed'; exit 1; }
          php artisan route:cache || { echo 'Route cache failed'; exit 1; }
          php artisan view:clear || { echo 'View clear failed'; exit 1; }
          sudo systemctl reload apache2 || { echo 'Apache reload failed'; exit 1; }
          php artisan queue:restart || { echo 'Queue restart failed'; exit 1; }
          EOF

```

