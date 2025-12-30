# DBBackup Manager

A modern, responsive web-based database backup management tool with multi-language support. Easily manage multiple database connections and create backups with a beautiful, user-friendly interface.

![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Semantic UI](https://img.shields.io/badge/UI-Semantic%20UI-orange)

## 🌟 Features

- **Multi-Database Support**: Manage multiple database connections from a single interface
- **Easy Installation**: Simple setup wizard for initial configuration
- **Secure Authentication**: Password-protected access without database dependency
- **Multi-Language Support**: Available in German, English, French, Italian, and Spanish
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **Modern UI**: Built with Semantic UI for a beautiful, intuitive interface
- **Secure Storage**: Configuration files are protected with proper file permissions
- **One-Click Backups**: Create database backups with a single click
- **Database Management**: Add, edit, and delete database configurations easily

## 📋 Requirements

- PHP 7.4 or higher
- MySQL/MariaDB server
- Web server (Apache/Nginx)
- Write permissions for the installation directory

## 🚀 Installation

1. **Download or clone the repository**
   ```bash
   git clone https://github.com/yourusername/dbbackup-manager.git
   cd dbbackup-manager
   ```

2. **Upload files to your web server**
   - Upload all files to your web server directory (e.g., `public_html`, `www`, or `htdocs`)

3. **Set proper permissions**
   ```bash
   chmod 755 db_backup
   chmod 700 config backups
   ```

4. **Access the installation**
   - Navigate to `http://yourdomain.com/db_backup/install.php` in your browser
   - Follow the installation wizard to configure:
     - Your first database connection
     - Admin username and password

5. **Complete!**
   - After installation, you'll be redirected to the login page
   - Log in with your admin credentials to access the dashboard

## 📖 Usage

### Adding a Database

1. Click the "Add New Database" button in the dashboard
2. Fill in the database connection details:
   - Database Host (usually `localhost`)
   - Database Username
   - Database Password
   - Database Name
   - Display Name (optional, for easier identification)
3. Click "Add" to save

### Creating a Backup

1. Find the database you want to backup in the list
2. Click the "Backup" button
3. The backup file will be downloaded automatically as a `.sql` file

### Editing a Database

1. Click the "Edit" button next to the database
2. Modify the connection details as needed
3. Leave the password field empty to keep the current password
4. Click "Save" to update

### Deleting a Database

1. Click the "Delete" button next to the database
2. Confirm the deletion in the popup dialog

## 🌍 Supported Languages

- 🇩🇪 German (Deutsch)
- 🇬🇧 English
- 🇫🇷 French (Français)
- 🇮🇹 Italian (Italiano)
- 🇪🇸 Spanish (Español)

The language is automatically detected from your browser settings, or you can manually select it from the language selector in the top-right corner.

## 📁 Project Structure

```
db_backup/
├── includes/              # PHP logic files
│   ├── auth.php          # Authentication functions
│   ├── config.php        # Database configuration management
│   ├── lang.php          # Language management system
│   ├── language_selector.php  # Language selector component
│   └── styles.css        # Custom styles
├── lang/                 # Language files
│   ├── de.php           # German translations
│   ├── en.php           # English translations
│   ├── fr.php           # French translations
│   ├── it.php           # Italian translations
│   └── es.php           # Spanish translations
├── config/               # Configuration files (auto-created)
│   ├── auth.php         # Admin credentials
│   └── databases.php    # Database configurations
├── backups/              # Backup files directory (auto-created)
├── index.php             # Main entry point
├── install.php           # Installation page
├── login.php             # Login page
├── dashboard.php         # Main dashboard
├── db_action.php         # Database actions handler
├── backup.php            # Backup creation
├── language.php          # Language switcher
├── logout.php            # Logout handler
└── .htaccess             # Security rules
```

## 🔒 Security Features

- **Protected Directories**: Config and backup directories are protected via `.htaccess`
- **Secure Password Storage**: Admin passwords are hashed using PHP's `password_hash()`
- **Session-Based Authentication**: Secure session management
- **File Permissions**: Configuration files are stored with restricted permissions (0600)
- **Input Validation**: All user inputs are validated and sanitized
- **SQL Injection Protection**: Prepared statements and proper escaping

## 🛠️ Technologies Used

- **PHP 7.4+**: Server-side scripting
- **Semantic UI 2.5**: Modern UI framework
- **jQuery**: JavaScript library
- **MySQL/MariaDB**: Database support

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📧 Support

If you encounter any issues or have questions, please open an issue on GitHub.

## 🙏 Acknowledgments

- Semantic UI for the beautiful UI components
- All contributors and users of this project

---

**Made with ❤️ for easy database management**

