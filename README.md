
# RIJILL X MARKET

### Full-Stack E-Commerce Web Application

RIJILL X MARKET is a full-stack e-commerce web application developed using Laravel 12, PHP, MySQL, Blade, JavaScript, and Vite.

The project demonstrates an end-to-end online shopping workflow, including customer authentication, product browsing, cart management, checkout, order tracking, inventory management, and an administrative dashboard.

**Project Status:** Portfolio Project — Core Features Completed and Locally Tested

**Developer:** Rijal Muharam  
**GitHub:** [@rijal-devlp](https://github.com/rijal-devlp)  
**Repository:** [rijill-x-market](https://github.com/rijal-devlp/rijill-x-market)

---

## Features

### Customer Features

- Customer registration and login
- Product catalog and category filtering
- Product search
- Product detail pages
- Persistent shopping cart
- Cart quantity management
- Partial checkout for selected cart items
- Checkout form with customer and shipping information
- Payment method selection:
  - QRIS
  - Bank transfer
  - E-wallet
  - Cash on Delivery (COD)
- Checkout success page
- Customer order history
- Detailed order information
- Payment status display (UNPAID / PAID)
- Order status tracking

### Admin Features

- Administrative dashboard with summary statistics
- Product management (Create, Read, Update, Delete)
- Product image upload
- Product category and stock management
- Soft deletion and product trash
- Restore deleted products
- Permanently delete products
- Customer order management
- Update order status:
  - Pending
  - Processing
  - Shipped
  - Completed
  - Cancelled
- Update payment status
- Role-based access restrictions

### Additional Functionality

- Database-backed cart storage
- Stock validation during checkout
- Database transactions and row locking for inventory consistency
- Product information snapshots in order history
- Preservation of order item details after product deletion
- Password hashing
- Login rate limiting
- Responsive interface
- Custom dark-themed user interface

---

## Technology Stack

| Technology | Purpose |
|---|---|
| Laravel 12 | Backend framework |
| PHP 8.2 | Server-side programming |
| MySQL | Relational database |
| Blade | Server-rendered templates |
| HTML5 | Page structure |
| CSS3 | Custom styling and responsive layout |
| JavaScript | Frontend interactions |
| Vite | Frontend asset bundling |
| Composer | PHP dependency management |
| npm | JavaScript dependency management |
| Git & GitHub | Version control |

---

## Application Workflow

### Customer

1. Register or log in.
2. Browse products and search by name or category.
3. View product details.
4. Add products to the shopping cart.
5. Adjust product quantities.
6. Select items for checkout.
7. Enter shipping information.
8. Choose a payment method.
9. Place an order.
10. View order history and track order status.

### Administrator

1. Log in with an authorized admin account.
2. Access dashboard statistics.
3. Create and manage products.
4. Review incoming orders.
5. Update order processing and shipping statuses.
6. Update payment status.
7. Manage deleted products.

---

## Installation

### Prerequisites

Make sure the following tools are installed:

- PHP 8.2 or compatible PHP version supported by the project
- Composer
- MySQL
- Node.js and npm
- Git

### 1. Clone the repository

```bash
git clone https://github.com/rijal-devlp/rijill-x-market.git
cd rijill-x-market
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Configure the environment

Copy the example environment file.

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

On Linux or macOS:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

### 5. Configure MySQL

Create a MySQL database named:

```text
toko_online
```

Update the database settings in `.env`:

```dotenv
APP_NAME="RIJILL X MARKET"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_online
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the database credentials to match your local environment.

The example above is intended for local development only.

### 6. Run database migrations

```bash
php artisan migrate
```

### 7. Create the public storage link

```bash
php artisan storage:link
```

### 8. Start the Laravel development server

```bash
php artisan serve
```

### 9. Start Vite

Open another terminal and run:

```bash
npm run dev
```

### 10. Open the application

Visit:

http://127.0.0.1:8000

An admin account must be provisioned with the appropriate role before accessing administrative features. Do not use default or publicly documented passwords in a deployed environment.

---

## Payment System Disclaimer

**This application uses a simulated payment workflow.**

Payment options are provided for demonstrating the checkout experience.

- No real payment gateway is integrated.
- No actual financial transactions are processed.
- Payment status is managed by an authorized administrator.
- The application should not be used to collect real customer payments without further development and security review.

---

## Security

The application includes several security-related features:

- Laravel authentication and session handling
- Password hashing
- Role-based authorization
- Login rate limiting
- Server-side input validation
- Database transactions for checkout
- Stock consistency checks

This is a portfolio demonstration project and has not undergone an independent production security audit.

Before production deployment:

- Configure production environment variables
- Disable debug mode
- Use secure database credentials
- Replace all development credentials
- Configure HTTPS
- Review file permissions
- Set up monitoring and backups

---

## Testing

The following workflows have been manually tested in the local development environment:

- Admin dashboard navigation
- Product creation, editing, deletion, and restoration
- Order management and status updates
- Customer authentication and product browsing
- Shopping cart and partial checkout
- Order history and payment status
- Admin-to-customer order status synchronization
- Role-based access restrictions
- Responsive layout checks

Automated test coverage is not claimed by this document.

---

## Screenshots

Application screenshots will be added to showcase:

- Homepage / Product Collection
- Product Details
- Shopping Cart
- Checkout
- Customer Orders
- Admin Dashboard
- Product Management
- Order Management

---

## Future Improvements

Potential future enhancements include:

- Real payment gateway integration
- Automated testing
- Email notifications
- Product reviews and ratings
- Sales analytics
- Deployment monitoring

---

## Author

**Rijal Muharam**

Informatics Engineering Graduate  
Full-Stack Web Development

GitHub: https://github.com/rijal-devlp

---

## Project Notice

RIJILL X MARKET was developed as a personal portfolio project to demonstrate practical Laravel-based full-stack web development skills.

The project is intended for educational and demonstration purposes.
