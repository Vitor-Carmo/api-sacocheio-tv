# 🚀 API Saco Cheio TV

<div align="center">

![Logo](path-to-logo) <!-- TODO: Add project logo -->

[![GitHub stars](https://img.shields.io/github/stars/Vitor-Carmo/api-sacocheio-tv?style=for-the-badge)](https://github.com/Vitor-Carmo/api-sacocheio-tv/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/Vitor-Carmo/api-sacocheio-tv?style=for-the-badge)](https://github.com/Vitor-Carmo/api-sacocheio-tv/network)
[![GitHub issues](https://img.shields.io/github/issues/Vitor-Carmo/api-sacocheio-tv?style=for-the-badge)](https://github.com/Vitor-Carmo/api-sacocheio-tv/issues)
[![GitHub license](https://img.shields.io/github/license/Vitor-Carmo/api-sacocheio-tv?style=for-the-badge)](LICENSE)

**🎲 API para o Saco Cheio TV APP que manipula a API oficial Saco Cheio TV.**

</div>

## 📖 Overview

This repository hosts the **API Saco Cheio TV**, a backend service designed to act as an intermediary for the official Saco Cheio TV API. Its primary purpose is to centralize and facilitate the manipulation of data from the official API, serving as a dedicated backend for the Saco Cheio TV mobile application. It offers a structured and secure interface to consume and potentially process content related to Saco Cheio TV, such as episodes, shows, and other media.

## ✨ Features

-   🎯 **Official API Proxy**: Efficiently proxies and manipulates data from the external Saco Cheio TV API.
-   🔐 **JWT Authentication**: Secures API endpoints using JSON Web Tokens (JWT) for authenticated access.
-   ⚙️ **RESTful Design**: Provides a clean and intuitive RESTful interface for content consumption.
-   🛠️ **Environment-based Configuration**: Easily configurable via `.env.php` for different environments (development, production).
-   🚀 **Lightweight & Performant**: Built with a minimal set of powerful PHP libraries for speed and efficiency.

## 🛠️ Tech Stack

**Backend:**
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-2.x-885630?style=for-the-badge&logo=composer&logoColor=white)](https://getcomposer.org/)
[![FastRoute](https://img.shields.io/badge/FastRoute-1.3-orange?style=for-the-badge&logo=fastroute&logoColor=white)](https://github.com/nikic/FastRoute)
[![Laminas Diactoros](https://img.shields.io/badge/Laminas%20Diactoros-2.x-4B2E83?style=for-the-badge&logo=laminas&logoColor=white)](https://docs.laminas.dev/laminas-diactoros/)
[![PHP-DI](https://img.shields.io/badge/PHP--DI-6.x-blueviolet?style=for-the-badge&logo=php-di&logoColor=white)](http://php-di.org/)
[![PHP-JWT](https://img.shields.io/badge/PHP--JWT-6.x-red?style=for-the-badge&logo=json-web-tokens&logoColor=white)](https://github.com/firebase/php-jwt)
[![Dotenv](https://img.shields.io/badge/Dotenv-5.x-yellowgreen?style=for-the-badge&logo=dotenv&logoColor=white)](https://github.com/vlucas/phpdotenv)

**DevOps:**
[![Apache](https://img.shields.io/badge/Apache-.htaccess-DC394F?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org/)

## 🚀 Quick Start

### Prerequisites
-   **PHP**: Version `7.4.29` or higher.
-   **Composer**: PHP dependency manager.

### Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/Vitor-Carmo/api-sacocheio-tv.git
    cd api-sacocheio-tv
    ```

2.  **Install dependencies**
    ```bash
    composer install
    ```

3.  **Environment setup**
    ```bash
    cp env.example.php .env.php
    ```
    Open `.env.php` and configure your environment variables:
    -   `APP_ENV`: Application environment (e.g., `development`, `production`).
    -   `APP_DEBUG`: Set to `true` for development, `false` for production.
    -   `JWT_SECRET`: A strong, unique secret key for JWT signing.
    -   `SACOCHEIO_API_KEY`: Your API key for the official Saco Cheio TV API.
    -   `SACOCHEIO_API_BASE_URL`: The base URL of the official Saco Cheio TV API.

4.  **Web Server Configuration**
    This API is designed to work with an Apache web server, utilizing the provided `.htaccess` file for URL rewriting.
    -   Point your web server's document root to the `api-sacocheio-tv` project directory.
    -   Ensure `mod_rewrite` is enabled for Apache.

5.  **Start development server (Optional - for quick local testing without full web server setup)**
    You can use PHP's built-in web server for simple local development, though it may not fully replicate `.htaccess` rewrite rules for subdirectories. For full functionality, a proper Apache/Nginx setup is recommended.
    ```bash
    php -S localhost:8000
    ```
    *Note: With the built-in server, you might need to access `http://localhost:8000/index.php/your/api/endpoint` directly or adjust your host's routing.*

## 📁 Project Structure

```
api-sacocheio-tv/
├── App/                    # Core application logic
│   ├── Controllers/        # Handles API request logic and prepares responses
│   │   └── ApiController.php # Main controller for Saco Cheio TV API interactions
│   ├── Middlewares/        # Middleware for request processing
│   │   └── AuthMiddleware.php # Handles JWT authentication for protected routes
│   ├── Services/           # Business logic and external API interactions
│   │   └── SacocheioApiService.php # Manages communication with the official Saco Cheio TV API
│   └── Utils/              # Utility classes and helper functions
│       └── JwtUtil.php     # Helper for JWT token creation and validation
├── public/                 # Publicly accessible files (can contain assets, though minimal for an API)
├── tests/                  # Placeholder for unit and integration tests
├── .gitignore              # Specifies intentionally untracked files to ignore
├── .htaccess               # Apache configuration for URL rewriting and routing
├── .tool-versions          # ASDF version manager configuration for PHP
├── composer.json           # Composer dependencies and autoloading configuration
├── config.php              # Global application configuration settings
├── env.example.php         # Example environment variables file
└── index.php               # Main entry point for all API requests, handles routing dispatch
```

## ⚙️ Configuration

### Environment Variables
Configure these variables in your `.env.php` file (copied from `env.example.php`):

| Variable            | Description                                   | Default        | Required |
|---------------------|-----------------------------------------------|----------------|----------|
| `APP_ENV`             | The application environment.                  | `development`  | Yes      |
| `APP_DEBUG`           | Enable/disable debug mode.                    | `true`         | Yes      |
| `JWT_SECRET`          | Secret key for signing and verifying JWTs.    | -              | Yes      |
| `SACOCHEIO_API_KEY`   | API key for accessing the official Saco Cheio TV API. | -              | Yes      |
| `SACOCHEIO_API_BASE_URL` | Base URL of the official Saco Cheio TV API.  | -              | Yes      |

### Configuration Files
-   `config.php`: Contains general application configuration, such as API headers or other static settings.
-   `.htaccess`: Apache rewrite rules, essential for routing all requests through `index.php`.

## 🔧 Development

### Available Scripts
The `composer.json` file does not define explicit development scripts. Standard Composer commands apply:

| Command           | Description                                    |
|-------------------|------------------------------------------------|
| `composer install`  | Installs all project dependencies.             |
| `composer update`   | Updates all project dependencies to their latest allowed versions. |
| `composer dump-autoload` | Regenerates the autoloader. Useful after adding new classes. |

### Development Workflow
1.  Ensure prerequisites (PHP, Composer) are installed.
2.  Clone the repository and install dependencies.
3.  Configure `.env.php`.
4.  Set up your local web server (e.g., Apache) to point to the project directory and enable `mod_rewrite`.
5.  Access the API endpoints via your configured web server.

## 🧪 Testing

The `tests/` directory is present, indicating a provision for automated tests. While specific testing commands are not in `composer.json`, it's generally expected that PHPUnit is used for PHP projects.

```bash
# Assuming PHPUnit is installed globally or via composer require-dev
./vendor/bin/phpunit
```

## 🚀 Deployment

### Production Setup
For production deployment, ensure `APP_ENV` is set to `production` and `APP_DEBUG` is `false` in your `.env.php` file. Configure your web server (Apache/Nginx) to serve the application and handle routing according to the `.htaccess` file.

### Deployment Options
-   **Traditional Hosting**: Deploy to a PHP-enabled web server (e.g., Apache, Nginx) with `mod_rewrite` enabled.
-   **Cloud Hosting**: Can be deployed on various cloud platforms that support PHP applications, such as AWS EC2, Google App Engine, or DigitalOcean Droplets.

## 📚 API Reference

The API endpoints are handled by `FastRoute` and dispatched through `index.php` to the `App\Controllers\ApiController.php` and its associated services.

### Authentication
Endpoints requiring authentication expect a JSON Web Token (JWT) to be passed in the `Authorization` header as a Bearer token:

```
Authorization: Bearer [YOUR_JWT_TOKEN]
```

### Endpoints
Below are example endpoints inferred from the project's purpose of manipulating Saco Cheio TV content:

#### `POST /api/auth/login`
Authenticates a user and returns a JWT token.

**Request Body:**
```json
{
  "username": "your_username",
  "password": "your_password"
}
```

**Response:**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "expires_in": 3600
}
```

#### `GET /api/shows`
Retrieves a list of shows from the Saco Cheio TV.

**Authentication:** Required

**Response:**
```json
[
  {
    "id": "show-1",
    "title": "Show Title 1",
    "description": "Description of Show 1",
    "image_url": "https://example.com/show1.jpg"
  },
  // ... more shows
]
```

#### `GET /api/shows/{showId}/episodes`
Retrieves a list of episodes for a specific show.

**Authentication:** Required

**Parameters:**
-   `showId`: The unique identifier of the show.

**Response:**
```json
[
  {
    "id": "episode-1",
    "title": "Episode Title 1",
    "duration": "45:30",
    "release_date": "2023-01-15",
    "audio_url": "https://example.com/episode1.mp3"
  },
  // ... more episodes
]
```

#### `GET /api/episodes/{episodeId}`
Retrieves details for a specific episode.

**Authentication:** Required

**Parameters:**
-   `episodeId`: The unique identifier of the episode.

**Response:**
```json
{
  "id": "episode-1",
  "title": "Episode Title 1",
  "description": "Full description of Episode 1",
  "duration": "45:30",
  "release_date": "2023-01-15",
  "audio_url": "https://example.com/episode1.mp3",
  "show_id": "show-1"
}
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details. <!-- TODO: Create CONTRIBUTING.md -->

### Development Setup for Contributors
Ensure you have the prerequisites installed and follow the installation steps. When proposing changes, make sure to add/update tests where applicable.

## 📄 License

This project is licensed under the [MIT License](LICENSE) - see the LICENSE file for details.

## 🙏 Acknowledgments

-   [PHP-DI](http://php-di.org/) for robust dependency injection.
-   [FastRoute](https://github.com/nikic/FastRoute) for efficient routing.
-   [Laminas Diactoros](https://docs.laminas.dev/laminas-diactoros/) for PSR-7 HTTP message implementation.
-   [firebase/php-jwt](https://github.com/firebase/php-jwt) for seamless JWT handling.
-   [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) for easy environment variable management.

## 📞 Support & Contact

-   📧 Email: [contato.vitorcarmo@gmail.com]
-   🐛 Issues: [GitHub Issues](https://github.com/Vitor-Carmo/api-sacocheio-tv/issues)

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

Made with ❤️ by [Vitor Carmo](https://github.com/Vitor-Carmo)

</div>
