@extends('layouts.main')

@section('head_title')Мой расчет@endsection

@section('content')
	<h1>Результат расчета</h1>
	<div class="p-3 mb-2 bg-info text-white">
		<p>Параметры системы:</p>
		<p>Напряжение сети 3Ф/1Ф - {{$initialData['systemVolt']}}кВ</p>
	</div>
	<div class="pt-3 pb-3 mb-2 bg-success text-white row" style="margin-left: 0; margin-right: 0;">
		<div class="col-3 d-inline-block" >
			<p><b>Тип защиты:</b> {{$initialData['typeProtText']}}</p>
			<p><b>Cила тока аппарата защиты:</b> {{$result['amperageProtection']}}A</p>
		</div>
		<div class="col-3 d-inline-block" >
			<p><b>Материал линии:</b> {{$result['lineParams']['material']}} </p>
			<p><b>Кол-во кабелей линии:</b> {{$result['lineParams']['countParalelLine']}} </p>
			<p><b>Номинальный ток 1 кабеля:</b> {{$result['lineParams']['iKabel']}}А </p>
			<p><b>Номинальный ток линии:</b> {{$result['lineParams']['iLine']}}А </p>
			<p><b>Сечение 1 кабеля:</b> {{$result['lineParams']['sLine']}}мм<span class="super">2</span></p>
			<p><b>Длина линии:</b> {{$result['lineParams']['lineLength']}}м</p>
			<p><b>Потеря напряжения:</b> {{$result['lineParams']['voltLoss']}}%</p>
		</div>
		<div class="col-6 d-inline-block" >
			<p><b>Тип оборудования:</b> {{$initialData['typeEOText']}}</p>
			<p><b>Мощность:</b> {{$initialData['power']}}кВт</p>
			<p><b>Расчетная сила тока:</b> {{$result['amperageEO']}}A</p>
		</div>
	</div>
	<pre>
		{{print_r($result)}}
	</pre>
	<p class="text-center">
		<a href="{{ route('calc-form') }}" class="btn btn-primary stretched-link col-10">Новый расчет</a>
	</p>
@endsection