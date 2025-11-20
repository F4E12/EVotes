
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
    git clone https://github.com/yourusername/evotes.git
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
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Run the application**
    ```bash
    php artisan serve
    npm run dev
    ```

