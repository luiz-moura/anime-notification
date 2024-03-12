# AnimeSchedule
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

The system imports the animes, genres, images, etc. from the current season via an API and persists in the database, the user can register and choose which animes they want to be notified when new episodes are broadcast by push notification.

The DDD architecture was implemented based on the article written by Brent on October 17, 2019 - [Domain-oriented Laravel](https://stitcher.io/blog/laravel-beyond-crud-01-domain-oriented-laravel) . The following patterns were also used: repository pattern, actions and use cases, data transfer objects.

## Technologies

- [Laravel](https://laravel.com/)
- [Laravel Sail](https://laravel.com/docs/9.x/sail#main-content)
- [Inertia](https://inertiajs.com/)
- [Firebase PHP](https://firebase-php.readthedocs.io/en/latest/)
- [Sentry](https://sentry.io/)

## Installation

1. Clone the project
```bash
  git clone https://github.com/luiz-moura/anime-schedule.git
```

2. Create .env
```bash
  cp .env.example .env
```

3. Install composer dependencies
```bash
  composer install
```

4. Create aliases for sail bash path
```bash
  alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

5. Start the server in background
```bash
  sail up -d
```

6. Install NPM dependencies
```bash
  sail npm install && sail npm run dev
```

Project listen in port http://localhost:80

## :elephant: Database

Create tables
```bash
  php artisan migrate:fresh
```

## Application structure

```
src
  └ Application
    ├── Providers
  └ Domains
    ├── Domain
    │   └── Actions
    │   └── UseCases
    │   └── DTOs
    │   └── Contracts
    │   └── Enums
    │   └── Exceptions
  └ Infrastructure
    │   └── Persistence
    │   └── Storage
    │   └── Integration
  └ Interfaces
    │   └── Console
    │   └── Http
```

## Sail commands

Start queue
```bash
  sail queue:work
```

Stop the server
```bash
  sail stop
```

All commands sail
```bash
  sail help
```

## :white_check_mark: Run tests
```bash
  sail test
```

## Commands

Run commands with sail 
```bash
  sail artisan command:name
```

| Command | Description |
| --- | --- |
| ```app:import-animes``` | Search animes airing from the api and register them in the database |
| ```app:notify-members``` | Notifies members that the anime will be broadcast |

### 🔗 Links

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/luiz-moura/)
