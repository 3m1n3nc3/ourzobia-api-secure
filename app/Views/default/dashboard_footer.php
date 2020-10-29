
		<!-- REQUIRED SCRIPTS -->
		<!-- jQuery -->
		<script src="<?=base_url('resources/plugins/jquery/jquery.min.js')?>"></script>
		<script src="<?=base_url('resources/js/jquery-ui.min.js')?>"></script>
		<script src="<?=base_url('resources/js/jquery.form.js')?>"></script>
		<script src="<?=base_url('resources/js/custom.components.js')?>"></script> 
		<script src="<?=base_url('resources/plugins/timeago/Livestamp.js')?>"></script> 
		<script src="<?=base_url('resources/plugins/toastr/toastr.min.js')?>"></script>
		<script src="<?=base_url('resources/plugins/plyr/plyr.js')?>"></script>
		<script src="<?=base_url('resources/plugins/chart.js/Chart.js')?>"></script>

		<!-- Date / Time Functions -->
		<script src="<?=base_url('resources/plugins/moment/moment.min.js')?>"></script>
		<script src="<?=base_url('resources/plugins/daterangepicker/daterangepicker.js')?>"></script> 
		
		<!-- Bootstrap 4 -->
		<script src="<?=base_url('resources/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
		<!-- AdminLTE App -->
		<script src="<?=base_url('resources/distr/js/adminlte.min.js')?>"></script>
		<script src="<?=base_url('resources/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
		<!-- button.loader -->
		<script src="<?=base_url('resources/js/button.loader.js')?>"></script>
		<!-- Ponzi -->
		<script src="<?=base_url('resources/plugins/image-uploader/croppie.js')?>"></script>
		<script src="<?=base_url('resources/js/custom.functions.js')?>"></script>
		<script src="<?=base_url('resources/js/custom.scripts.js')?>"></script> 
		<script src="<?=base_url('resources/js/custom.forms.js')?>"></script> 
		<script src="<?=base_url('resources/js/jQuery.dragmove.js')?>"></script> 
		<!-- Plugins -->
		<script src="<?=base_url('resources/distr/js/adminlte.settings.js')?>"></script>
    	<script src="<?=base_url('resources/plugins/jodit/jodit.js'); ?>"></script> 
	    <script src="<?=base_url('resources/plugins/dropzone/dropzone.min.js')?>"></script>

    	<?php if (!empty($show_stats)): ?>
		<script src="<?=base_url('resources/js/dashboard.js')?>"></script>
    	<?php endif ?>

		<!-- Tooltips and toggle Initialization -->
		<script>
			$(function() {
		    	$('[data-toggle="tooltip"]').tooltip(); 
		 
		    	$('[data-toggle="popover"]').popover();

			    // $('div.dragmove').dragmove(); 

	           // Jodit
	            $('.textarea').each(function () { 
	                var editor = new Jodit(this);
	            });

	            $("#get-notifications").click(function(event) {
	                var notf_list = $("#notifications__list");
	                var preloader = notf_list.next('.preloader').clone().removeClass('d-none');
	                notf_list.html(preloader);
	                get_notifications('admin'); 
	                delay(function(){
	                
	                },400); 
	            });  

				$('.countdown_timer').each(function() {
					console.log($(this).data('time'));
					new TimezZ('#' + $(this).attr('id'), {
					  	date: $(this).data('time'),
					  	isStopped: false,
					  	canContinue: false,
					  	template: $(this).data('temp'),
					  	text: { days: 'd', hours: 'h', minutes: 'm', seconds: 's'},
					  	beforeCreate() {},
					  	beforeDestroy() {},
					  	finished() {},
					});
				});

				$('.countdown_timer_alt').each(function() {
					var date = $(this).data('time');
					$('#' + $(this).attr('id')).countdownTimer(date, function() {
					    // End of timer
					}); 
				});

			    // Update and show notifications, requests and message status
			    delay(function(){
			        if (is_logged()) {
			            update_notices('admin', 'default');
			        }
			    },100);
			    
			    $('select[id="colorpicker"]').simplecolorpicker({
			    	'selectColor': $('select[id="colorpicker"]').val(), 
			    	picker: true,
			    	theme: 'fontawesome', 
			    	pickerDelay: 200
			    });

			    $('.datetimepicker').datetimepicker({
				  	format:'Y-m-d H:i:s',
 					mask:true
				});
			});
		</script>

    	<!-- Datatables -->
    <?php if (isset($has_table) && $has_table): ?>
      	<script src="<?php echo base_url('resources/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
      	<script src="<?php echo base_url('resources/plugins/datatables-bs4/js/dataTables.bootstrap4.js'); ?>"></script>
      	<!-- page script -->
	    <script>
	        $(function () {
	        	<?php if (is_array($table_method)): ?>
		        	<?php foreach ($table_method AS $selector => $method): ?>
	          	$('<?=$selector?>').DataTable({  
	              	"scrollX": true,    
	            	"pageLength" : 10,
	            	"serverSide": true,
	            	"order": [[0, "asc" ]],
	            	"ajax":{
	                  	url :  '<?= site_url('ajax/datatables/'.$method); ?>',
	                  	type : 'POST'
	              	},
	              	rowId: 20
	          	}) 
		        	<?php endforeach; ?>
	        	<?php else: ?>
	          	$('#datatables_table, .datatables_table').DataTable({  
	              	"scrollX": true,    
	            	"pageLength" : 10,
	            	"serverSide": true,
	            	"order": [[0, "asc" ]],
	            	"ajax":{
	                  	url :  '<?= site_url('ajax/datatables/'.$table_method); ?>',
	                  	type : 'POST'
	              	},
	              	rowId: 20
	          	}) 
	          	<?php endif ?>
	        })
	    </script>
    <?php endif ?>
    <?php if (my_config('tawk_id')): ?>
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src='https://embed.tawk.to/<?=my_config('tawk_id')?>/default';
				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
			})();
		</script>
		<!--End of Tawk.to Script-->
    <?php endif ?>
