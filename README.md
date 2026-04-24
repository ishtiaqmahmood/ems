# Employee Management System (EMS)

A comprehensive Employee Management System (EMS) built with the Laravel framework, designed to streamline human resource operations and employee data management.

## Features

- **User Authentication & Role Management**: Secure login and registration with role-based access control (Admin, HR, Viewer).
- **Employee Directory**: Manage detailed employee profiles, including personal information, designations, and joining details.
- **Organizational Structure**: Define and manage Organizations, Departments, and Sections.
- **Attendance Tracking**: Record and monitor employee attendance with check-in/check-out functionality and PDF export.
- **Leave & Vacation Management**:
    - Support for multiple leave types: Casual Leave, Emergency Leave, Disability Leave, and Leave Without Pay.
    - Approval workflow for leave requests.
- **Salary Management**:
    - Define Salary Grades.
    - Manage individual Employer Salaries and history.
- **Calendar & Events**: Integrated calendar for managing organizational events and holidays.
- **Document & Photo Management**: Store and organize employee documents and official photos.
- **Responsive Dashboard**: User-friendly interface built with Tailwind CSS.

## Tech Stack

- **Backend**: PHP 8.2+, [Laravel 12](https://laravel.com)
- **Frontend**: [Tailwind CSS 4](https://tailwindcss.com), [Vite](https://vitejs.dev)
- **Database**: MySQL / SQLite
- **Tools**: [Composer](https://getcomposer.org), [NPM](https://www.npmjs.com)

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or any supported database

## Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. **Run the setup script**:
   This project includes a convenient setup command that handles dependency installation, environment configuration, key generation, and database migrations.
   ```bash
   composer run setup
   ```

3. **Alternative Manual Setup**:
   If you prefer to run steps manually:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   npm install
   npm run build
   ```

## Development

To start the development server with Vite:
```bash
composer run dev
```
This will concurrently run the Laravel development server, the queue listener, and Vite for asset bundling.

## Testing

Run the test suite using:
```bash
composer run test
```

## License

The EMS project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
