@extends('layouts.main')

@section('head_title')Мой расчет@endsection

@section('content')
	<h1>Результат расчета</h1>
	<div class="p-3 mb-2 bg-info text-white">
		<p>Параметры системы:</p>
		<p>Напряжение сети 3Ф/1Ф - {{$result['systemData']['systemVolt']}}кВ</p>
	</div>
	<table border="1" class="mb-2">
	@foreach ($result['initialData'] AS $numOfEo => $dataThisEo)
		<tr class="pt-3 pb-3 mb-2 ml-0 mr-0 bg-success text-white">
			@if($numOfEo == 0)
			<td class="col-2 bg-secondary" rowspan="{{count($result['initialData'])}}">
				<p>
					<b>Общие</b>
				</p>
				<p>
					<b>Мощность:</b>
					{{$result['general']}}кВт
				</p>
			</td>
			@endif
			<td class="col-3">
				<p>
					<b>Тип защиты:</b>
					{{$result['initialData'][$numOfEo]['typeProtText']}}
				</p>
				<p>
					<b>Cила тока аппарата защиты:</b>
					{{$result['calcResult'][$numOfEo]['amperageProtection']}}A
				</p>
			</td>
			<td class="col-3">
				<p>
					<b>Номинальный ток линии:</b>
					{{$result['calcResult'][$numOfEo]['lineParams']['iLine']}}А
				</p>
				<p>
					<b>Сечение линии:</b>
					{{$result['calcResult'][$numOfEo]['lineParams']['countParalelLine']}} x
					{{$result['calcResult'][$numOfEo]['lineParams']['sLine']}}мм
					<span class="super">2</span>
				</p>
				<p>
					<b>Длина линии:</b>
					{{$result['calcResult'][$numOfEo]['lineParams']['lineLength']}}м
				</p>
			</td>
			<td class="col-4">
				<p><b>Тип оборудования:</b> {{$result['initialData'][$numOfEo]['typeEOText']}}</p>
				<p><b>Мощность:</b> {{$result['initialData'][$numOfEo]['power']}}кВт</p>
				<p><b>Расчетная сила тока:</b> {{$result['calcResult'][$numOfEo]['amperageEO']}}A</p>
			</td>
		</tr>
	@endforeach
	</table>
	<!--pre>
		{{print_r($result['calcResult'])}}
	</pre-->
	<p class="text-center">
		<a href="{{ route('calc-form') }}" class="btn btn-primary stretched-link col-10">Новый расчет</a>
	</p>
@endsection