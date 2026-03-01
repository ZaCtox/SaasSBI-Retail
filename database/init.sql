CREATE TABLE brands (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    brand_id INTEGER REFERENCES brands(id),
    category VARCHAR(100),
    sku VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stores (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    region VARCHAR(100),
    channel VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE dates (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    year INTEGER,
    month INTEGER,
    month_name VARCHAR(20),
    quarter INTEGER,
    week INTEGER,
    day INTEGER
);

CREATE TABLE sales (
    id SERIAL PRIMARY KEY,
    date_id INTEGER REFERENCES dates(id),
    product_id INTEGER REFERENCES products(id),
    store_id INTEGER REFERENCES stores(id),
    quantity INTEGER,
    unit_price NUMERIC(10,2),
    cost NUMERIC(10,2),
    revenue NUMERIC(12,2),
    margin NUMERIC(12,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE inventory (
    id SERIAL PRIMARY KEY,
    product_id INTEGER REFERENCES products(id),
    store_id INTEGER REFERENCES stores(id),
    stock_quantity INTEGER,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);