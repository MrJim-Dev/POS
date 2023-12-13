from database import fetchone, fetchall, execute

# Functions for Orders

def create_order(customer_id, products):

    # Create a new order
    cursor = execute("CALL AddOrder(%s, @new_order_id);", (customer_id,))
    cursor.execute("SELECT @new_order_id AS new_order_id;")
    new_order_id = cursor.fetchone()['new_order_id']
    cursor.close()

    # Add each product to the order details
    total_amount = 0
    for product_id, quantity in products:
        total_amount += add_order_detail(new_order_id, product_id, quantity)['line_total']

    # Update the total amount in the order
    update_order_total(new_order_id, total_amount)

    return get_order(new_order_id)

def get_order(order_id):
    # Retrieve an order by its ID.
    query = "SELECT * FROM invoices WHERE order_id = %s"
    params = (order_id,)
    result = fetchone(query, params)
    return result

def get_orders():
    # Retrieve all orders.
    query = "SELECT * FROM invoices ORDER BY order_id DESC"
    result = fetchall(query)
    return result

def delete_order(order_id):
    # Delete an order and its details.
    if get_order(order_id) is not None:
        # First, delete the order details
        delete_order_details(order_id)

        # Then, delete the order
        query = "DELETE FROM orders WHERE order_id = %s"
        params = (order_id,)
        execute(query, params)

        return "success"
    
    else:
        return "Item not found"

# ! Functions for Order Details
def get_order_details(order_id):
    # Retrieve order details for a specific order.
    query = "SELECT * FROM order_details WHERE order_id = %s"
    params = (order_id,)
    result = fetchall(query, params)
    return result

def update_order_total(order_id, total_amount):
    query = "UPDATE orders SET total_amount = %s WHERE order_id = %s"
    params = (total_amount, order_id)
    execute(query, params)

def add_order_detail(order_id, product_id, quantity):
    line_total = calculate_line_total(product_id, quantity)
    query = "INSERT INTO order_details (order_id, product_id, quantity, line_total) VALUES (%s, %s, %s, %s)"
    params = (order_id, product_id, quantity, line_total)
    execute(query, params)
    
    return {
        'order_id': order_id,
        'product_id': product_id,
        'quantity': quantity,
        'line_total': line_total
    }

def delete_order_details(order_id):
    query = "DELETE FROM order_details WHERE order_id = %s"
    params = (order_id,)
    execute(query, params)

def calculate_line_total(product_id, quantity):
    product = fetchone("SELECT price FROM products WHERE product_id = %s", (product_id,))
    return product['price'] * quantity

