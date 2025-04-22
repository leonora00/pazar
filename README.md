---
## 🧰 Requirements

- PHP >= 7.4
- MySQL
- Web server (Apache recommended)
- Composer (optional, if using autoloading or dependencies)

---

## 🖥️ How to Run Locally

### 🪟 Windows (with XAMPP)
1. **Clone the repo** 
- git clone https://github.com/leonora00/pazar.git
2. **Move it to XAMPP's htdocs** 
- C:\xampp\htdocs\pazar
3. **Import the database**

- Open **phpMyAdmin** at `http://localhost/phpmyadmin`
- Create a new database (e.g., `pazar`)
- Import the `.sql` file (found in the project, e.g. `pazar.sql`)
4. **Update DB credentials(if needed)**

In your PHP files (likely `app/config/config.php` or similar)
5. **Start XAMPP**
6. Run the app
- Open your browser and go to `http://localhost/pazar`

Made with ❤️ by @leonora00
