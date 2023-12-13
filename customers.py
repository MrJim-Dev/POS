from database import fetchone, fetchall, execute

def create_customer(name, email, phone):
    query = "INSERT INTO customers (name, email, phone) VALUES (%s, %s, %s)"
    params = (name, email, phone)
    result = execute(query, params)
    customer_id = result.lastrowid
    result.close()

    return get_customer(customer_id)

def get_customers():
    query = "SELECT * FROM customers"
    return fetchall(query)

def get_customer(customer_id):
    query = "SELECT * FROM customers WHERE customer_id = %s"
    params = (customer_id,)
    return fetchone(query, params)

def update_customer(customer_id, name, email, phone):
    query = "UPDATE customers SET name = %s, email = %s, phone = %s WHERE customer_id = %s"
    params = (name, email, phone, customer_id)
    execute(query, params)

    return get_customer(customer_id)

def delete_customer(customer_id):
    if get_customer(customer_id) is not None:
        query = "DELETE FROM customers WHERE customer_id = %s"
        params = (customer_id,)
        result = execute(query, params)

        if result is None:
            return "error"
    
        return "success"
    
    else:
        return "Item not found"
