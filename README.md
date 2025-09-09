# Docker PHP Sample

A sample PHP application with Docker, following modern PHP project structure conventions.

## Project Structure

```
.
├── public/           # Web root directory
│   ├── index.php    # Application entry point with routing
│   └── .htaccess    # Apache rewrite rules
├── src/             # Application source code
│   ├── Controllers/ # HTTP request handlers
│   ├── Services/    # Business logic services
│   ├── Models/      # Data models (if needed)
│   └── Config/      # Configuration classes
├── storage/         # Application storage
│   ├── uploads/     # File uploads
│   └── logs/        # Application logs
├── tests/           # PHPUnit tests
├── vendor/          # Composer dependencies
├── composer.json    # PHP dependencies and scripts
├── phpunit.xml      # PHPUnit configuration
└── docker files...  # Docker configuration
```

## Architecture

- **Public Directory**: `public/` contains the web-accessible files. All HTTP requests are routed through `public/index.php`.
- **Source Code**: `src/` contains all business logic organized in a clean structure.
- **Storage**: `storage/` is for file uploads, logs, and other application storage needs.
- **Tests**: `tests/` contains PHPUnit test files with proper structure.

## Available Routes

- `/` - Home page with navigation
- `/hello` - Hello World endpoint
- `/database` - Database connection test

## Getting Started

### Using Docker (Recommended)

1. Clone the repository
2. Run with Docker Compose:
   ```bash
   docker compose up -d
   ```
3. Access the application at http://localhost:9000

### Development

For development with file watching:
```bash
docker compose watch
```

### Running Tests

Run PHPUnit tests:
```bash
docker compose exec server composer test
```

Run tests with coverage:
```bash
docker compose exec server composer test-coverage
```

## Database

The application connects to a MariaDB database. Connection details are configured via environment variables:

- `DB_HOST` - Database host (default: db)
- `DB_NAME` - Database name (default: example)  
- `DB_USER` - Database user (default: root)
- `PASSWORD_FILE_PATH` - Path to password file

## File Structure Details

### Controllers
Located in `src/Controllers/`, these handle HTTP requests and coordinate with services.

### Services
Located in `src/Services/`, these contain business logic and data operations.

### Configuration
Located in `src/Config/`, these handle application configuration like database connections.

### Storage
- `storage/uploads/` - For file uploads
- `storage/logs/` - For application logs

### Tests
PHPUnit tests are organized in the `tests/` directory with a bootstrap file for proper setup.

## Development Notes

- The application uses a simple routing system in `public/index.php`
- All business logic is separated from presentation logic
- Proper error handling and logging practices
- PSR-4 autoloading for clean class organization
- Docker multi-stage builds for production optimization