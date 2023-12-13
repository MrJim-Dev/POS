from database import fetchone, fetchall, execute

def create_supplier(name, contact_name, phone, address):
    query = "INSERT INTO suppliers (name, contact_name, phone, address) VALUES (%s, %s, %s, %s)"
    params = (name, contact_name, phone, address)
    result = execute(query, params)
    supplier_id = result.lastrowid
    result.close()

    return get_supplier(supplier_id)

def get_suppliers():
    query = "SELECT * FROM suppliers"
    return fetchall(query)

def get_supplier(supplier_id):
    query = "SELECT * FROM suppliers WHERE supplier_id = %s"
    params = (supplier_id,)
    return fetchone(query, params)

def update_supplier(supplier_id, name, contact_name, phone, address):
    query = "UPDATE suppliers SET name = %s, contact_name = %s, phone = %s, address = %s WHERE supplier_id = %s"
    params = (name, contact_name, phone, address, supplier_id)
    execute(query, params)

    return get_supplier(supplier_id)

def delete_supplier(supplier_id):
    if get_supplier(supplier_id) is not None:
        query = "DELETE FROM suppliers WHERE supplier_id = %s"
        params = (supplier_id,)
        result = execute(query, params)

        if result is None:
            return "error"
    
        return "success"
    
    else:
        return "Item not found"
    

