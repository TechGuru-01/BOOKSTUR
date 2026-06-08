# Institutional Bookstore Web Application

A specialized, full-stack e-commerce dashboard and inventory administration platform custom-built for San Sebastian College - Recoletos de Cavite. This system streamlines the catalog management, tracking, and local distribution of academic literature, school uniforms, and institutional supplies.

## Key Features
* Tailored E-Commerce Catalog: Purpose-built workflows optimized specifically for tracking academic books, school uniforms, and department-specific supplies.
* Interactive Shopping Workflows: Features complete user-side functionality including dynamic item selection, an interactive "add to cart" system, and a simulated checkout process to mimic production e-commerce operations.
* Premium High-Contrast UI: Built a modern dashboard layout designed for seamless administration, product filtering, and quick navigation.
* Administrative User Management: Empowers system administrators to handle student account requests, including an override feature to reset forgotten student passwords securely.
* Modular Full-Stack Architecture: Developed using structured PHP and MySQL CRUD logic to ensure a strict separation of concerns, avoiding bloat while maintaining database integrity.
* Inventory Control: Features a single source of truth for stock quantities, automated calculations, and localized database management.

## Tech Stack
* Backend: PHP, MySQL (Local XAMPP Environment)
* Frontend: JavaScript, HTML5, CSS3 (Premium High-Contrast Layouts)
* Architecture: Agile modular design, MVC/Separation of Concerns principles

## System & Transaction Workflow
1. Browse & Selection: Students browse the localized catalog for academic books, school uniforms, or supplies and add their selections to the dynamic shopping cart.
2. Checkout Simulation: The user proceeds through a simulated payment and checkout pipeline that validates transactions without real financial processing.
3. Inventory Update: Upon checkout completion, the backend triggers MySQL CRUD operations to adjust the available stock quantities across database tables.
4. Account Assistance: If a student loses access to their account, administrators can override database credentials via the secure admin panel to reset the forgotten password.

## Local Installation & Setup
1. Clone the repository into your local machine.
2. If using XAMPP, move the project directory into the htdocs/ folder.
3. Import the provided .sql file into your local phpMyAdmin database.
4. Configure your database connection string in the core configuration file.
5. Boot up Apache and MySQL on your XAMPP Control Panel and access the platform via localhost.
