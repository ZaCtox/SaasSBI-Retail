import { useEffect, useState } from "react";
import axios from "axios";
import KpiCard from "././components/kpiCard";
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

  useEffect(() => {
    axios.get("http://127.0.0.1:8000/api/dashboard/kpis")
      .then(response => {
        setKpis(response.data.data);
      })
      .catch(error => {
        console.error(error);
      });
  }, []);

  if (!kpis) return <p>Cargando...</p>;

  const months = kpis.monthly_sales.map(item => `Mes ${item.month}`);
  const salesData = kpis.monthly_sales.map(item => parseFloat(item.total_sales));

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
    <div>
      <h1>Dashboard</h1>
      <div style={{ display: "flex" }}>
        <KpiCard title="Total Ventas" value={kpis.total_sales} />
        <KpiCard title="Total Margen" value={kpis.total_margin} />
      </div>
      <h3>Top Productos</h3>
      <ul>
        {kpis.top_products.map((product, index) => (
          <li key={index}>
            {product.name} - ${product.total_revenue}
          </li>
        ))}
      </ul>
      <h3>Ventas Mensuales</h3>
      <Line data={data} />
    </div>

  );
}

export default App;