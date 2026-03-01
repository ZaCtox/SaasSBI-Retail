function KpiCard({ title, value }) {
  return (
    <div style={{
      border: "1px solid #ddd",
      padding: "20px",
      borderRadius: "10px",
      margin: "10px"
    }}>
      <h4>{title}</h4>
      <h2>${Number(value).toLocaleString()}</h2>
    </div>
  );
}

export default KpiCard;