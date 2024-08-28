Prerequisites
Before you start, ensure you have the following installed on your machine:

1. XAMPP (includes Apache, PHP, and MySQL)
2. Composer (for managing PHP dependencies)
3. Node.js (version 16 or higher, for Vue 3)
4. npm (Node Package Manager, comes with Node.js)

Open the XAMPP Control Panel and start both Apache and MySQL services.

Clone the Repository to the XAMPP htdocs Directory.

Navigate to the backend folder: cd formflow-backend
1. Install PHP Dependencies: composer install
2. Create the .env file
3. Configure the .env file to connect it with the database
4. Generate an Application Key: php artisan key:generate
5. Run Database Migrations and Seeders
6. Execute: php artisan serve

Navigate to the frontend folder: cd formflow-frontend
1. Install Node.js Dependencies: npm install
2. Execute: npm run dev
