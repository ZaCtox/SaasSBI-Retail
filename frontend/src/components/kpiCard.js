function KpiCard({ title, value, growth }) {
  const isPositive = growth >= 0;

  return (
    <div
      style={{
        background: "#fff",
        padding: "20px",
        borderRadius: "12px",
        boxShadow: "0 4px 12px rgba(0,0,0,0.08)",
        minWidth: "220px",
        flex: 1
      }}
    >
      <h4 style={{ margin: 0, color: "#666" }}>{title}</h4>

      <h2 style={{ margin: "10px 0" }}>
        ${Number(value || 0).toLocaleString(undefined, {
          maximumFractionDigits: 2
        })}
      </h2>

      {growth !== undefined && (
        <p
          style={{
            margin: 0,
            fontWeight: "bold",
            color: isPositive ? "green" : "red"
          }}
        >
          {isPositive ? "▲" : "▼"}{" "}
          {Math.abs(growth).toFixed(2)}%
        </p>
      )}
    </div>
  );
}

export default KpiCard;