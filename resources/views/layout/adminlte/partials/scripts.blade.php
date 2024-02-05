<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('public/adminlte/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/adminlte/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{asset('public/remodal/dist/remodal.min.js')}}"></script>
<script src="{{ asset('public/adminlte/js/selectize.js') }}" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.4/numeral.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.4.6/mousetrap.min.js" type="text/javascript"></script>
<script>
	// validasi
	function checkUserName(usercheck)
	{
		$('#usercheck').html("<img src='{{asset('public/images/preloades/7.gif')}}'' />");
		$.get("{{url('cekNoResi')}}" + "/" + usercheck , function(data)
			{
					if (data.warning != '' || data.warning != undefined || data.warning != null)
				   {
					  $('#usercheck').html(data.warning);
				   }

				   if (data.status == true){
				   		$('#tambah').prop("disabled",true);
				   }else{
				   		$('#tambah').prop("disabled",false);
				   }
	          });
	}
</script>
<!-- DATA TABES SCRIPT -->
<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
	$(function () {
		$('.dataTable').DataTable();
	});
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('.js-example-basic-single').select2();
	});
</script>
@yield('additional_scripts')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
