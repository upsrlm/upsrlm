# BCSakhi Production Server Migration

This repository contains the production-ready codebase for the BCSakhi project, migrated and prepared for deployment.

## Project Overview
BCSakhi is a comprehensive platform for managing and supporting the BC Sakhi initiative. It includes modules for user management, reporting, call center integration, training, and more, built using the Yii2 PHP framework.

## Key Features
- Modular Yii2 application structure (api, backend, frontend, call center, etc.)
- Environment-specific configuration for local and production deployments
- Automated migration and deployment scripts
- Android integration for mobile support
- Docker and Vagrant support for development and deployment

## Getting Started
1. **Clone the repository:**
   ```sh
   git clone -b server-migration https://github.com/upsrlm/bcsakhi-production.git
   ```
2. **Install dependencies:**
   - PHP dependencies: `composer install`
   - Node/JS dependencies (if any): `npm install` (in relevant directories)
3. **Set up environment files:**
   - Copy `.env.local` or `.env.production` as needed and update values
4. **Run migrations:**
   - Use Yii2 migration commands or provided scripts
5. **Start the server:**
   - For PHP: `php yii serve` or configure Apache/Nginx
   - For Docker: `docker-compose up`

## Folder Structure
- `upsrlm/` - Main Yii2 application (api, backend, frontend, modules, etc.)
- `android-integration/` - Android client and integration code
- `vendor/` - Composer dependencies
- `certs/` - Certificates for secure connections

## Deployment
- Use the `server-migration` branch for production deployments
- See `Migration_Guide.md` for detailed migration and rollback steps

## Contributing
Please open issues or pull requests for improvements or bug fixes.

## License
This project is licensed under the MIT License. See `LICENSE.md` for details.
