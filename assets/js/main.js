$(function(){

	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function(){
    	drawChart('SC-BTC', 24*60, 24*60);
    });
    google.charts.setOnLoadCallback(function(){
    	drawChart('LSK-PLN', 24*60, 24*60);
    });



	function drawChart(pair, minutes, granularity) {

		var arr = [];
		var granularity = 10*60;
		var minutes = 60*60;

		$.get({
			url: '../api/history/'+pair+'/'+minutes+'/'+granularity,
			success: function(response) {

				$.each(response ,function(index, value){
					var d = new Date(value[0]*1000);
					arr[index] = [d, Number(value[1]), Number(value[3]), Number(value[4]), Number(value[2])];
					// console.log(arr[index]);
				});

			}
		}).done(function(){

			var data = google.visualization.arrayToDataTable(arr, true);
		    var options = {
		      legend:'none',
		      height: 800,
		      width: 1800,
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
		  				console.log(carouselItem.find('.car-bid').find('var').text());

		  				carouselItem.find('.car-bid').find('var').text(currencies['bid']);
	  				
		  				carouselItem.find('.car-ask').find('var').text(currencies['ask']);
		  				
		  				carouselItem.find('.car-high').find('var').text(currencies['high']);
		  				
		  				carouselItem.find('.car-low').find('var').text(currencies['low']);
		  				
		  				carouselItem.find('.car-price').find('var').text(currencies['price']);
		  				
		  				carouselItem.find('.car-volume').find('var').text(currencies['volume']);
		  				
		  				carouselItem.find('.car-balance').find('var').text(currencies['balance']);
		  				
		  				carouselItem.find('.car-balance_btc').find('var').text(currencies['balance_btc']);
	  				}
	  				

	  				

	  			});


	  		});

		});
	}

	setInterval(function(){
	    updateData()}, 10*1000)




});