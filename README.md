# PHP Web Application - MVC Architecture 🌐

This project is a PHP web application built using the **MVC (Model-View-Controller)** architecture. The interface is designed with **Bootstrap**, making it fully responsive across devices. It connects to a **MySQL database** to manage and display data related to users, instructors, students, courses, and grades.

---

## 🚀 Features

- **User Management**: Add and view user accounts.
- **Instructor and Student Management**: Maintain data about instructors and students.
- **Course Management**: Manage courses offered by the institution.
- **Grade Management**: Record and display student grades.
- **Responsive Design**: Built with Bootstrap for compatibility with desktops, tablets, and mobile devices.

---

## 🛠️ Technologies Used

- **PHP**: Backend programming language.
- **MySQL**: Database for storing and managing data.
- **Bootstrap**: For a responsive and modern user interface.
- **MVC Architecture**: To separate concerns and improve scalability.

---

## 📋 Prerequisites

Ensure you have the following installed on your system:

- PHP 7.4 or later
- MySQL Server
- Apache or any other web server
- Composer (optional, for dependency management)

---

## 🖥️ Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/TranKienCuong2003/AcademiaPro.git
   ```
2. **Set Up the Database**:

   - Create a MySQL database using the following command (you can do this through PHPMyAdmin or via command line):
     ```bash
     CREATE DATABASE studentmanagementdb;
     ```
   - After creating the database, make sure to import the SQL file (`database/db.sql`) into your `studentmanagementdb` using PHPMyAdmin or via the command line.

     If you're using PHPMyAdmin:

     - Go to PHPMyAdmin.
     - Select the `studentmanagementdb` database.
     - Click on the **Import** tab.
     - Select the `database/db.sql` file and import it.

3. **Configure the Application**:

   - Update your `.env` file in the root directory of the project with the following configuration:
     ```
     DB_HOST=localhost
     DB_PORT=3306
     DB_NAME=studentmanagementdb
     DB_USERNAME=root
     DB_PASSWORD=
     APP_ENV=development
     ```
     - Replace `DB_USERNAME` and `DB_PASSWORD` with your MySQL username and password (if any).
     - Make sure `DB_HOST` is set to `localhost` and the `DB_PORT` is set to `3306` (the default MySQL port).

4. **Run the Application**:
   - Make sure you have the necessary PHP extensions for connecting to MySQL (e.g., `mysqli` or `PDO`).
   - Start your web server (Apache or another) and navigate to the project directory.
   - Open your web browser and go to:
     ```
     http://localhost/AcademiaPro
     ```
     The application should now be up and running. You can start managing users, instructors, students, courses, and grades.

---

## 🗂️ Project Structure

- **Models**: Contains database interaction logic.
- **Views**: User interface components.
- **Controllers**: Handles business logic and requests.
- **Public**: The entry point for the application (index.php).
- **Config**: Configuration files, including database settings.
- **Database**: Contains SQL scripts for database setup (`db.sql`).

---

## 📝 License

This project is licensed under the [MIT License](LICENSE). Feel free to use and modify it.

---

## 💡 Contributions

Contributions are welcome! Feel free to fork the repository, create a feature branch, and submit a pull request.

---

## 🙌 Acknowledgements

Special thanks to the developers and resources that inspired this project:

- [Bootstrap](https://getbootstrap.com/)
- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)

---

## 📧 Contact

For any inquiries or suggestions, please contact:  
**Tran Kien Cuong**  
**Email**: trankiencuong30072003@gmail.com  
**GitHub**: [TranKienCuong2003](https://github.com/TranKienCuong2003)

---

### 🎉 Thank you for exploring this project!
