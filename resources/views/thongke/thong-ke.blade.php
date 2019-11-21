@extends('home')


@section('sub-title')
<div class="sub-title">
	<a>Báo cáo</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
  <a>Thống kê</a>
</div>
@endsection


@section('content')
{{ csrf_field() }}

<div class="datatable">
	<div class="form-group form-bangdiem form-getnganh">
		<p>Chọn năm</p>
		<select class="browser-default custom-select select-year-action" id="select-year-action">
			<option>Chọn năm</option>
			@foreach($year as $value )
	    	<option value="{{ $value->year}}">{{ $value->year }}</option>
	     	@endforeach
		</select>
	</div>
	<div class="thongke-1">
		<table class="bangdiem-l">
			<thead>
			<tr>
			      <th>Ngành</th>      
			      <th>Khoa</th>
			      <th>Số lượng</th>
			</tr>
			</thead>
			<tbody id="thongke">
				
			</tbody>
		</table>
	</div>
</div>
<div class="datachart">
	<div id="chartContainer" style="height: 370px; width: 100%; display: none"></div>
	<canvas id="myChart" width="600" height="300" style="height: 400px; width: 100%;" ></canvas>
</div>
@endsection

@section('script')
<script type="text/javascript">
	var array = [];
	var year = new Date().getFullYear();
	dataYear = [year - 3, year - 2, year - 1, year];
	backgroundColor = ['rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'];
	borderColor= ['rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'];
	var barChartData = {
		labels: dataYear,
		datasets : [],
	};
	url = "{{ URL('/getMaKhoa') }}";
	$.get(url,function(data){
		$.each(data, function(i, value){
			array[i] = value.MaKhoa;
	})})
	$(document).ready(function(){
		$('#select-year-action').change(function(){
			var _token = $('input[name="_token"]').val();
			var year = $("#select-year-action option:selected").val();
			$.ajax({
				url: '/thong-ke',
				method: 'POST',
				data: { _token: _token, year: year},
				success:function(data){
					$('#thongke').html(data);
				},
				error:function(xhr, status, error) {
			        console.log(xhr.responseText);
			    },
			})
		})
})
$( function() {
	$(window).on("load", function() {
		var ctx = document.getElementById("myChart").getContext('2d');
		var barGraph = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
		    	responsive: true,
				legend: {
					position: 'top',
					labels: {
						fontSize: 18,
						fontFamily: 'Roboto',
					}
				}
				,
				title: {
					display: true,
					text: 'Thống kê tốt nghiệp các năm',
					fontSize: 20,
				},
		    }
		});
		for(let j = 0; j < array.length; j++){
				var data = [];
				var url = "/thong-ke/khoa/"+array[j];
				$.get(url, function(data){
					$.each(data, function(i, value){
						//console.log("each "+i+" "+value.year);
						for(let a = 0; a < dataYear.length; a++){
							if(value.year == dataYear[a]){
								data[a] = value.count;
								//console.log("for "+a+" "+data[a]);
							}
						}
					});
					var newDataset = {
						label: array[j],
						backgroundColor: backgroundColor[j],
						borderColor: backgroundColor[j],
						borderWidth: 1,
						data: data,
					};
					var len = barChartData.datasets.length;
					barChartData.datasets[len] = newDataset;
					barGraph.update();
				})
			}	
	});
})
</script>
@endsection