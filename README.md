# Employee Management System (EMS)

A comprehensive Employee Management System (EMS) built with the Laravel framework, designed to streamline human resource operations and employee data management.

## Features

### User Authentication & Role Management
- **Secure Authentication**: Login and registration with email verification and password reset functionality.
- **Role-Based Access Control (RBAC)**: Distinct permissions for **Admin**, **HR**, and **Viewer** roles.
- **Profile Management**: Users can update their personal information and passwords.

### Employee Directory
- **Comprehensive Profiles**: Manage detailed employee data including personal info, designations, and joining details.
- **Status Tracking**: Track employee status (Active, Inactive, Terminated, Resigned).
- **Emergency Contacts**: Store emergency contact information for every employee.
- **UUID & Slug Support**: Automatic generation of unique identifiers and SEO-friendly slugs for employee profiles.

### Organizational Structure
- **Organization Management**: Define and manage multiple organizations with logos and image galleries.
- **Departmental Hierarchy**: Organize employees into departments.
- **Section Management**: Further categorize departments into specific sections.
- **Drag-and-Drop Sorting**: Reorder departments easily using a web interface.

### Attendance Tracking
- **Daily Attendance**: Record and monitor employee check-in and check-out times.
- **PDF Export**: Generate and download attendance reports in PDF format.

### Leave & Vacation Management
- **Multiple Leave Types**: Support for Casual, Emergency, Disability, and Leave Without Pay.
- **Flexible Leave Forms**: Dedicated forms for different leave requests.
- **Approval Workflow**: Streamlined process for HR and Admin to approve or reject leave requests.

### Salary Management
- **Salary Grades**: Define standardized salary structures.
- **Employer Salaries**: Manage individual employee salaries and track historical changes.
- **JSON API**: Endpoint for fetching salary grade details.

### Calendar & Events
- **Integrated Calendar**: View organizational events and holidays in a month-by-month grid.
- **Event Management**: Create, update, and delete events with custom colors and timings.

### Document & Photo Management
- **Document Storage**: Upload and manage official employee documents and contracts.
- **Photo Gallery**: Specialized management for employee and organizational photos.

### Technical Improvements
- **PSR-4 Compliant**: Standardized directory and namespace casing for better autoloading performance.
- **Form Request Validation**: Robust server-side validation using dedicated Request classes.
- **Responsive Dashboard**: Modern UI built with Tailwind CSS 4 and Vite.

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
