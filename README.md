## Task-1: What I Have Done Here......

- **Laravel Project Setup:** Created a new Laravel project named `EmployeeTracker` using Laravel Installer.
- **Database Configuration:** Configured the project to use MySQL with a database named `employeetracker`.
- **Database Migrations:** Created and ran Laravel migrations for the following tables:
  - `departments` (with id, name, description, timestamps and deletes)
  - `employees` (with UUID id, name, email, foreign key to departments, timestamps and deletes)
  - `employee_details` (with id, foreign key to employees, designation, salary, address, joined_date, timestamps)
- **Relationships:**
  - Each **employee** belongs to one **department** (`employees.department_id` → `departments.id`).
  - Each **employee_detail** belongs to one **employee** (`employee_details.employee_id` → `employees.id`).
- **Foreign Key Constraints:** Ensured proper migration order to avoid foreign key errors, creating tables in the correct sequence.
- **Successful Migration:** All tables have been successfully migrated to the MySQL database.

<img width="988" height="573" alt="Capture" src="https://github.com/user-attachments/assets/4dd29b5c-8fe8-4d7a-bbd7-764dba235358" />


  
