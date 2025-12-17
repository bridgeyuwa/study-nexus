# Study Nexus

Study Nexus is a comprehensive online directory of higher education institutions in Nigeria. It provides a platform for students to discover and compare universities, polytechnics, monotechnics, and colleges of education, with detailed information on academic programs, rankings, and news updates.

## Local Development Setup

This project uses [Laravel Sail](https://laravel.com/docs/sail), a light-weight command-line interface for interacting with Laravel's default Docker development environment.

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/study-nexus.git
    cd study-nexus
    ```

2.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

3.  **Install Composer dependencies:**
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

4.  **Start the Sail containers:**
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Generate the application key:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

Your application will be available at [http://localhost](http://localhost).

## Code Quality

This project is committed to high code quality, enforced by the following tools:

### Code Formatting (Laravel Pint)

We use [Laravel Pint](https://laravel.com/docs/pint) for automated code style fixing.

-   **Check for style issues:**
    ```bash
    ./vendor/bin/sail pint --test
    ```

-   **Automatically fix style issues:**
    ```bash
    ./vendor/bin/sail pint
    ```

### Static Analysis (Larastan)

We use [Larastan](https://github.com/nunomaduro/larastan) for static analysis to find potential bugs before they reach production.

-   **Run static analysis:**
    ```bash
    ./vendor/bin/sail phpstan analyse
    ```

## Architectural Overview

The application's architecture emphasizes clean controllers and reusable code. Key architectural patterns include:

### Controller Traits

To avoid code duplication and keep controllers focused on their primary responsibility of handling HTTP requests, common cross-cutting concerns have been extracted into traits:

-   **`App\Traits\ProvidesCache`**: A wrapper for `Cache::remember` that provides a consistent caching strategy. It also supports cache tagging to allow for granular cache invalidation.
-   **`App\Traits\ProvidesSEO`**: A simple helper for generating `SEOData` objects, ensuring consistent SEO metadata across the application.
-   **`App\Traits\GeneratesShareLinks`**: A reusable method to generate social media sharing links for the current page.

These traits are used in controllers like `HomeController`, `InstitutionController`, and `ProgramController` to handle caching, SEO, and social sharing, resulting in a more maintainable and readable codebase.
