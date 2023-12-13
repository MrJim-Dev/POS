from database import fetchone, fetchall, execute

def create_inventory(product_id, supplier_id, quantity):
    query = """
    INSERT INTO inventory (product_id, supplier_id, quantity)
    VALUES (%s, %s, %s)
    """
    params = (product_id, supplier_id, quantity)
    result = execute(query, params)
    inventory_id = result.lastrowid
    result.close()

    return get_inventory(inventory_id)

def get_inventory(inventory_id):
    query = "SELECT * FROM inventory WHERE inventory_id = %s"
    params = (inventory_id,)
    result = fetchone(query, params)
    return result

def get_inventories():
    query = "SELECT * FROM inventory"
    return fetchall(query)

def update_inventory(inventory_id, product_id, supplier_id, quantity):
    query = """
    UPDATE inventory
    SET product_id = %s, supplier_id = %s, quantity = %s
    WHERE inventory_id = %s
    """
    params = (product_id, supplier_id, quantity, inventory_id)
    result = execute(query, params)

    if result is None:
        return None

    return get_inventory(inventory_id)

def delete_inventory(inventory_id):
    if get_inventory(inventory_id) is not None:
        query = "DELETE FROM inventory WHERE inventory_id = %s"
        params = (inventory_id,)
        result = execute(query, params)

        if result is None:
            return "error"

        return "success"
    else:
        return "Item not found"
