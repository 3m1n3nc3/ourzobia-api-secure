$(function() {
  	'use strict'

	var ticksStyle = {
	    fontColor: '#495057',
	    fontStyle: 'bold'
	}

	// Recent Registrations 
  	var users_label = [];
  	var users_data = []; 

	for(var i in users_data_set) {
	    users_label.push(users_data_set[i].label);
	    users_data.push(users_data_set[i].data); 
	}   

	// Recent Visitors 
  	var visitors_label = [];
  	var visitors_data = []; 

	for(var i in visitors_data_set) {
	    visitors_label.push(visitors_data_set[i].label);
	    visitors_data.push(visitors_data_set[i].data); 
	} 

	// Recent Activation 
  	var activation_label = [];
  	var activation_data = []; 

	for(var i in activation_data_set) {
	    activation_label.push(activation_data_set[i].label);
	    activation_data.push(activation_data_set[i].data); 
	} 

	// Recent Validations 
  	var validation_label = [];
  	var validation_data = []; 

	for(var i in validation_data_set) {
	    validation_label.push(validation_data_set[i].label);
	    validation_data.push(validation_data_set[i].data); 
	}    

	var set_options = {
	  	maintainAspectRatio: false,
	  	tooltips           : {
	        mode     : 'index',
	        intersect: true
	  	}, 
	  	legend             : {
	    	display: false
	  	},
	  	scales             : {
	    	yAxes: [{
		          // display: false,
		        gridLines: {
		            display      : true,
		            lineWidth    : '4px',
		            color        : 'rgba(0, 0, 0, .2)',
		            zeroLineColor: 'transparent'
	          	},
	          	ticks    : $.extend({
		            beginAtZero : true,
		            suggestedMax: 100
	          	}, ticksStyle)
	    	}],
	        xAxes: [{
	          	display  : true,
	          	gridLines: {
	            	display: false
	          	},
	          	ticks    : ticksStyle
	        }]
	  	}
	}
 
	// Recent Registrations
  	var $visitorsChart = $('#recent-reg-chart')  
  	if (typeof $visitorsChart !== "undefined" && $visitorsChart.length >= 1) { 
	  	var visitorsChart  = new Chart($visitorsChart, {
		    data   : {
		      	labels  : users_label,
		      	datasets: [{
			        type                : 'line',
			        data                : users_data,
			        backgroundColor     : 'transparent',
			        borderColor         : '#007bff',
			        pointBorderColor    : '#007bff',
			        pointBackgroundColor: '#007bff',
			        fill                : false 
		      	}]
		    },
		    options: set_options
	  	}) 
 	}

	// Recent Visitors
  	var $visitorsChart = $('#monthly-visitors-chart')
  	if (typeof $visitorsChart !== "undefined" && $visitorsChart.length >= 1) { 
	  	var visitorsChart  = new Chart($visitorsChart, {
		    data   : {
		      	labels  : visitors_label,
		      	datasets: [{
			        type                : 'line',
			        data                : visitors_data,
			        backgroundColor     : 'transparent',
			        borderColor         : '#007bff',
			        pointBorderColor    : '#007bff',
			        pointBackgroundColor: '#007bff',
			        fill                : false 
		      	}]
		    },
		    options: set_options
	  	}) 
	}
 
	// Recent Activations
  	var $visitorsChart = $('#monthly-activation-chart')
  	if (typeof $visitorsChart !== "undefined" && $visitorsChart.length >= 1) { 
	  	var visitorsChart  = new Chart($visitorsChart, {
		    data   : {
		      	labels  : activation_label,
		      	datasets: [{
			        type                : 'line',
			        data                : activation_data,
			        backgroundColor     : 'transparent',
			        borderColor         : '#007bff',
			        pointBorderColor    : '#007bff',
			        pointBackgroundColor: '#007bff',
			        fill                : false 
		      	}]
		    },
		    options: set_options
	  	}) 
	}
 
	// Recent Validations
  	var $visitorsChart = $('#monthly-validation-chart')
  	if (typeof $visitorsChart !== "undefined" && $visitorsChart.length >= 1) { 
	  	var visitorsChart  = new Chart($visitorsChart, {
		    data   : {
		      	labels  : validation_label,
		      	datasets: [{
			        type                : 'line',
			        data                : validation_data,
			        backgroundColor     : 'transparent',
			        borderColor         : '#007bff',
			        pointBorderColor    : '#007bff',
			        pointBackgroundColor: '#007bff',
			        fill                : false 
		      	}]
		    },
		    options: set_options
	  	}) 
	}
  	
  	$('.daterange').daterangepicker({
    	ranges   : {
      		'Today'       : [moment(), moment()],
      		'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      		'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
      		'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      		'This Month'  : [moment().startOf('month'), moment().endOf('month')],
      		'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    	},
    	startDate: moment().subtract(29, 'days'),
    	endDate  : moment()
  	}, function (start, end) {
  		const range = start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD');

	  	$('.daterange').on("apply.daterangepicker", function (e) {
  			redirect("dashboard?range="+range+"&chart="+$(e.target).data('chart'));
	  	})
  	})
})