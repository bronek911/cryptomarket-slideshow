$(function(){

	google.charts.load('current', {'packages':['corechart']});
    // google.charts.setOnLoadCallback(function(){
    // 	drawChart('SC-BTC', 24*60, 24*60);
    // });
    google.charts.setOnLoadCallback(function(){
    	drawChart('ETH-PLN');
    });

	function drawChart(pair) {

		var arr = [];
		var granularity = 10*60;
		var minutes = 60*60;

		console.log('drawChart()');

		$.get({
			url: '../index.php/api/history/'+pair+'/'+minutes+'/'+granularity,
			success: function(response) {

				$.each(response ,function(index, value){
					var d = new Date(value[0]*1000);
					arr[index] = [d, Number(value[1]), Number(value[3]), Number(value[4]), Number(value[2])];
					// console.log(arr[index]);
				});

			}
		}).done(function(){

			var data = google.visualization.arrayToDataTable(arr, true);
			var docHeight = (80 * $(document).height()) / 100;
			var docWidth = (100 * $(document).width()) / 100;
		    var options = {
		      legend:'none',
		      height: docHeight,
		      width: docWidth,
		    };

		    var chart = new google.visualization.CandlestickChart(document.getElementById(pair));
		    chart.draw(data, options);
		});
	}

	function updateData(){

	    $.getJSON( "../api/wallet", function( data ) {
	  		$.each(data, function(index, value){
	  			var currencies = data[index];
	  			var carouselItems = $('.carousel-item').children();

	  			$.each(carouselItems, function(){
	  				var carouselItem = $(this).parent();
	  				var carouselItemCode = carouselItem.data('code');

	  				if(carouselItemCode == currencies['code']){
		  				console.log(carouselItemCode);
		  				console.log(currencies);
		  				console.log(currencies['code']+': '+currencies['price']);
		  				console.log(currencies['last']);
		  				console.log(carouselItem.find('.car-bid').find('var').text());

		  				// carouselItem.find('.car-last').find('var').text(currencies['last']);
		  				carouselItem.find('.car-bid').find('var').text(currencies['bid']);
		  				carouselItem.find('.car-ask').find('var').text(currencies['ask']);
		  				carouselItem.find('.car-high').find('var').text(currencies['high']);
		  				carouselItem.find('.car-low').find('var').text(currencies['low']);
		  				carouselItem.find('.car-last').find('var').text(currencies['price']);
		  				carouselItem.find('.car-volume').find('var').text(Number(currencies['volume']).toFixed(2));
		  				carouselItem.find('.car-balance').find('var').text(currencies['balance']);
		  				carouselItem.find('.car-balance-btc').find('var').text(currencies['balance_btc']);
	  				}
	  			});
	  		});
		});
	}

	setInterval(function(){
	    updateData()}, 60*1000)

	setInterval(function(){
	    drawChart('ETH-PLN')}, 10*60*1000)

});