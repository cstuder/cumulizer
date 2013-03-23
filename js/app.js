
$('.btn-opendata').click(function() {
	$('.box-howto').hide().removeClass('hidden').slideDown(); 
	// $(this).hide();
	return false;
});

$('button.close').click(function() {
	$(this).parents('.box').slideUp();
	return false;
});

$.get('index.php/api?action=categories', function(data) {
	return;
	var chartdata = [ { key: "Categories", values: [] } ];
	
	for (var i = 2; i < 12; i++) {
		chartdata[0].values.push({
			"label": data[i],
			"value": Math.random() * 100
		});
	}
	
	nv.addGraph(function() {
	  var chart = nv.models.pieChart()
		  .x(function(d) { return d.label })
		  .y(function(d) { return d.value })
		  .showLabels(true);

		d3.select("#chart-spending-pie svg")
		    .datum(chartdata)
		  .transition().duration(1200)
		    .call(chart);

	  return chart;
	});

});

$.get('index.php/api?action=spendings&year=2012&month=1', function(data) {

	var spendings = [];
	
	$(data).each(function() { 
		spendings.push([
			new Date(this.year, this.month, 1),
			parseFloat(this.pricesum)
		]);
	});
	
	chartdata = [ { "key": "Spendings", "values": spendings }];
	
	nv.addGraph(function() {
	  var chart = nv.models.stackedAreaChart()
		            .x(function(d) { return d[0] })
		            .y(function(d) { return d[1] })
		            .clipEdge(true);

	  chart.xAxis
		  .showMaxMin(false)
		  .tickFormat(function(d) { return d3.time.format('%x')(new Date(d)) });

	  chart.yAxis
		  .tickFormat(d3.format(',.2f'));

	  d3.select('#chart-spending-stacked svg')
		.datum(chartdata)
		  .transition().duration(500).call(chart);

	  nv.utils.windowResize(chart.update);

	  return chart;
	});

});
