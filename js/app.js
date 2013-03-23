
$('.btn-opendata').click(function() {
	$('.box-howto').hide().removeClass('hidden').slideDown(); 
	// $(this).hide();
	return false;
});

$('button.close').click(function() {
	$(this).parents('.box').slideUp();
	return false;
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

	  d3.select('#chart svg')
		.datum(chartdata)
		  .transition().duration(500).call(chart);

	  nv.utils.windowResize(chart.update);

	  return chart;
	});

});
