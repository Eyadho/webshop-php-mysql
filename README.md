# 🛒 Klasses Webshop

A full-stack webshop built with **PHP** and **MySQL**, containerized with **Docker**. Customers can browse products, manage a cart, and place orders. The store owner has an admin panel to manage all incoming orders.

---

## 📸 Preview

> _Add screenshots here — drag and drop images into the repo_

| Shop | Cart | Admin |
|---|---|---|
| ![shop](screenshots/shop.png) | ![cart](screenshots/cart.png) | ![admin](screenshots/admin.png) |

---

## 🚀 Built With

| Technology | Usage |
|---|---|
| PHP 8.2 | Server-side logic, sessions, form handling |
| MySQL 8.0 | Database — products, customers, orders |
| HTML5 | Frontend structure |
| Docker + Docker Compose | Local dev environment |
| phpMyAdmin | Database management UI |

---

## ✅ Features

### 🛍️ Customer Side
- Browse all available products with image, description and price
- Add products to cart with quantity selector
- Cart managed via **PHP Sessions**
- Clear cart or continue shopping
- Checkout form with full customer details
- Customer automatically saved to DB on order
- Error message if required fields are missing
- Confirmation message after successful order

### 🔧 Admin Panel
- View all orders sorted by date (newest first)
- See customer info and ordered products per order
- Update order status: `Ordered` → `Packed` → `Shipped` → `Paid`
- Delete an order

---

## 🗄️ Database Structure

```sql
customers
├── id
├── firstname
├── lastname
├── phone
├── address
├── zipcode
├── city
└── email

products
├── id
├── name
├── description
├── price
└── image

orders
├── id
├── customer_id  →  customers.id
├── status       (Ordered | Packed | Shipped | Paid)
├── order_date
└── total_amount

order_items
├── id
├── order_id     →  orders.id
├── product_id   →  products.id
├── quantity
└── amount
```

---

## 📁 Project Structure

```
klasses-getost-webshop/
├── src/
│   ├── index.php          # Product listing
│   ├── cart.php           # Shopping cart (session-based)
│   ├── checkout.php       # Order form + DB insert
│   ├── admin.php          # Admin panel
│   └── database.php       # DB connection
├── mysql.dockerfile       # PHP + Apache image with mysqli
├── docker-compose.yml     # PHP + MySQL + phpMyAdmin
└── README.md
```

---

## 🚦 Order Status Flow

```
Ordered  →  Packed  →  Shipped  →  Paid
```

---

## ⚙️ Setup & Installation

### Requirements
- [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Steps

1. Clone the repo
```bash
git clone https://github.com/[ditt-användarnamn]/klasses-getost-webshop.git
cd klasses-getost-webshop
```

2. Start the containers
```bash
docker-compose up -d
```

3. Open in browser

| Service | URL |
|---|---|
| Webshop | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| Admin panel | http://localhost:8080/admin.php |

4. In phpMyAdmin — create the database `webbshopDB` and import your SQL schema

---

## 📋 Assignment Requirements

Built as part of the **Webbutveckling** course at GRIT Academy.

| Requirement | Status |
|---|---|
| Product listing page | ✅ |
| Add to cart and place order | ✅ |
| Customer saved automatically on order | ✅ |
| Error handling — missing fields | ✅ |
| Order confirmation message | ✅ |
| Admin — list all orders sorted by date | ✅ |
| Admin — delete order | ✅ |
| Admin — update order status | ✅ |
| SQL: INSERT, UPDATE, DELETE, SELECT | ✅ |
| Minimum 5 products in DB | ✅ |

---

## 👤 Author

**Eyad Hussen**  
GRIT Academy — Webbutveckling med inriktning UX & E-handel  
[LinkedIn](#) · [GitHub](#)
