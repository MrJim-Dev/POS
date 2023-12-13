from database import fetchone, fetchall, execute

# Functions for Orders

def create_order(customer_id, product_id, quantity):
    # Create a new order and its corresponding order details.
    new_order_id = None
    params = (customer_id, product_id, quantity)
    cursor = execute("CALL AddOrder(%s, %s, %s, @new_order_id);", params)

    # Fetch the new order ID set by the stored procedure
    cursor.execute("SELECT @new_order_id AS new_order_id;")
    new_order_id = cursor.fetchone()

    cursor.close()
    return get_order(new_order_id['new_order_id'])

def get_order(order_id):
    # Retrieve an order by its ID.
    query = "SELECT * FROM OrderSummary WHERE order_id = %s"
    params = (order_id,)
    result = fetchone(query, params)
    return result

def get_orders():
    # Retrieve all orders.
    query = "SELECT * FROM OrderSummary"
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

def add_order_detail(order_id, product_id, quantity):
    #Add a new line item to an existing order.
    line_total = calculate_line_total(product_id, quantity)
    query = "INSERT INTO order_details (order_id, product_id, quantity, line_total) VALUES (%s, %s, %s, %s)"
    params = (order_id, product_id, quantity, line_total)
    result = execute(query, params)
    result.close()
    return get_order_details(order_id)

def delete_order_details(order_id):
    # Delete order details for a specific order.
    query = "DELETE FROM order_details WHERE order_id = %s"
    params = (order_id,)
    execute(query, params)

def calculate_line_total(product_id, quantity):
    #Helper function to calculate line total for an order detail.
    product = fetchone("SELECT price FROM products WHERE product_id = %s", (product_id,))
    return product['price'] * quantity

# You may add more functions as needed, such as updating order details, etc.
