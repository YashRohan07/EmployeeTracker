## Task-1: What i have done here......

- **Laravel Project Setup:** Created a new Laravel project named `EmployeeTracker` using Laravel Installer.
- **Database Configuration:** Configured the project to use MySQL with a dedicated database named `employeetracker`.
- **Database Migrations:** Created and ran Laravel migrations for the following tables:
  - `departments` (with id, name, description, timestamps, and soft deletes)
  - `employees` (with UUID id, name, email, foreign key to departments, timestamps, and soft deletes)
  - `employee_details` (with id, foreign key to employees, designation, salary, address, joined_date, timestamps)
- **Foreign Key Constraints:** Ensured proper migration order to avoid foreign key errors, creating tables in the correct sequence.
- **Successful Migration:** All tables have been successfully migrated to the MySQL database.
- **Project Ready for Next Steps:** The project is now ready for bulk data insertion and API development.

