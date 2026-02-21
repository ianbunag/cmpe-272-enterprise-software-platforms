# CMPE-272 Enterprise Software Platforms

A containerized enterprise software platform for CMPE-272 coursework, featuring Docker, PHP, MySQL, Nginx, and automated CI/CD deployment.

## Quick Links

- **Setup:** See [SETUP.md](SETUP.md) for deployment and environment setup instructions
- **Contributing:** See [CONTRIBUTING.md](CONTRIBUTING.md) for coding guidelines and contribution workflow
- **Architecture:** See [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) for project structure, routing, and coding patterns

## Overview

This repository contains coursework demonstrations for enterprise software platforms, including:
- Dynamic routing examples
- Lab activity submissions
- Database migrations with Phinx
- Docker-based containerization for both development and production
- Automated CI/CD with GitHub Actions

## Quick Start (Development)

```bash
# Clone and enter the repo
git clone <your-repo-url>
cd cmpe-272-enterprise-software-platforms

# Start development environment
docker compose up -d

# Access the application
open http://localhost
```

For full setup details, see [SETUP.md](SETUP.md).

## Key Technologies

- **PHP 8** - Application logic
- **MySQL 8** - Database
- **Nginx** - Web server with dynamic routing
- **Phinx** - Database migrations
- **Pico.css** - Responsive semantic CSS framework
- **Docker** - Containerization
- **GitHub Actions** - CI/CD automation
