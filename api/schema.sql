-- Products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(255),
    stock_quantity INT DEFAULT 0
);

-- Orders Table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    customer_id INT,
    total_amount DECIMAL(10, 2),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

-- Order Details Table
CREATE TABLE order_details (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    line_total DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Customers Table
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20)
);

-- Suppliers Table
CREATE TABLE suppliers (
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    contact_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT
);

-- Inventory Table
CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    supplier_id INT,
    quantity INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id)
);

CREATE VIEW invoices AS
SELECT 
    o.order_id, 
    c.name AS customer_name, 
    o.order_date, 
    GROUP_CONCAT(p.name SEPARATOR ', ') AS products,
    GROUP_CONCAT(od.quantity SEPARATOR ', ') AS quantities,
    SUM(od.line_total) AS total_amount
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN order_details od ON o.order_id = od.order_id
JOIN products p ON od.product_id = p.product_id
GROUP BY o.order_id;

-- Order Summary View
CREATE VIEW OrderSummary AS
SELECT orders.order_id, customers.name AS customer_name, orders.order_date, SUM(order_details.line_total) AS total_amount
FROM orders
JOIN order_details ON orders.order_id = order_details.order_id
JOIN customers ON orders.customer_id = customers.customer_id
GROUP BY orders.order_id;

-- Inventory View

CREATE VIEW InventoryView AS
SELECT 
    p.product_id,
    p.name AS product_name,
    p.price,
    p.category,
    i.quantity AS stock_quantity,
    s.name AS supplier_name,
    s.contact_name AS supplier_contact,
    s.phone AS supplier_phone,
    s.address AS supplier_address
FROM products p
JOIN inventory i ON p.product_id = i.product_id
JOIN suppliers s ON i.supplier_id = s.supplier_id;


-- Add Order Procedures
DELIMITER //
CREATE PROCEDURE AddOrder(IN cust_id INT, OUT new_order_id INT)
BEGIN
    -- Insert into orders table with an initial total amount of 0
    INSERT INTO orders (customer_id, total_amount) VALUES (cust_id, 0);
    SET new_order_id = LAST_INSERT_ID();  
END //
DELIMITER ;


-- Adter Order Insert Trigger
DELIMITER //
CREATE TRIGGER AfterOrderInsert
AFTER INSERT ON order_details
FOR EACH ROW
BEGIN
    UPDATE products SET stock_quantity = stock_quantity - NEW.quantity
    WHERE product_id = NEW.product_id;
END //
DELIMITER ;

-- Dashboardview
CREATE VIEW DashboardView AS
SELECT 
    -- Total Sales Information
    (SELECT SUM(total_amount) FROM orders) AS total_sales,
    (SELECT COUNT(*) FROM orders) AS total_orders,
    (SELECT COUNT(DISTINCT customer_id) FROM orders) AS unique_customers,

    -- Inventory Overview
    (SELECT SUM(stock_quantity) FROM products) AS total_stock,
    (SELECT COUNT(*) FROM products) AS total_products,
    (SELECT COUNT(*) FROM suppliers) AS total_suppliers,

    -- Recent Orders Information
    (SELECT COUNT(*) FROM orders WHERE order_date > NOW() - INTERVAL 7 DAY) AS recent_orders,
    (SELECT SUM(total_amount) FROM orders WHERE order_date > NOW() - INTERVAL 7 DAY) AS recent_sales,

    -- Customer Engagement
    (SELECT COUNT(*) FROM customers) AS total_customers,
    (SELECT COUNT(*) FROM customers WHERE email IS NOT NULL) AS customers_with_email,
    (SELECT COUNT(*) FROM customers WHERE phone IS NOT NULL) AS customers_with_phone

FROM DUAL;
