<div align="center">

# 🌸 ÉCLORIA

### E-Commerce-Plattform für Kosmetik

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

</div>

---

## 📌 Über das Projekt

**ÉCLORIA** ist eine moderne und vollständige E-Commerce-Plattform für Kosmetik, entwickelt mit **Laravel 12** und **MySQL**. Sie bietet ein nahtloses Einkaufserlebnis für Kunden und ein fortschrittliches Verwaltungssystem für Administratoren.

Das Projekt wurde als professionelle Full-Stack-Webanwendung konzipiert und folgt den Best Practices der modernen Softwareentwicklung (MVC-Architektur, Service Layer, Datenbanktransaktionen).

---

## ✨ Funktionen

### 👤 Kundenbereich
- 🔐 Vollständige Authentifizierung (Registrierung / Anmeldung / Abmeldung)
- 🛍️ Produktkatalog mit erweiterten Filtern (Kategorie, Marke, Suche, Sortierung)
- 🛒 Warenkorb und Favoritenliste
- 💳 Vollständiger Checkout (Lieferung nach Hause / Abholung im Geschäft)
- 💰 Zahlung bei Lieferung oder im Geschäft
- 📦 Bestellhistorie und Echtzeit-Verfolgung
- ↩️ Rücksendeanfragen (teilweise / vollständig)
- ⭐ Kundenbewertungen (nur nach Lieferung)
- 💬 Beschwerden
- 👤 Profil- und Adressverwaltung
- 🔍 **Live-Suche** (instant search)
- 🌍 Mehrsprachig (Französisch, Englisch, Deutsch)

### 🛠️ Admin-Bereich
- 📊 Dashboard mit Echtzeit-Statistiken
- 📦 Produkt-CRUD (mit Bild-Upload)
- 🏷️ Kategorie- und Marken-CRUD
- 📋 Bestellverwaltung (Status, Zahlungen)
- 👥 Kunden- und Mitarbeiterverwaltung (mit individuellen Berechtigungen)
- 🎁 Aktions-CRUD (Prozentsatz oder Festbetrag)
- ↩️ Rücksendeverwaltung (Genehmigung, Empfang, Rückerstattung)
- 🚚 Lieferanten- und Einkaufsverwaltung
- 📦 Lagerverwaltung mit **FEFO** (First Expired, First Out)
- 🧾 Chargenverfolgung und Ablaufdaten
- 💬 Beschwerdeverwaltung

---

## 🏗️ Technische Architektur

---

## 🛠️ Tech-Stack

| Technologie | Version | Rolle |
|-------------|---------|-------|
| **Laravel** | 12.x | Backend-Framework |
| **PHP** | 8.2 | Backend-Sprache |
| **MySQL** | 8.0 | Datenbank |
| **Blade** | - | Template-Engine |
| **Bootstrap** | 5.3 | CSS-Framework |
| **Vite** | 7.x | Build-Tool |
| **Eloquent ORM** | - | ORM |

---

## ⚙️ Installation

### Voraussetzungen

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18
- NPM

### Schritte

```bash
# 1. Repository klonen
git clone https://github.com/lobnaelamrany/ecloria-site.git
cd ecloria-site

# 2. PHP-Abhängigkeiten installieren
composer install

# 3. JS-Abhängigkeiten installieren
npm install

# 4. .env-Datei kopieren
cp .env.example .env

# 5. Anwendungsschlüssel generieren
php artisan key:generate

# 6. Datenbank in .env konfigurieren
# DB_DATABASE=ecloria
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Migrationen und Seeder ausführen
php artisan migrate:fresh --seed

# 8. Storage-Link erstellen
php artisan storage:link

# 9. Server starten
php artisan serve
npm run dev
🔑 Testkonten
Rolle	E-Mail	Passwort
👑 Admin	admin@ecloria.ma	password
👔 Mitarbeiter	employe1@ecloria.ma	password
👤 Kunde	sara@test.ma	password
🧪 Tests
bash
php artisan test
📄 Lizenz
Dieses Projekt ist unter der MIT-Lizenz lizenziert – siehe LICENSE für Details.

👨‍💻 Autor
Lobna El Amrany

GitHub: @lobnaelamrany

E-Mail: lobnaelamrany4@gmail.com

<div align="center">
⭐ Wenn Ihnen dieses Projekt gefällt, geben Sie ihm bitte einen Stern! ⭐

Mit ❤️ entwickelt von Lobna El Amrany

</div> ```

