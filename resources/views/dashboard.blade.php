@extends('principal')
@section('contenido')
<main class="main">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<a href="/">BACKEND-SISTEMA DE COMPRAS-VENTAS</a>
		</li>
	</ol>
	<div class="container-fluid">
		@foreach($totales as $total)
		<div class="row">
			<div class="col-lg-6 col-xs-6">
				<div class="card text-white bg-success">
					<div class="card-body pb-0">
						<button class="btn btn-transparent p-0 float-right" type="button">
							<i class="fa fa-shopping-cart fa-4x"></i>
						</button>
						<div class="text-value h2"><strong>USD {{$total->totalcompra}} (MES ACTUAL)</strong></div>
						<div class="h2">Compras</div>
					</div>
					<div class="chart-wrapper mt-3 mx-3" style="height:35px;">
						<a href="{{url('compra')}}" class="small-box-footer h4">Compras <i class="fa fa-arrow-circle-right"></i></a>
					</div>					
				</div>
			</div>

			<div class="col-lg-6 col-xs-6">
				<!-- small box -->
				<div class="card text-white bg-warning">
					<div class="card-body pb-0">
						<button class="btn btn-transparent p-0 float-right" type="button">
							<i class="fa fa-suitcase fa-4x"></i>
						</button>
						<div class="text-value h2"><strong>USD {{$total->totalventa}} (MES ACTUAL) </strong></div>
						<div class="h2">Ventas</div>
					</div>
					<div class="chart-wrapper mt-3 mx-3" style="height:35px;">
						<a href="{{url('venta')}}" class="small-box-footer h4">Ventas <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		@endforeach

		<div class="row">
			<div class="col-md-6">

				<div class="card card-chart">
					<div class="card-header">
						<h4 class="text-center">Compras - Meses</h4>
					</div>
					<div class="card-content">
						<div class="ct-chart">
							<canvas id="compras">                                                
							</canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card card-chart">
					<div class="card-header">
						<h4 class="text-center">Ventas - Meses</h4>
					</div>
					<div class="card-content">
						<div class="ct-chart">
							<canvas id="ventas">                                                
							</canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		@push('scripts')
		<script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>
		<script type="text/javascript">
			var varCompra = document.getElementById('compras').getContext('2d');
			var charCompra = new Chart(varCompra, {
				type: 'line',
				data: {
					labels: [<?php foreach ($comprasmes as $comprames) {
						setlocale(LC_TIME, 'es_Es', 'Spanish_Spain', 'Spanish');
						$mes_traducido = strftime('%B', strtotime($comprames->mes));
						echo '"'.$mes_traducido.'",';
					} ?>],
					datasets: [{
						label: 'Compras',
						data: [<?php foreach ($comprasmes as $comprames) {
							echo ''.$comprames->totalmes.',';
						} ?>],
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 3
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});

			var varVenta = document.getElementById('ventas').getContext('2d');
			var charVenta = new Chart(varVenta, {
				type: 'bar',
				data: {
					labels: [<?php foreach ($ventasmes as $ventames) {
						setlocale(LC_TIME, 'es_Es', 'Spanish_Spain', 'Spanish');
						$mes_traducido = strftime('%B', strtotime($ventames->mes));
						echo '"'.$mes_traducido.'",';
					} ?>],
					datasets: [{
						label: 'Ventas',
						data: [<?php foreach ($ventasmes as $ventames) {
							echo ''.$ventames->totalmes.',';
						} ?>],
						backgroundColor: 'rgba(20, 204, 20 ,1)',
						borderColor: 'rgba(54, 162, 235, 0.2)',
						borderWith: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		</script>
		@endpush
	</div>
</main>
@endsection