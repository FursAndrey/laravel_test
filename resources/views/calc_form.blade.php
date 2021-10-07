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
			<div class="for-copy border rounded border-success p-3">
				<p class="d-flex justify-content-between mb-1">
					<label for="power" class="col-3">Введите мощность оборудования</label>
					<input type="text" name="power" id="power" class="form-control col-9">
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeEO" class="col-3">Выберите тип оборудования</label>
					<select name="typeEO" id="typeEO" class="form-control col-9">
						@foreach ($typesEO AS $id => $typeEO)
							<option value="{{$id}}">{{($typeEO)}}</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeProt" class="col-3">Выберите тип защиты</label>
					<select name="typeProt" id="typeProt" class="form-control col-9">
						@foreach ($typeProt AS $id => $prot)
							<option value="{{$id}}">{{($prot)}}</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="material" class="col-3">Выберите материал линии</label>
					<select name="material" id="material" class="form-control col-9">
						<option value="Cu">Медь</option>
						<option value="Al">Аллюминий</option>
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="lineLength" class="col-3">Введите длину линии</label>
					<input type="text" name="lineLength" id="lineLength" class="form-control col-9">
				</p>
			</div>
			<button type="submit" class="btn btn-success mt-3">Рассчитать</button>
			@csrf
		</div>
	</form>
@endsection