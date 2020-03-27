
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inventaris Sarana dan Prasarana</title>
	<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
	@if($it)
	<div class="container">
		<table>
			<tr>
				<td>
					<img src="{{ asset('img/logo_wikrama.png')}}" width="90" height="90" alt="">
				</td>
				<td>
					<h5><b>SMK WIKRAMA BOGOR</b></h5>
					Jl. Raya Wangun Kel. Sindangsari Kec. Bogor Timur
					<span>Telp/Fax.(0251) 8242411</span>
					<br>
						<span>E-mail:<a>prohumasi@smkwikrama.net</a></span>
				</td>
			</tr>
		</table>
		<hr>
		<br>
		<table>
			<tr>
				<th>No Ruangan</th>
				<td>:</td>
				<td>{{ $it[0]->roomItem->room->room}}</td>
			</tr>
			<tr>
				<th>Penanggung Jawab Ruangan</th>
				<td>:</td>
				<td>{{ $it[0]->roomItem->room->user->name}}</td>
			</tr>
		</table>
		<br>

		<div class="table-responsive table-bordered">
			<table class="table" >
				<thead>
					<tr>
						<th rowspan="2" class="text-center">No</th>
						<th rowspan="2" class="text-center">Nama</th>
						<th rowspan="2" class="text-center">Satuan</th>
						<th colspan="2" class="text-center">Kondisi</th>
						<th rowspan="2" class="text-center">Total</th>
					</tr>
					<tr>
						<th>Baik</th>
						<th>Rusak</th>
					</tr>
				</thead>
				<tbody>
					@php $no = 1; $total = 0; $total_rusak = 0; @endphp
					@foreach($it as $a)
					<tr>
						<td>{{ $no++}}</td>
						<td>{{ $a->item }}</td>
						<td>{{ $a->satuan->satuan }}</td>
						<td>{{ $a->roomitem->total }}</td>
						@if($a->roomitem->total_rusak == "")
						@php $a->roomitem->total_rusak = 0; @endphp
						@endif
						<td>{{ $a->roomitem->total_rusak }}</td>
						<td>{{ $a->roomItem->total + $a->roomitem->total_rusak }}</td>
					</tr>
					@php $total = $total +  $a->roomitem->total; $total_rusak = $total_rusak + $a->roomitem->total_rusak; @endphp;
					@endforeach
					<tr>
						<td colspan="3" class="text-center">Total</td>
						<td>{{$total}}</td>
						<td>{{  $total_rusak }}</td>
						<td>{{ $total + $total_rusak }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	@else

		<h1 class="text-center">Belum Ada Laporan</h1>

	@endif
</body>
<script>

</script>
</html>
