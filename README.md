
<div align="center">

# 🌸 ÉCLORIA

### E-Commerce-Plattform für Kosmetik

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

</div>

---

## 📌 Über das Projekt

**ÉCLORIA** ist eine moderne E-Commerce-Plattform für Kosmetikprodukte, entwickelt mit **Laravel 12** und **MySQL**.

Sie bietet ein komfortables Einkaufserlebnis für Kunden sowie ein umfassendes Verwaltungssystem für Administratoren.

Das Projekt wurde als Full-Stack-Webanwendung entwickelt und basiert auf der MVC-Architektur, einem Service Layer und Datenbanktransaktionen.

---

## 👩‍💻 Meine Rolle & Beitrag

Dies ist ein **Einzelprojekt (Solo-Projekt)**. Ich habe die gesamte Anwendung selbst konzipiert und entwickelt:

- **Konzeption & Architektur:** Entwurf der relationalen Datenbank mit 25 Tabellen und Definition der Geschäftslogik.
- **Backend-Entwicklung:** Implementierung von Authentifizierung, Checkout, Bestellverwaltung und FEFO-Lagerverwaltung.
- **Frontend-Entwicklung:** Gestaltung der Benutzeroberflächen mit Blade, Bootstrap und eigenem CSS-Design.
- **Qualitätssicherung:** Datenbanktransaktionen und automatisierte Tests.

---

## ✨ Funktionen

### 👤 Kundenbereich

- Registrierung und Anmeldung.
- Produktkatalog mit Filtern und Suche.
- Warenkorb und Favoritenliste.
- Checkout mit Lieferung oder Abholung.
- Zahlung bei Lieferung oder im Geschäft.
- Bestellhistorie und Statusverfolgung.
- Rücksendeanfragen und Kundenbewertungen.
- Beschwerden und Profilverwaltung.
- Live-Suche.
- Mehrsprachigkeit (FR / EN / DE).

### 🛠️ Admin-Bereich

- Dashboard mit Statistiken.
- Produkt-, Kategorie- und Markenverwaltung.
- Bestell- und Zahlungsverwaltung.
- Kunden- und Mitarbeiterverwaltung.
- Verwaltung von Aktionen und Rabatten.
- Rücksende- und Beschwerdeverwaltung.
- Lieferanten- und Einkaufsverwaltung.
- FEFO-Lagerverwaltung (First Expired, First Out).
- Chargenverfolgung und Ablaufdaten.

---

## 🏗️ Technische Architektur

```text
┌─────────────────────────────────────┐
│             FRONTEND                │
│       Blade + Bootstrap 5           │
│         Custom CSS                  │
└─────────────────┬───────────────────┘
                  │
┌─────────────────▼───────────────────┐
│             BACKEND                 │
│           Laravel 12                │
│     Controllers → Services → Models │
└─────────────────┬───────────────────┘
                  │
┌─────────────────▼───────────────────┐
│             DATABASE                │
│          MySQL – 25 Tabellen        │
└─────────────────────────────────────┘
```

## 🛠️ Tech-Stack

| Technologie | Version | Rolle |
|---|---|---|
| Laravel | 12.x | Backend-Framework |
| PHP | 8.2 | Backend-Sprache |
| MySQL | 8.0 | Datenbank |
| Blade | - | Template-Engine |
| Bootstrap | 5.3 | CSS-Framework |
| Vite | 7.x | Build-Tool |
| Eloquent ORM | - | Datenbankverwaltung |

---

## ⚙️ Installation

### Voraussetzungen

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18
- NPM

### Installationsschritte

**1. Repository klonen**

```bash
git clone https://github.com/lobnaelamrany/ecloria-site.git
cd ecloria-site
```

**2. PHP-Abhängigkeiten installieren**

```bash
composer install
```

**3. JavaScript-Abhängigkeiten installieren**

```bash
npm install
```

**4. .env-Datei erstellen**

```bash
cp .env.example .env
```

**5. Anwendungsschlüssel generieren**

```bash
php artisan key:generate
```

**6. Datenbank konfigurieren**

Die folgenden Einstellungen in der `.env`-Datei anpassen:

```env
DB_DATABASE=ecloria
DB_USERNAME=root
DB_PASSWORD=
```

**7. Migrationen und Seeder ausführen**

```bash
php artisan migrate:fresh --seed
```

**8. Storage-Link erstellen**

```bash
php artisan storage:link
```

**9. Anwendung starten**

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

---

## 🧪 Tests

Um die Tests auszuführen:

```bash
php artisan test
```

---

## 👩‍💻 Autorin

**Lobna El Amrany**

- **GitHub:** [@lobnaelamrany](https://github.com/lobnaelamrany)
- **E-Mail:** [lobnaelamrany4@gmail.com](mailto:lobnaelamrany4@gmail.com)

---

<div align="center">

⭐ Wenn Ihnen dieses Projekt gefällt, geben Sie ihm bitte einen Stern! ⭐

**Mit ❤️ entwickelt von Lobna El Amrany**

</div>
