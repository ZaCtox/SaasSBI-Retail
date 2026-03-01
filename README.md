<div align="center">

# 📊 SaaS BI Dashboard

**Laravel 11 · React · Chart.js**

*Dashboard de Business Intelligence tipo SaaS con arquitectura desacoplada*

<br>

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![React](https://img.shields.io/badge/React-18+-61DAFB?style=flat-square&logo=react)](https://reactjs.org)
[![Chart.js](https://img.shields.io/badge/Chart.js-4.x-FF6384?style=flat-square&logo=chart.js)](https://www.chartjs.org/)

</div>

## 🛠️ Stack Tecnológico

- PHP 8.2
- Laravel 11
- MySQL
- React 18
- Axios
- Chart.js
---

## 🖥️ Demo

![Dashboard Screenshot](docs/dashboard.png)
![Dashboard Screenshot](docs/dashboard2.png)

---

## 📑 Tabla de contenidos

- [Contexto del proyecto](#-1-contexto-del-proyecto)
- [Arquitectura del sistema](#-2-arquitectura-del-sistema)
- [Endpoint principal](#-3-endpoint-principal)
- [Visualización](#-4-visualización)
- [Instalación](#-5-instalación)
- [Objetivos técnicos](#-6-objetivos-técnicos-del-proyecto)
- [Mejoras futuras](#-7-posibles-mejoras-futuras)
- [Autor](#-autor)

---

## 🧠 1. Contexto del proyecto

Este proyecto simula un **Dashboard de Business Intelligence** tipo SaaS, construido con arquitectura desacoplada (**Backend API** + **Frontend SPA**).

El objetivo es modelar un escenario real de retail donde se analizan:

| Métrica | Descripción |
|--------|-------------|
| 📈 **Ventas totales** | Agregado de ingresos por ventas |
| 💰 **Margen total** | Margen de beneficio del negocio |
| 🏆 **Productos más vendidos** | Ranking por revenue |
| 📅 **Evolución mensual** | Tendencia de ventas en el tiempo |

---

## 🏗 2. Arquitectura del sistema

```
Proyecto-SaaS/
│
├── backend/   → Laravel 11 (API REST)
│   ├── Controllers
│   ├── Resources
│   └── Routes (api.php)
│
├── frontend/  → React (SPA)
│   ├── Components
│   ├── Hooks / API
│   └── Chart.js
│
├── database/  → Migraciones y seeders
└── etl/       → Procesos ETL (si aplica)
```

### 🔹 Backend

- **Laravel 11** — Framework PHP
- **Query Builder** — Consultas a base de datos
- **API Resource** — Respuesta JSON estructurada
- **Manejo de errores** — Respuestas consistentes

### 🔹 Frontend

- **React** — Interfaz SPA
- **Axios** — Cliente HTTP
- **Chart.js** — Gráficos interactivos
- **Componentización** — KpiCard, gráficos, etc.

---

## 📡 3. Endpoint principal

```http
GET /api/dashboard/kpis
```

Devuelve los indicadores agregados del negocio.

### 📦 Respuesta de ejemplo

```json
{
  "status": "success",
  "data": {
    "total_sales": 16218741.19,
    "total_margin": 5684562.82,
    "top_products": [
      {
        "name": "Nescafé 200g",
        "total_revenue": 5934012.76
      }
    ],
    "monthly_sales": [
      {
        "year": 2025,
        "month": 1,
        "total_sales": 1495493.98
      }
    ]
  }
}
```

---

## 📊 4. Visualización

El frontend consume la API y muestra:

| Componente | Descripción |
|------------|-------------|
| 🔷 **KPI Cards** | Tarjetas con ventas, margen y métricas clave |
| 📈 **Gráfico de línea** | Evolución mensual de ventas |
| 📋 **Ranking de productos** | Top productos por revenue |

> Esto simula el comportamiento de plataformas SaaS de BI.

## 🗄️ Modelo de Datos

El proyecto utiliza una estructura tipo esquema estrella:

- Fact table: `sales`
- Dimensiones: `products`, `dates`

---

## ⚙️ 5. Instalación

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm start
```

> El backend corre por defecto en `http://localhost:8000` y el frontend en `http://localhost:3000`.

---

## 🎯 6. Objetivos técnicos del proyecto

Este proyecto demuestra:

- ✅ Construcción de **API REST** profesional
- ✅ Separación **Controller / Resource**
- ✅ Transformación de datos en backend
- ✅ Consumo desacoplado **frontend–backend**
- ✅ Visualización de métricas empresariales
- ✅ Base para SaaS escalable

---

## 🚀 7. Posibles mejoras futuras

| Mejora | Descripción |
|--------|-------------|
| 🔐 **Autenticación JWT** | Seguridad y sesiones |
| 📊 **Filtros dinámicos** | Por año, categoría, etc. |
| 🏢 **Multi-tenant** | Múltiples clientes/organizaciones |
| ☁️ **Deploy en nube** | Render, Railway, Vercel |
| 📈 **Métricas adicionales** | Ticket promedio, crecimiento mensual |

---

## 👨‍💻 Autor

**José Lagos**  
*Ingeniería en Informática Empresarial*

Interesado en **Full Stack** & **Data Engineering**

`Laravel` · `React` · `BI` · `APIs` · `Arquitectura limpia`

---

<div align="center">

*Hecho con ☕ para proyectos de BI*

</div>

