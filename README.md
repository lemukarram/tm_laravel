# Task Manager Web App

A simple Laravel-based web application to create, view, edit, delete, and filter tasks. Each task supports a title, description, file attachment, and status label (To Do, In Progress, Done) with color-coded badges.

---

## Features

- User-friendly CRUD interface for tasks  
- File attachment upload (JPG, PNG, PDF, DOCX)  
- Task statuses:  
  - To Do (yellow)  
  - In Progress (blue)  
  - Done (green)  
- Filter tasks by status with dynamic dropdown  
- Responsive layout using Bootstrap 5  
- Server-side file storage in `storage/app/public`  

---

## Requirements

- PHP 8.0 or higher  
- Composer  
- Laravel 10.x  
- MySQL or any supported database  
- Node.js & NPM (for asset compilation)  

---

## Installation

1. Clone the repository  
   ```bash
   git clone git@github.com:lemukarram/tm_laravel.git
   cd tm_laravel
   ```

2. Install PHP dependencies  
   ```bash
   composer install
   ```

3. Copy and configure environment  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   - Update `.env` with your database credentials.

4. Run migrations  
   ```bash
   php artisan migrate
   ```

5. Link storage (for attachments)  
   - If you have symlink support:  
     ```bash
     php artisan storage:link
     ```
   - On shared hosting without `symlink()`, see [Manual Storage Setup](#manual-storage-setup) below.

6. Install front-end dependencies and compile assets  
   ```bash
   npm install
   npm run dev
   ```

7. Start the local server  
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000` in your browser.

---

## Manual Storage Setup

If `php artisan storage:link` fails:

- **SSH method**  
  ```bash
  ln -s ../storage/app/public public/storage
  ```
- **Route fallback**  
  Add to `routes/web.php`:
  ```php
  Route::get('attachments/{path}', function($path){
    $file = storage_path("app/public/{$path}");
    abort_unless(file_exists($file), 404);
    return response()->file($file);
  })->where('path', '.*');
  ```
  Then link attachments in Blade as `/attachments/{{ $filename }}`.

---

## Database Schema

The `tasks` table migration defines:

| Column       | Type                                   |
|--------------|----------------------------------------|
| id           | unsigned big integer (PK)              |
| title        | string, required                       |
| description  | text, nullable                         |
| attachment   | string, nullable (file path)           |
| status       | enum: `todo`, `inprogress`, `done`     |
| created_at   | timestamp                              |
| updated_at   | timestamp                              |

---

## Routes & Controllers

| Verb     | URI             | Action            | Description                  |
|----------|-----------------|-------------------|------------------------------|
| GET      | `/tasks`        | `index`           | List & filter tasks          |
| GET      | `/tasks/create` | `create`          | Show “new task” form         |
| POST     | `/tasks`        | `store`           | Save new task                |
| GET      | `/tasks/{task}/edit` | `edit`      | Show “edit task” form        |
| PUT/PATCH| `/tasks/{task}` | `update`          | Update existing task         |
| DELETE   | `/tasks/{task}` | `destroy`         | Delete a task                |

---

## Views & Front-End

- **Layout** (`resources/views/layouts/app.blade.php`)  
  - Bootstrap 5 CDN, navbar, flash messages  
- **Index** (`tasks/index.blade.php`)  
  - Table of tasks, status-filter dropdown, color badges  
- **Create/Edit** (`tasks/create.blade.php`, `tasks/edit.blade.php`)  
  - Form fields for title, description, status, attachment  

All pages include jQuery for the status dropdown redirect script.

---

## Customization

- Modify badge colors in `layouts/app.blade.php` under the `.label-*` CSS classes.  
- Adjust validation rules in `TaskController` for file types or max upload size.  
- Extend status options by updating the migration, model, and views.

---

## Testing

_No automated tests included._ To manually verify:

1. Create a new task with and without attachments.  
2. Edit status and upload a new file.  
3. Delete tasks and confirm files are removed from `storage/app/public`.  
4. Filter tasks by status via the dropdown.

---

## Contributing

1. Fork this repo  
2. Create a feature branch (`git checkout -b feature/YourFeature`)  
3. Commit your changes (`git commit -m "Add YourFeature"`)  
4. Push to your branch (`git push origin feature/YourFeature`)  
5. Open a Pull Request

---

## License

This project is open-source and available under the [MIT License](LICENSE).  
Feel free to use, modify, and distribute it as you like!
