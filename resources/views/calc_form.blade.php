@extends('layouts.main')

@section('head_title')Мой расчет@endsection

@section('content')
	<h1>Форма для расчета</h1>

	<form method="post" action="{{ route('calc-start') }}">
		@if($errors->any())
			<div class="alert alert-danger">
				<ol>
					@foreach ($errors->all() AS $error)
					<li>{{ $error }}</li>
					@endforeach
				</ol>
			</div>
		@endif
		<div class="form-group">
			<label for="power">Введите мощность оборудования</label>
			<input type="text" name="power" id="power" class="form-control mb-1">
			<p>Выберите тип оборудования</p>
			<select name="typeEO" id="typeEO" class="form-control mb-1">
				@foreach ($typesEO AS $id => $typeEO)
					<option value="{{$id}}">{{($typeEO)}}</option>
				@endforeach
			</select>
			<p>Выберите тип защиты</p>
			<select name="typeProt" id="typeProt" class="form-control mb-1">
				@foreach ($typeProt AS $id => $prot)
					<option value="{{$id}}">{{($prot)}}</option>
				@endforeach
			</select>
			<p>Выберите материал линии</p>
			<select name="material" id="material" class="form-control mb-1">
				<option value="Cu">Медь</option>
				<option value="Al">Аллюминий</option>
			</select>
			<button type="submit" class="btn btn-success mt-3">Рассчитать</button>
			@csrf
		</div>
	</form>
@endsection