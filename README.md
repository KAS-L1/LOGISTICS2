## **Overview**

**Logistic 2 HRMS** is a comprehensive solution that integrates multiple systems, including:

- **Procurement Management**  
- **Audit Management**  
- **Vendor Portal**  
- **Document Tracking System**  
- **Predictive Analytics**  

This project is built using modern web technologies and frameworks, ensuring scalability and maintainability.

---

## **Features**

1. **Hotel and Restaurant Management Systems (HRMS) Modules**:
   - Manage human resources seamlessly.

2. **Procurement Management**:
   - Streamline purchasing processes.

3. **Audit Management**:
   - Ensure compliance and detailed reporting.

4. **Vendor Portal**:
   - Simplify vendor communications and processes.

5. **Document Tracking System**:
   - Keep track of important files and workflows.

6. **Predictive Analytics**:
   - Gain actionable insights with advanced data analysis.

---

## **Tech Stack**

This application leverages the following tools and technologies:

- **Frontend Template**: [Able Pro Admin Template](https://codedthemes.com/item/able-pro-free-bootstrap-5-admin-template/)
- **Backend Framework**: Laravel
- **API Authentication**: Laravel Sanctum ([Documentation](https://laravel.com/docs/11.x/sanctum))
- **Role and Permission Management**: Laravel Spatie Permission ([Documentation](https://spatie.be/docs/laravel-permission/v6/installation-laravel))

---

## **Setup Instructions**

### **Prerequisites**
- PHP 8.x or higher
- Composer
- Node.js and npm
- MySQL or any supported database

### **Installation**
1. Clone the repository:
   ```bash
   git clone https://github.com/KAS-L1/FinalTemp.git
   cd FinalTemp
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Create a `.env` file:
   ```bash
   cp .env.example .env
   ```

4. Set your environment variables in `.env`.

5. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Build frontend assets:
   ```bash
   npm run dev
   ```

7. Start the server:
   ```bash
   php artisan serve
   ```

---

## **Usage**

### **Authentication**
The application uses **Laravel Sanctum** for API token authentication. 

### **Roles and Permissions**
- Managed using **Spatie Laravel Permission**.
- Define roles and permissions in the database or configuration.

---

## **Contributing**

Contributions are welcome! Please fork the repository and submit a pull request for any feature additions or bug fixes.

---

## **Author**

Kier Salise aka KAS-L

- Full Stack Developer

- Lead Programmer

---

## **License**

This project is open-source and licensed under the [MIT License](LICENSE).

---
