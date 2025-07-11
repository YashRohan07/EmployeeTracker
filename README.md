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



Task-2: What I Have Done Here......
Factory Setup: Created Laravel Model Factories for:

DepartmentFactory — generates fake departments.

EmployeeFactory — generates fake employees with UUIDs.

EmployeeDetailFactory — generates fake employee details linked to employees.

Model Relationships:

Employee belongs to Department and has one EmployeeDetail.

Department has many Employees.

EmployeeDetail belongs to Employee.

Seeder Logic: Wrote a DatabaseSeeder to:

Insert 10 departments into the departments table.

Insert 100,000 fake employees into the employees table.

Automatically generate employee details for each employee.

Mass Data Seeding: Used php artisan migrate:fresh --seed to drop old tables, run migrations again, and insert the new fake bulk data.

Verification: Confirmed 100,000+ employee records were created in the employees table along with corresponding rows in employee_details and departments.

Best Practices: Followed Laravel’s conventions for Factories, Seeders, and Relationships, ensuring clean, maintainable code for large-scale data insertion.
