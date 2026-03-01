import { useEffect, useState } from "react";
import axios from "axios";
import KpiCard from "./components/kpiCard";
import {
  Chart as ChartJS,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  Tooltip,
  Legend
} from "chart.js";
import { Line } from "react-chartjs-2";

ChartJS.register(
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  Tooltip,
  Legend
);

function App() {
  const [kpis, setKpis] = useState(null);
  const [year, setYear] = useState("");
  const [month, setMonth] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchData();
  }, [year, month]); // 👈 ahora reacciona a filtros

  const fetchData = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await axios.get(
        "http://localhost:8000/api/dashboard/kpis",
        {
          params: { year, month }
        }
      );

      setKpis(response.data.data);
    } catch (err) {
      console.error(err);
      setError("Error al cargar datos");
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <p>Cargando...</p>;
  if (error) return <p>{error}</p>;
  if (!kpis) return null;

  const months = kpis.monthly_sales.map(
    item => `${item.month}/${item.year}`
  );

  const salesData = kpis.monthly_sales.map(
    item => parseFloat(item.total_sales)
  );

  const data = {
    labels: months,
    datasets: [
      {
        label: "Ventas Mensuales",
        data: salesData,
        tension: 0.3
      }
    ]
  };

  return (
    <div
      style={{
        background: "#f4f6f9",
        minHeight: "100vh",
        padding: "40px"
      }}
    >
      <h1 style={{ marginBottom: "30px" }}>
        📊 SaaS BI Dashboard
      </h1>

      {/* Filtros */}
      <div style={{ marginBottom: "30px" }}>
        <select value={year} onChange={(e) => setYear(e.target.value)}>
          <option value="">Todos los años</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>

        <select
          value={month}
          onChange={(e) => setMonth(e.target.value)}
          style={{ marginLeft: "10px" }}
        >
          <option value="">Todos los meses</option>
          {[...Array(12)].map((_, i) => (
            <option key={i} value={i + 1}>
              Mes {i + 1}
            </option>
          ))}
        </select>
      </div>

      {/* KPI GRID */}
      <div
        style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit, minmax(220px, 1fr))",
          gap: "20px",
          marginBottom: "40px"
        }}
      >
        <KpiCard
          title="Total Ventas"
          value={kpis.total_sales}
          growth={kpis.growth_percentage}
        />
        <KpiCard
          title="Total Margen"
          value={kpis.total_margin}
        />
        <KpiCard
          title="Ticket Promedio"
          value={kpis.average_ticket}
        />
      </div>

      {/* Top Productos */}
      <div style={{ marginBottom: "40px" }}>
        <h3>🏆 Top Productos</h3>
        <ul>
          {kpis.top_products.map((product, index) => (
            <li key={index}>
              {product.name} - $
              {Number(product.total_revenue).toLocaleString()}
            </li>
          ))}
        </ul>
      </div>

      {/* Gráfico */}
      <div
        style={{
          background: "#fff",
          padding: "20px",
          borderRadius: "12px",
          boxShadow: "0 4px 12px rgba(0,0,0,0.08)"
        }}
      >
        <h3>📈 Ventas Mensuales</h3>
        <Line data={data} />
      </div>
    </div>
  );
}

export default App;