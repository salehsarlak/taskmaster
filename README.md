# TaskMaster — Personal Task Management System

<div align="center">

**A clean, modern PHP & MySQL task manager with authentication, filters, search, and profile settings.**

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**🔗 Live Demo (Landing Page):** [taskmaster-tarhfam.vercel.app](https://taskmaster-tarhfam.vercel.app)

</div>

---

## Overview

**TaskMaster** is a full-stack web application built as a portfolio / practice project.  
It allows users to register, log in, create and manage personal tasks, filter them by status or due date, search tasks, and update their profile (username, password, and profile picture).

This project demonstrates core web development skills:

- Server-side rendering with **PHP**
- Relational database design with **MySQL**
- Session-based authentication
- Form validation & sanitization
- Prepared statements (SQL injection protection)
- File uploads (profile pictures)
- Responsive CSS design
- AJAX-style status updates (vanilla JS + fetch)

---

## Features

| Feature | Description |
|---------|-------------|
| **User Authentication** | Register / Login / Logout with session management |
| **Profile Picture** | Upload custom avatar on registration & settings |
| **Task CRUD** | Create, view, mark complete/pending, delete tasks |
| **Smart Filters** | All · Today · Upcoming · Completed |
| **Search** | Real-time search across task title & description |
| **Due Dates** | Assign and filter tasks by due date |
| **Settings** | Change username, password, and profile picture |
| **Clean UI** | Modern, responsive design with custom CSS |

---

## Tech Stack

- **Backend:** PHP 7.4+ (procedural + prepared statements)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3 (custom), Vanilla JavaScript
- **Server:** Apache (XAMPP / WAMP / LAMP) or any PHP-compatible host

---

## Project Structure

```
task-manager/
├── assets/
│   ├── logo.png
│   ├── pfp.png          # Default profile picture
│   ├── Oval.png
│   ├── set.svg
│   └── uploads/         # User-uploaded profile pictures
├── add.php              # Create new task
├── dashboard.php        # Main task list + filters + search
├── db.php               # Database connection
├── delete-task.php      # Delete task endpoint
├── login.php            # Sign-in page
├── logout.php           # Session destroy
├── register.php         # Sign-up page
├── settings.php         # Profile & account settings
├── update_task.php      # Toggle task status (AJAX)
├── style.css            # Main stylesheet
├── reset.css            # CSS reset
├── database.sql         # Database schema
└── README.md
```

---

## Installation & Setup

### 1. Prerequisites

- PHP 7.4 or higher
- MySQL 5.7+ / MariaDB
- Apache (or Nginx + PHP-FPM)
- Recommended: [XAMPP](https://www.apachefriends.org/) (Windows/macOS/Linux)

### 2. Clone the repository

```bash
git clone https://github.com/salehsarlak/taskmaster.git
cd taskmaster
```

### 3. Database setup

1. Start MySQL and open **phpMyAdmin** (or use CLI).
2. Import the schema:

```bash
mysql -u root -p < database.sql
```

Or manually run the SQL inside `database.sql`.

### 4. Configure database connection

Edit `db.php`:

```php
$servername = "localhost";
$username   = "root";       // your MySQL username
$password   = "";           // your MySQL password
$dbname     = "todo_manager";
```

### 5. Set permissions for uploads

```bash
chmod -R 755 assets/uploads
```

### 6. Run the application

Place the project in your web root (`htdocs` for XAMPP) and open:

```
http://localhost/taskmaster/login.php
```

---

## Database Schema

### `users`

| Column     | Type         | Description              |
|------------|--------------|--------------------------|
| id         | INT (PK)     | Auto-increment           |
| pfp        | VARCHAR(255) | Profile picture filename |
| username   | VARCHAR(100) | Unique username          |
| password   | VARCHAR(255) | Plain password (demo)    |
| created_at | TIMESTAMP    | Account creation time    |

### `tasks`

| Column      | Type                  | Description                |
|-------------|-----------------------|----------------------------|
| id          | INT (PK)              | Auto-increment             |
| user_id     | INT (FK → users.id)   | Owner of the task          |
| title       | VARCHAR(255)          | Task title                 |
| description | TEXT                  | Optional description       |
| status      | ENUM('pending','completed') | Current status        |
| due_date    | DATE                  | Optional due date          |
| created_at  | TIMESTAMP             | Creation time              |

---

## Screenshots

| Dashboard | Add Task | Settings / Profile |
|-----------|----------|--------------------|
| ![Dashboard](https://ciijvrewzjphofmecpnj.supabase.co/storage/v1/object/public/IMAGES/screencapture-localhost-todo-mannager-dashboard-php-2026-09-06-09_46_39.png) | ![Add Task](https://ciijvrewzjphofmecpnj.supabase.co/storage/v1/object/public/IMAGES/screencapture-localhost-todo-mannager-add-php-2026-09-06-09_46_48.png) | ![Settings](https://ciijvrewzjphofmecpnj.supabase.co/storage/v1/object/public/IMAGES/screencapture-localhost-todo-mannager-settings-php-2026-09-06-09_41_59.png) |

*Clean modern UI with sidebar navigation, task filters (All / Today / Upcoming / Completed), search, and profile management.*

---

## Live Demo

A beautiful landing page showcasing the project is available at:

**https://taskmaster-tarhfam.vercel.app**

---

## Security Notes

This is a **learning / portfolio project**. For production use you should:

- Hash passwords with `password_hash()` / `password_verify()`
- Add CSRF tokens to forms
- Restrict file upload types & sizes more strictly
- Move sensitive config to environment variables
- Enable HTTPS

---

## Future Improvements

- [ ] Password hashing (bcrypt / Argon2)
- [ ] Email verification
- [ ] Task categories / tags
- [ ] Drag-and-drop reordering
- [ ] Dark mode
- [ ] REST API version
- [ ] Docker setup

---

## Author

**Saleh Sarlak**  
Web Designer & WordPress Developer · Founder of [Tarhfam](https://tarhfam.ir)

- GitHub: [@salehsarlak](https://github.com/salehsarlak)
- Email: sarlaksaleh7@gmail.com

---

## License

This project is open source and available under the [MIT License](LICENSE).

---

<div align="center">
  Made with ❤️ as a practice portfolio project
</div>
