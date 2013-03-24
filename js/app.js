
$('.btn-opendata').click(function() {
	$('.box-howto').hide().removeClass('hidden').slideDown(); 
	// $(this).hide();
	return false;
});

$('button.close').click(function() {
	$(this).parents('.box').slideUp();
	return false;
});

$('.nav-list a').click(function (e) {
  e.preventDefault();
  var target = $($(this).attr('href'));
  target.parent().find('.tab-pane').hide();
  target.show();
  $(this).parents('.nav-list').find('.active').removeClass('active');
  $(this).parent().addClass('active');
});

$.get('index.php/api?action=categories', function(data) {
   
	var chartdata = [];
	
	for (var i = 2; i < 12; i++) {
		chartdata.push({
			key: data[i],
			y: Math.random() * 20
		});
	}
   
	var chart;
	nv.addGraph(function() {
		var width = 500,
		    height = 300;

		chart = nv.models.pieChart()
		    .x(function(d) { return d.key })
		    .y(function(d) { return d.y })
		    //.showLabels(false)
		    .showLegend(false)
		    .values(function(d) { return d })
		    .color(d3.scale.category10().range())
		    .width(width)
		    .height(height);

		  d3.select("#chart-category-pie svg")
		      .datum([chartdata])
		    .transition().duration(1200)
		      .attr('width', width)
		      .attr('height', height)
		      .call(chart);

		chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });

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
