# DBBackup Manager

Ein modernes, responsives webbasiertes Datenbank-Backup-Verwaltungstool mit mehrsprachiger Unterstützung. Verwalten Sie mühelos mehrere Datenbankverbindungen und erstellen Sie Backups mit einer benutzerfreundlichen Oberfläche.

![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)
![Lizenz](https://img.shields.io/badge/Lizenz-MIT-green)
![Semantic UI](https://img.shields.io/badge/UI-Semantic%20UI-orange)

## 🌟 Funktionen

- **Multi-Datenbank-Unterstützung**: Verwalten Sie mehrere Datenbankverbindungen über eine einzige Oberfläche
- **Einfache Installation**: Einfacher Setup-Assistent für die Erstkonfiguration
- **Sichere Authentifizierung**: Passwortgeschützter Zugang ohne Datenbankabhängigkeit
- **Mehrsprachige Unterstützung**: Verfügbar in Deutsch, Englisch, Französisch, Italienisch und Spanisch
- **Responsives Design**: Funktioniert perfekt auf Desktop, Tablet und Mobilgeräten
- **Moderne Benutzeroberfläche**: Erstellt mit Semantic UI für eine schöne, intuitive Oberfläche
- **Sichere Speicherung**: Konfigurationsdateien sind mit entsprechenden Dateiberechtigungen geschützt
- **Ein-Klick-Backups**: Erstellen Sie Datenbank-Backups mit einem einzigen Klick
- **Datenbankverwaltung**: Datenbankkonfigurationen einfach hinzufügen, bearbeiten und löschen

## 📋 Anforderungen

- PHP 7.4 oder höher
- MySQL/MariaDB Server
- Webserver (Apache/Nginx)
- Schreibrechte für das Installationsverzeichnis

## 🚀 Installation

1. **Repository herunterladen oder klonen**
   ```bash
   git clone https://github.com/yourusername/dbbackup-manager.git
   cd dbbackup-manager
   ```

2. **Dateien auf Ihren Webserver hochladen**
   - Laden Sie alle Dateien in Ihr Webserver-Verzeichnis hoch (z.B. `public_html`, `www` oder `htdocs`)

3. **Berechtigungen setzen**
   ```bash
   chmod 755 db_backup
   chmod 700 config backups
   ```

4. **Installation aufrufen**
   - Navigieren Sie in Ihrem Browser zu `http://ihredomain.de/db_backup/install.php`
   - Folgen Sie dem Installationsassistenten, um zu konfigurieren:
     - Ihre erste Datenbankverbindung
     - Admin-Benutzername und Passwort

5. **Fertig!**
   - Nach der Installation werden Sie zur Login-Seite weitergeleitet
   - Melden Sie sich mit Ihren Admin-Zugangsdaten an, um auf das Dashboard zuzugreifen

## 📖 Verwendung

### Datenbank hinzufügen

1. Klicken Sie auf den Button "Neue Datenbank hinzufügen" im Dashboard
2. Füllen Sie die Datenbankverbindungsdetails aus:
   - Datenbank Host (meist `localhost`)
   - Datenbank Benutzername
   - Datenbank Passwort
   - Datenbank Name
   - Anzeigename (optional, zur einfacheren Identifikation)
3. Klicken Sie auf "Hinzufügen", um zu speichern

### Backup erstellen

1. Finden Sie die Datenbank, von der Sie ein Backup erstellen möchten, in der Liste
2. Klicken Sie auf den Button "Backup"
3. Die Backup-Datei wird automatisch als `.sql`-Datei heruntergeladen

### Datenbank bearbeiten

1. Klicken Sie auf den Button "Bearbeiten" neben der Datenbank
2. Ändern Sie die Verbindungsdetails nach Bedarf
3. Lassen Sie das Passwortfeld leer, um das aktuelle Passwort beizubehalten
4. Klicken Sie auf "Speichern", um zu aktualisieren

### Datenbank löschen

1. Klicken Sie auf den Button "Löschen" neben der Datenbank
2. Bestätigen Sie die Löschung im Popup-Dialog

## 🌍 Unterstützte Sprachen

- 🇩🇪 Deutsch
- 🇬🇧 Englisch
- 🇫🇷 Französisch
- 🇮🇹 Italienisch
- 🇪🇸 Spanisch

Die Sprache wird automatisch aus Ihren Browser-Einstellungen erkannt, oder Sie können sie manuell über die Sprachauswahl in der oberen rechten Ecke auswählen.

## 📁 Projektstruktur

```
db_backup/
├── includes/              # PHP-Logik-Dateien
│   ├── auth.php          # Authentifizierungs-Funktionen
│   ├── config.php        # Datenbank-Konfigurations-Verwaltung
│   ├── lang.php          # Sprachverwaltungssystem
│   ├── language_selector.php  # Sprachauswahl-Komponente
│   └── styles.css        # Benutzerdefinierte Styles
├── lang/                 # Sprachdateien
│   ├── de.php           # Deutsche Übersetzungen
│   ├── en.php           # Englische Übersetzungen
│   ├── fr.php           # Französische Übersetzungen
│   ├── it.php           # Italienische Übersetzungen
│   └── es.php           # Spanische Übersetzungen
├── config/               # Konfigurationsdateien (automatisch erstellt)
│   ├── auth.php         # Admin-Zugangsdaten
│   └── databases.php    # Datenbank-Konfigurationen
├── backups/              # Backup-Dateien-Verzeichnis (automatisch erstellt)
├── index.php             # Haupt-Einstiegspunkt
├── install.php           # Installationsseite
├── login.php             # Login-Seite
├── dashboard.php         # Haupt-Dashboard
├── db_action.php         # Datenbank-Aktionen Handler
├── backup.php            # Backup-Erstellung
├── language.php          # Sprachumschalter
├── logout.php            # Logout Handler
└── .htaccess             # Sicherheitsregeln
```

## 🔒 Sicherheitsfunktionen

- **Geschützte Verzeichnisse**: Config- und Backup-Verzeichnisse sind über `.htaccess` geschützt
- **Sichere Passwort-Speicherung**: Admin-Passwörter werden mit PHP's `password_hash()` gehasht
- **Session-basierte Authentifizierung**: Sichere Session-Verwaltung
- **Dateiberechtigungen**: Konfigurationsdateien werden mit eingeschränkten Berechtigungen (0600) gespeichert
- **Eingabevalidierung**: Alle Benutzereingaben werden validiert und bereinigt
- **SQL-Injection-Schutz**: Prepared Statements und ordnungsgemäße Escapierung

## 🛠️ Verwendete Technologien

- **PHP 7.4+**: Serverseitige Skriptsprache
- **Semantic UI 2.5**: Modernes UI-Framework
- **jQuery**: JavaScript-Bibliothek
- **MySQL/MariaDB**: Datenbank-Unterstützung

## 📝 Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert - siehe LICENSE-Datei für Details.

## 🤝 Beitragen

Beiträge sind willkommen! Bitte zögern Sie nicht, einen Pull Request einzureichen.

1. Forken Sie das Repository
2. Erstellen Sie Ihren Feature-Branch (`git checkout -b feature/AmazingFeature`)
3. Committen Sie Ihre Änderungen (`git commit -m 'Add some AmazingFeature'`)
4. Pushen Sie zum Branch (`git push origin feature/AmazingFeature`)
5. Öffnen Sie einen Pull Request

## 📧 Support

Wenn Sie auf Probleme stoßen oder Fragen haben, öffnen Sie bitte ein Issue auf GitHub.

## 🙏 Danksagungen

- Semantic UI für die schönen UI-Komponenten
- Allen Mitwirkenden und Nutzern dieses Projekts

---

**Mit ❤️ erstellt für einfache Datenbankverwaltung**

