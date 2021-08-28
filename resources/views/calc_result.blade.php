@extends('layouts.main')

@section('head_title')Мой расчет@endsection

@section('content')
	<h1>Результат расчета</h1>
	<div class="p-3 mb-2 bg-info text-white">
		<p>Параметры системы:</p>
		<p>Напряжение сети 3Ф/1Ф - {{$systemData}}кВ</p>
	</div>
	<div class="p-3 mb-2 bg-info text-white">
		<p>Исходные данные:</p>
		<p>Мощность - {{$initialData['power']}}кВт</p>
		<p>Тип оборудования - {{$initialData['typeEO']}}</p>
		<p>Тип защиты - {{$initialData['typeProt']}}</p>
	</div>
	<div class="p-3 mb-2 bg-success text-white">
		<p>Результат:</p>
		<p>Расчетная сила тока - {{$result['amperageEO']}}A</p>
		<p>Cила тока аппарата защиты - {{$result['amperageProtection']}}A</p>
	</div>
	<!--pre>
		{{print_r($result)}}
	</pre-->
	<p class="text-center">
		<a href="{{ route('calc-form') }}" class="btn btn-primary stretched-link col-10">Новый расчет</a>
	</p>
@endsection