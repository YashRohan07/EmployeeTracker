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



## **Task-3: What I Have Done Here......**  

- **API Controller Implementation:**  
  - Created `EmployeeController` in `App\Http\Controllers\API` to handle **CRUD operations** for employees.  

- **API Resource Methods Implemented:**  
  - `index()` – Lists employees with **pagination**, including related **department** and **employee detail** data.  
  - `store()` – Validates and saves a **new employee** with its related **detail record**.  
  - `show($id)` – Fetches a **specific employee** with related data.  
  - `update($id)` – Validates and updates **employee** and related **detail data**.  
  - `destroy($id)` – Deletes an **employee**.  

- **Validation:**  
  - Used Laravel’s **Validator** to ensure inputs meet required constraints (**unique email**, **valid department**, **required fields**).  

- **Eloquent Relationships Used:**  
  - Leveraged Eloquent relationships (**Employee has department and detail**) to **eager load** related data efficiently.  

- **UUID Usage:**  
  - Auto generated **UUIDs** for employee IDs when creating new records.  

- **JSON Response:**  
  - Returned JSON responses with appropriate HTTP status codes for success and error scenarios.  

- **Tested API:**  
  - Tested API endpoints with samples and verified responses (including creating employees and retrieving them).
 

**List All Employees (GET)**

<img width="937" height="585" alt="1" src="https://github.com/user-attachments/assets/2a4452c0-6cb9-414b-b51a-a5289926dea3" />

<img width="666" height="566" alt="111" src="https://github.com/user-attachments/assets/3c19eca6-f747-4139-9967-33631c4b1578" />


**Create New Employee (POST)**

<img width="934" height="377" alt="4" src="https://github.com/user-attachments/assets/88c7f9b1-8dd9-4653-995a-dca887213fd3" />

<img width="934" height="557" alt="5" src="https://github.com/user-attachments/assets/8c7c5a83-92be-4270-822e-8195b981b565" />


**Get Single Employee by ID (GET)**

<img width="937" height="578" alt="6" src="https://github.com/user-attachments/assets/fddc70ea-3671-4d6c-89fa-5e51be3936f6" />

**Update Existing Employee (PUT/PATCH)**
<img width="929" height="587" alt="7" src="https://github.com/user-attachments/assets/f6a33950-b603-4b78-9b48-5c4fce893734" />

**Delete Employee (DELETE)**
<img width="937" height="242" alt="9" src="https://github.com/user-attachments/assets/50946b4b-bc5e-4d21-8043-f207b5a05adf" />

<img width="936" height="242" alt="10" src="https://github.com/user-attachments/assets/bf91f311-be48-4a41-b195-7be9c967e386" />


**Search by Name/Email**
<img width="937" height="551" alt="search" src="https://github.com/user-attachments/assets/17d59afe-f11b-4fcb-a0b1-2bf2bdfca303" />

**Filter by Department**
<img width="932" height="566" alt="dept" src="https://github.com/user-attachments/assets/2cbe51da-13fa-447f-a9cf-abd1fa32e23b" />

**Filter by Salary Range**
<img width="932" height="549" alt="salARRY" src="https://github.com/user-attachments/assets/5f2e82fb-9807-4ba8-8076-dc5c653e1be9" />

**Filter by Joining Date Range**
<img width="936" height="579" alt="joindate" src="https://github.com/user-attachments/assets/2629817c-9b7c-4da3-b3a9-5141c4bc9c25" />

**Sort by Joining Date**
<img width="930" height="620" alt="sort" src="https://github.com/user-attachments/assets/2d5a6e86-1319-4b92-b453-eaf8aafe4c5d" />


## **Task-4: What I Have Done Here......**  

<img width="1326" height="691" alt="5" src="https://github.com/user-attachments/assets/e2e2e54e-8b26-46e5-979d-3f7a2c6ab381" />

<img width="1320" height="659" alt="6" src="https://github.com/user-attachments/assets/784b5b05-69d8-4a25-b7f0-43e067e463b3" />

