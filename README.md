# Real Estate Agency System

A simple real estate management system developed using HTML, CSS, JavaScript, and PHP with a MySQL database. This project allows users to manage property listings with secure login, role-based access, and CRUD operations. The system is designed to be functional and accessible on both desktop and mobile devices.

## Project Overview

The Real Estate Agency System includes a variety of functionalities designed for real estate management, allowing agents and admins to manage property listings efficiently. The system features a structured database with 11 tables, each supporting different property and user information.

## Features

- **Database Structure**: 
  - 11 tables with various data types.
  - CRUD operations on all entities with dedicated admin panel controls.
  - SQL filters for searching and sorting property listings.
  
- **User Roles and Authentication**:
  - Role-based access control for admins and agents.
  - Secure login system with encrypted passwords.
  - User sessions for managing login state.

- **PHP Functions**:
  - 15 core PHP functions used, including `session_start()`, `isset()`, `password_hash()`, and more.
  - Built-in validation to ensure data integrity and security.

- **JavaScript and Client-Side Functionality**:
  - Interactive elements for filtering and managing listings.
  - Session handling and data validation on the client side.
  
## Technologies Used

- **HTML & CSS**: For structuring and styling the frontend.
- **JavaScript**: Client-side scripting for interactivity.
- **PHP**: Server-side scripting and backend logic.
- **MySQL**: Database to store property listings and user data.
- **Sessions & Encryption**: Utilizes PHP sessions and password hashing for secure authentication.

## Project Structure

- **/admin**: Admin dashboard with access to all CRUD functionalities.
- **/user**: User dashboard for managing personal listings.
- **/database**: Database schema with predefined SQL scripts for table creation.
- **/functions**: Contains core PHP functions and utilities for session management, CRUD operations, and data validation.

## Security Considerations

- No sensitive login or server data stored in the repository.
- Password encryption using `password_hash()` and validation with `password_verify()`.
- Proper session handling to maintain secure login sessions.

## License

This project is licensed under the MIT License.

