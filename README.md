
# Evotes

## Getting Started

### Prerequisites
- Git
- PHP 8.0+
- Composer
- Node.js & npm

### Installation

1. **Clone the repository**
    ```bash
    git clone https://github.com/F4E12/EVotes.git
    cd evotes
    ```

2. **Install PHP dependencies**
    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**
    ```bash
    npm install
    ```

4. **Configure environment**
    Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

5. **Set up the database**
    - Open the `.env` file in a text editor.
    - If you are using XAMPP, ensure your MySQL server is running.

      <img width="834" height="541" alt="image" src="https://github.com/user-attachments/assets/10d609c9-fa60-429f-9381-ed6c5e86f7a8" />

    - Update the database credentials in the `.env` file. For a default XAMPP setup, you would typically use:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=evotes
        DB_USERNAME=root
        DB_PASSWORD=
        ```
    - Create a new database named `evotes` in phpMyAdmin (or your preferred database management tool).

6. **Generate application key and run migrations**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

7. **Run the application**
    Open two terminal windows and run the following commands:
    ```bash
    # Terminal 1
    php artisan serve
    ```
    ```bash
    # Terminal 2
    npm run dev
    ```
