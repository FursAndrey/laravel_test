@extends('layouts.main')

@section('head_title')Мой расчет@endsection

@section('content')
	<h1>Результат расчета</h1>
	<div class="p-3 mb-2 bg-info text-white">
		<p>Параметры системы:</p>
		<p>Напряжение сети 3Ф/1Ф - {{$result['systemData']['systemVolt']}}кВ</p>
	</div>
	@foreach ($result['initialData'] AS $numOfEo => $dataThisEo)
	<div class="pt-3 pb-3 mb-2 ml-0 mr-0 bg-success text-white row">
		<div class="col-3 d-inline-block" >
			<p>
				<b>Тип защиты:</b> 
				{{$result['initialData'][$numOfEo]['typeProtText']}}
			</p>
			<p>
				<b>Cила тока аппарата защиты:</b> 
				{{$result['calcResult'][$numOfEo]['amperageProtection']}}A
			</p>
		</div>
		<div class="col-3 d-inline-block" >
			<!--p>
				<b>Материал линии:</b> {{$result['calcResult'][$numOfEo]['lineParams']['material']}} 
			</p-->
			<!--p>
				<b>Номинальный ток 1 кабеля:</b> 
				{{$result['calcResult'][$numOfEo]['lineParams']['iKabel']}}А
			</p-->
			<p>
				<b>Номинальный ток линии:</b> 
				{{$result['calcResult'][$numOfEo]['lineParams']['iLine']}}А
			</p>
			<p>
				<b>Сечение линии:</b> 
				{{$result['calcResult'][$numOfEo]['lineParams']['countParalelLine']}} x
				{{$result['calcResult'][$numOfEo]['lineParams']['sLine']}}мм<span class="super">2</span>
			</p>
			<!--p>
				<b>Кол-во кабелей линии:</b>
				{{$result['calcResult'][$numOfEo]['lineParams']['countParalelLine']}}
			</p>
			<p>
				<b>Сечение 1 кабеля:</b> 
				{{$result['calcResult'][$numOfEo]['lineParams']['sLine']}}мм<span class="super">2</span>
			</p-->
			<p>
				<b>Длина линии:</b> 
				{{$result['calcResult'][$numOfEo]['lineParams']['lineLength']}}м
			</p>
			<!--p>
				<b>Потеря напряжения:</b>
				{{$result['calcResult'][$numOfEo]['lineParams']['voltLoss']}}%
			</p-->
		</div>
		<div class="col-6 d-inline-block" >
			<p><b>Тип оборудования:</b> {{$result['initialData'][$numOfEo]['typeEOText']}}</p>
			<p><b>Мощность:</b> {{$result['initialData'][$numOfEo]['power']}}кВт</p>
			<p><b>Расчетная сила тока:</b> {{$result['calcResult'][$numOfEo]['amperageEO']}}A</p>
		</div>
	</div>
	@endforeach
	<!--pre>
		{{print_r($result['calcResult'])}}
	</pre-->
	<p class="text-center">
		<a href="{{ route('calc-form') }}" class="btn btn-primary stretched-link col-10">Новый расчет</a>
	</p>
@endsection