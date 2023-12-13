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

CREATE VIEW OrdersTable AS
SELECT 
    orders.order_id, 
    customers.name AS customer_name, 
    products.name AS product_name, 
    order_details.quantity, 
    order_details.line_total,
    orders.order_date
FROM orders 
JOIN order_details ON orders.order_id = order_details.order_id 
JOIN products ON order_details.product_id = products.product_id
JOIN customers ON orders.customer_id = customers.customer_id;



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
CREATE PROCEDURE AddOrder(IN cust_id INT, IN prod_id INT, IN qty INT, OUT new_order_id INT)
BEGIN
    DECLARE ord_total DECIMAL(10, 2);

    -- Insert into orders table
    INSERT INTO orders (customer_id, total_amount) VALUES (cust_id, 0);
    SET new_order_id = LAST_INSERT_ID();

    -- Calculate total amount
    SELECT price INTO ord_total FROM products WHERE product_id = prod_id;
    SET ord_total = ord_total * qty;

    -- Insert into order details
    INSERT INTO order_details (order_id, product_id, quantity, line_total) VALUES (new_order_id, prod_id, qty, ord_total);

    -- Update the total amount in orders table
    UPDATE orders SET total_amount = ord_total WHERE order_id = new_order_id;
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
