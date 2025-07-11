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



## **Task-2: What I Have Done Here......**  

- **Factory Setup:** Created Laravel Model Factories for:  
  - **departments** using `DepartmentFactory` to generate fake departments.  
  - **employees** using `EmployeeFactory` to generate fake employees with UUIDs.  
  - **employee_details** using `EmployeeDetailFactory` to generate fake employee details linked to employees.  

- **Model Relationships:**  
  - Each **employee** belongs to one **department** (`employees.department_id` → `departments.id`).  
  - Each **employee_detail** belongs to one **employee** (`employee_details.employee_id` → `employees.id`).  

- **Seeder Logic:** Created a `DatabaseSeeder` to:  
  - Insert **10 fake departments** into the `departments` table.  
  - Insert **100,000 fake employees** into the `employees` table.  
  - Automatically create **employee details** for each employee.  

- **Bulk Data Insertion:** Used `php artisan migrate:fresh --seed` to:  
  - Drop existing tables.  
  - Migrate fresh tables.  
  - Seed bulk fake data efficiently.  

- **Verification:** Confirmed that **100,000+ employees** and **10 department** tables were successfully created.

- **Best Practices:** Followed Laravel conventions for factories, seeders, and model relationships to ensure clean, maintainable and scalable bulk data insertion.
Automatically generate employee details for each employee.


<img width="1353" height="670" alt="1" src="https://github.com/user-attachments/assets/edebafab-aff1-40f4-bbef-dc166445363d" />

<img width="1354" height="684" alt="2" src="https://github.com/user-attachments/assets/9e493e9c-4a10-462e-9d4c-d83782373a3b" />

<img width="1357" height="680" alt="3" src="https://github.com/user-attachments/assets/0ad18cb1-2ca2-44f8-b781-c5ce0d5c7999" />

