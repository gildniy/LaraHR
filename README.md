# Lara HR
Laravel Technical Assignment

## Tasks
- [x] Full authentication system using Sanctum(Register, Login, Logout, Forgot password, Password reset)
- [x] Employee CRUD, with minimum fields(names,email,employeeIdentifier,phoneNumber) all we care about is the thing to work
- [x] Attendance management, record when an employee arrives at the office and when they leave
- [x] Send email (using queues) to the employee when an attendance record is made
- [x] Generate attendance report(pdf & excel) with daily attendance data
- [x] Add a clear and concise readme that explains all the needed steps to deploy and run test of the project in a local environment

## Description
This project implements several features including a full authentication system, Employee CRUD operations, Attendance management, Email notifications, and Attendance reporting.

### Features
- Full authentication system using Sanctum (Register, Login, Logout, Forgot password, Password reset)
- Employee CRUD operations with minimum fields (names, email, employeeIdentifier, phoneNumber)
- Attendance management to record when an employee arrives and leaves the office
- Email notifications sent to employees when an attendance record is made
- Generation of attendance reports in PDF and Excel formats with daily attendance data (The generation is made daily by cron job, but can be triggered manually by running the command `php artisan attendance:report` )

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/gildniy/LaraHR.git
    ```

2. Navigate to the project directory:
    ```bash
    cd project-directory
    ```

3. Install dependencies:
    ```bash
    composer install
    npm install
    ```

4. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

5. Generate an application key:
    ```bash
    php artisan key:generate
    ```

6. Configure the database connection in the `.env` file:
    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```

7. Migrate the database:
    ```bash
    php artisan migrate
    ```

8. Link storage directory:
    ```bash
    php artisan storage:link
    ```

9. Set up the mail configuration in the `.env` file for sending email notifications.

10. Start the development server:
    ```bash
    php artisan serve
    ```

## Running Tests

To run tests, execute the following command:

```bash
php artisan test
