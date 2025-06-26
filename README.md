
## Overview

This project is a backend system designed to manage the assignment of drivers to restaurants. It is developed with Laravel and follows the **Repository-Service pattern** to ensure a clean separation of concerns between data access and business logic.

## Getting Started

Follow the instructions below to set up and run the project on your local environment.

### Prerequisites

-   PHP >= 8.0
-   Composer
-   Redis server installed and running
-   A supported database (MySQL)
-   Git

---

### Installation Steps

1. **Clone the repository**

    git clone https://github.com/ghrabla/Laravel-delivery-driver-allocator.git
    cd Laravel-delivery-driver-allocator

2. **Install PHP dependencies**

    composer install

3. **Set up environment configuration**

    cp .env.example .env

4. **Generate application key**

    php artisan key:generate

5. **Run database migrations and seed the database**

    php artisan migrate --seed

6. **Run the Laravel development server**

    php artisan serve

7. **Run Tests (DriverServiceTest)**

    php artisan test --filter=DriverServiceTest
