import random
import pandas as pd
from sqlalchemy import create_engine

# 🔌 Conexión a PostgreSQL Docker (puerto 5433)
DB_USER = "admin"
DB_PASS = "admin123"
DB_HOST = "localhost"
DB_PORT = "5433"
DB_NAME = "retail_bi"

engine = create_engine(
    f"postgresql://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}"
)

# 📥 Cargar dimensiones
products = pd.read_sql("SELECT id FROM products", engine)
stores = pd.read_sql("SELECT id FROM stores", engine)
dates = pd.read_sql("SELECT id FROM dates", engine)

print("Dimensiones cargadas correctamente.")

# 🎲 Generar ventas aleatorias
sales_data = []

for _ in range(1000):  # Generar 1000 ventas
    product_id = random.choice(products["id"].tolist())
    store_id = random.choice(stores["id"].tolist())
    date_id = random.choice(dates["id"].tolist())

    quantity = random.randint(1, 10)
    unit_price = round(random.uniform(1000, 5000), 2)
    cost = round(unit_price * random.uniform(0.5, 0.8), 2)

    revenue = round(quantity * unit_price, 2)
    margin = round(revenue - (quantity * cost), 2)

    sales_data.append({
        "date_id": date_id,
        "product_id": product_id,
        "store_id": store_id,
        "quantity": quantity,
        "unit_price": unit_price,
        "cost": cost,
        "revenue": revenue,
        "margin": margin
    })

sales_df = pd.DataFrame(sales_data)

# 📤 Insertar en PostgreSQL
sales_df.to_sql("sales", engine, if_exists="append", index=False)

print("Ventas generadas e insertadas correctamente.")