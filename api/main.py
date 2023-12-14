import os
from flask import Flask, jsonify, request, render_template
from flask_mysqldb import MySQL

from dashboard import get_stats
from products import create_product, get_products, get_product, update_product, delete_product
from customers import create_customer, get_customers, get_customer, update_customer, delete_customer
from suppliers import create_supplier, get_suppliers, get_supplier, update_supplier, delete_supplier
from inventory import create_inventory, get_inventories, get_inventory, update_inventory, delete_inventory
from orders import create_order, get_order, get_orders, delete_order, get_order_details, add_order_detail

from flask_cors import CORS

from database import set_mysql
from dotenv import load_dotenv

app = Flask(__name__)

CORS(app)

load_dotenv()
# Required
app.config["MYSQL_HOST"] = os.getenv("MYSQL_HOST")
app.config["MYSQL_PORT"] = int(os.getenv("MYSQL_PORT"))
app.config["MYSQL_USER"] = os.getenv("MYSQL_USER")
app.config["MYSQL_PASSWORD"] = os.getenv("MYSQL_PASSWORD")
app.config["MYSQL_DB"] = os.getenv("MYSQL_DB")
# Extra configs, optional but mandatory for this project:
app.config["MYSQL_CURSORCLASS"] = os.getenv("MYSQL_CURSORCLASS")
app.config["MYSQL_AUTOCOMMIT"] = True if os.getenv("MYSQL_AUTOCOMMIT") == "true" else False

mysql = MySQL(app)
set_mysql(mysql)


@app.route("/")
def home():
  return "Hello!";

# ! Dashboard Endpoints
@app.route("/dashboard", methods=["GET"])
def dashboard():
    totals = get_stats()
    return jsonify(totals)

# ! Products Endpoints
@app.route("/products", methods=["GET", "POST"])
def products():
    if request.method == "POST":
        data = request.get_json()
        products = create_product(
            data["name"], data["price"], data["category"],
            data["stock_quantity"]
        )
        return jsonify(products)
    else:
        products = get_products()
        return jsonify(products)

@app.route("/products/<int:product_id>", methods=["GET", "PUT", "DELETE"])
def product(product_id):
    if request.method == "PUT":
        data = request.get_json()
        updated_product_id = update_product(
            product_id,
            data["name"], data["price"], data["category"],
            data["stock_quantity"]
        )
        return jsonify(updated_product_id)
    elif request.method == "DELETE":
        return jsonify(delete_product(product_id))
    else:
        product = get_product(product_id)
        return jsonify(product)
    

# ! Customers Endpoints
@app.route("/customers", methods=["GET", "POST"])
def customers():
    if request.method == "POST":
        data = request.get_json()
        customer = create_customer(data["name"], data["email"], data["phone"])
        return jsonify(customer)
    else:
        customers = get_customers()
        return jsonify(customers)

@app.route("/customers/<int:customer_id>", methods=["GET", "PUT", "DELETE"])
def customer(customer_id):
    if request.method == "PUT":
        data = request.get_json()
        updated_customer = update_customer(customer_id, data["name"], data["email"], data["phone"])
        return jsonify(updated_customer)
    elif request.method == "DELETE":
        return jsonify(delete_customer(customer_id))
    else:
        customer = get_customer(customer_id)
        return jsonify(customer)

# ! Suppliers Endpoints
@app.route("/suppliers", methods=["GET", "POST"])
def suppliers():
    if request.method == "POST":
        data = request.get_json()
        supplier = create_supplier(data["name"], data["contact_name"], data["phone"], data["address"])
        return jsonify(supplier)
    else:
        suppliers = get_suppliers()
        return jsonify(suppliers)

@app.route("/suppliers/<int:supplier_id>", methods=["GET", "PUT", "DELETE"])
def supplier(supplier_id):
    if request.method == "PUT":
        data = request.get_json()
        updated_supplier = update_supplier(supplier_id, data["name"], data["contact_name"], data["phone"], data["address"])
        return jsonify(updated_supplier)
    elif request.method == "DELETE":
        return jsonify(delete_supplier(supplier_id))
    else:
        supplier = get_supplier(supplier_id)
        return jsonify(supplier)

# ! Inventory Endpoints
@app.route("/inventory", methods=["GET", "POST"])
def inventories():
    if request.method == "POST":
        data = request.get_json()
        new_inventory = create_inventory(
            data["product_id"], data["supplier_id"], data["quantity"]
        )
        return jsonify(new_inventory)
    else:
        all_inventories = get_inventories()
        return jsonify(all_inventories)

@app.route("/inventory/<int:inventory_id>", methods=["GET", "PUT", "DELETE"])
def inventory_item(inventory_id):
    if request.method == "PUT":
        data = request.get_json()
        updated_inventory = update_inventory(
            inventory_id,
            data["product_id"], data["supplier_id"], data["quantity"]
        )
        return jsonify(updated_inventory)
    elif request.method == "DELETE":
        return jsonify(delete_inventory(inventory_id))
    else:
        inventory = get_inventory(inventory_id)
        return jsonify(inventory)

# ! Orders Endpoints
@app.route("/orders", methods=["GET", "POST"])
def orders():
    if request.method == "POST":
        data = request.get_json()
        # Expecting data to have 'customer_id' and 'products' (a list of {'product_id': x, 'quantity': y})
        new_order = create_order(
            data["customer_id"], 
            [(prod["product_id"], prod["quantity"]) for prod in data["products"]]
        )
        return jsonify(new_order)
    else:
        all_orders = get_orders()
        return jsonify(all_orders)

# Specific Order Endpoint
@app.route("/orders/<int:order_id>", methods=["GET", "DELETE"])
def order(order_id):
    if request.method == "DELETE":
        return jsonify(delete_order(order_id))
        
    else:
        order = get_order(order_id)
        return jsonify(order)

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)
