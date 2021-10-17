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
			<div class="for-copy border rounded border-success p-3 mb-2">
				<p class="d-flex justify-content-between mb-1">
					<label for="power_0" class="col-3">Мощность оборудования</label>
					<input type="text" name="calc[0][power]" id="power_0" class="form-control col-9">
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeEO_0" class="col-3">Тип оборудования</label>
					<select name="calc[0][typeEO]" id="typeEO_0" class="form-control col-9">
						@foreach ($typesEO AS $id => $typeEO)
							<option value="{{$id}}">{{($typeEO)}}</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeProt_0" class="col-3">Тип защиты</label>
					<select name="calc[0][typeProt]" id="typeProt_0" class="form-control col-9">
						@foreach ($typeProt AS $id => $prot)
							<option value="{{$id}}">{{($prot)}}</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="material_0" class="col-3">Материал линии</label>
					<select name="calc[0][material]" id="material_0" class="form-control col-9">
						<option value="Cu">Медь</option>
						<option value="Al">Аллюминий</option>
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="lineLength_0" class="col-3">Длина линии</label>
					<input type="text" name="calc[0][lineLength]" id="lineLength_0" class="form-control col-9">
				</p>
			</div>
			<button type="submit" class="btn btn-success mt-3">Рассчитать</button>
			@csrf
		</div>
	</form>
@endsection