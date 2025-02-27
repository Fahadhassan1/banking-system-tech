<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Running This Project

To get started with this project, follow these steps:

php 8.2
Laravel 9.52.20
node 22

1. **Clone the repository:**
    ```bash
    git clone https://github.com/Fahadhassan1/banking-system-tech.git
    cd banking-system-tech
    ```

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Set up environment variables:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure your `.env` file:**
    Update your `.env` file with your database and other configurations.
    
    change database port specially 
    Email configuration as well becasue 2FA is enabled and code will be sent to Email

5. **Run database migrations:**
    ```bash
    php artisan migrate
    ```    

6. **Start the development server:**
    ```bash
    php artisan serve
    ```
7.  **Make a build and run npm packages for frontend :**
    ```bash
    npm install
    npm run dev
    ```   

## Running Tests

To run the tests, follow these steps:

1. **Set up the testing environment:**
    ```bash
    php artisan key:generate --env=testing
    ```

2. **Run database migrations for testing:**
    ```bash
    php artisan migrate --env=testing
    ```

3. **Run the tests:**
    ```bash
    php artisan test
    ```