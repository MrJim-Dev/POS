from database import fetchone, fetchall, execute

def create_product(name, price, category, stock_quantity):
    query = "INSERT INTO products (name, price, category, stock_quantity) VALUES (%s, %s, %s, %s)"
    params = (name, price, category, stock_quantity)
    result = execute(query, params) 
    product_id = result.lastrowid  
    result.close()  

    return get_product(product_id)

def get_products():
    query = "SELECT * FROM products"
    result = fetchall(query)
    return result

def get_product(product_id):
    query = "SELECT * FROM products WHERE product_id = %s"
    params = (product_id,)
    result = fetchone(query, params)
    return result

def update_product(product_id, name, price, category, stock_quantity):
    query = "UPDATE products SET name = %s, price = %s, category = %s, stock_quantity = %s WHERE product_id = %s"
    params = (name, price, category, stock_quantity, product_id)
    result = execute(query, params)

    if result is None:
        return None
    
    return get_product(product_id)

def delete_product(product_id):

    if get_product(product_id) is not None:
        query = "DELETE FROM products WHERE product_id = %s"
        params = (product_id,)
        result = execute(query, params)

        if result is None:
            return "error"
    
        return "success"
    
    else:
        return "Item not found"
