# University Lost & Found Management System

A PHP and MySQL-based web application for managing lost and found items within a university. Students can report lost or found items, search for approved items, and submit claims. Moderators can review reports and manage claims, while administrators can manage users, categories, and items.

## Features

### Student
- Register and login
- Remember Me functionality
- Report lost or found items
- Upload item images
- Search approved lost and found items
- Submit claims
- View personal claims
- Update profile
- Change password

### Moderator
- Moderator dashboard
- Review reported items
- Approve or reject item reports
- Update item status
- Manage claims
- View reported items

### Admin
- Admin dashboard
- Manage users
- Manage categories
- Add, edit, and delete items
- Update item status
- View all reported items
- Delete items

## Technologies

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- MySQLi
- XAMPP
- phpMyAdmin
- MVC Architecture

## Project Structure

```text
University-Lost-Found/
│
├── Controller/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── CategoryController.php
│   ├── ClaimController.php
│   ├── ItemController.php
│   ├── ModeratorController.php
│   ├── StudentController.php
│   └── script.js
│
├── Model/
│   ├── Category.php
│   ├── Claim.php
│   ├── Database.php
│   ├── Item.php
│   └── User.php
│
├── View/
│   ├── admin-categories.php
│   ├── admin-dashboard.php
│   ├── admin-manage-items.php
│   ├── admin-users.php
│   ├── footer.php
│   ├── forgot-password.php
│   ├── header.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── moderator-dashboard.php
│   ├── moderator-item-status.php
│   ├── moderator-manage-claims.php
│   ├── moderator-review-items.php
│   ├── register.php
│   ├── student-change-password.php
│   ├── student-claims.php
│   ├── student-dashboard.php
│   ├── student-profile.php
│   ├── student-report-item.php
│   ├── student-search-items.php
│   └── styles.css
│
├── database/
│   └── university_lost_found.sql
│
└── README.md
