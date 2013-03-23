
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

$('.category').click(function(event) {
    var productId = $('#voteProductName').data('productid'),
        categoryId = $(this).data('categoryid');

    $.get('dashboard/vote?productid=' + productId + '&categoryid=' + categoryId);

    refreshCategoryVoteProduct();
});

function refreshCategoryVoteProduct() {
    $.get('dashboard/getCategoryVoteData', function(data) {
        $('#voteProductName').data('productid', data.product.id).text(data.product.name);

        $('#categorySuggestion1 h5').data('categoryid', data.categories[0].id).text(data.categories[0].name);
        $('#categorySuggestion2 h5').data('categoryid', data.categories[1].id).text(data.categories[1].name);
        $('#categorySuggestion3 h5').data('categoryid', data.categories[2].id).text(data.categories[2].name);
    });
}

refreshCategoryVoteProduct();
