# Meiktila Local Service and Information System (Meiktila Hub)

A comprehensive, web-based platform designed to bridge the gap between local service providers and residents/visitors in Meiktila. This system allows users to discover local businesses, services, and essential information easily, while providing service providers with a powerful platform to manage their offerings.

## 🚀 Key Features

### 👤 For Users & Visitors
* Multi-Category Browsing: Seamlessly search and filter services by categories (e.g., healthcare, education, local shops, transport).
* Detailed Service Profiles: View business hours, contact details, locations, and descriptions.
* Easy Navigation: Quickly find the way back to the home page or specific categories with an intuitive UI.

### 💼 For Service Providers (CRUD Management)
* Provider Authentication: Secure login and registration for verified local businesses.
* Service Management (Full CRUD): Providers can easily Create, Read, Update, and Delete their service listings, upload images, and update contact details in real-time.

### 🛡️ For Administrators
* Admin Dashboard: Centralized control panel to manage categories, verify provider accounts, and monitor listings to ensure data quality and security.

## 🛠️ Tech Stack & Architecture

* Backend: PHP (OOP & Procedural) with secure session handling.
* Database: MySQL (Relational database with optimized triggers and relations).
* Frontend: HTML5, CSS3 (Custom gradients & dynamic animations), Bootstrap 5, FontAwesome 6.
* Security: Implemented secure environment configurations, prepared SQL statements to prevent SQL injection, and integrated standard PHPMailer protocols.

## 📁 Database Schema Highlights
The system relies on a relational database structure:
* categories linked with services via One-to-Many relationship.
* Optimized queries using LEFT JOIN and GROUP BY to dynamically count total available services per category.

---
*Developed as a professional portfolio project to solve real-world local community challenges.*
