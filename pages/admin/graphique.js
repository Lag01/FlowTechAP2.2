const ctx = document.getElementById("GraphiquePC");

new Chart(ctx, {
	type: "pie",
	data: {
		labels: ["Atlas", "Savana", "Kraken", "Fractal-North", "Tracer", "Freezer", "Orion", "Omega"],
		datasets: [
			{
				label: "Nombre de ventes",
				data: [1, 1, 2, 1, 2, 1, 1, 1],
				borderWidth: 1,
			},
		],
	},
	options: {
		scales: {
			y: {
				beginAtZero: true,
			},
		},
	},
});
