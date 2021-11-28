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
		<button type="button" id="add_next_eo" class="btn btn-info mb-1">Добавить</button>
		<?
		$old = old();
		if ($old != []) {
			$arr_power = $old['power'];
			$arr_type_eo = $old['typeEO'];
			$arr_type_prot = $old['typeProt'];
			$arr_material = $old['material'];
			$arr_line_length = $old['lineLength'];
		} else {
			$arr_power = ['0'=>''];
			$arr_type_eo = ['0'=>''];
			$arr_type_prot = ['0'=>''];
			$arr_material = ['0'=>''];
			$arr_line_length = ['0'=>''];
		}
		?>
		<div class="form-group">
			@foreach ($arr_power AS $id_eo => $power)
			<div class="for-copy border rounded border-success p-2 mb-1">
				<p class="d-flex justify-content-between mb-1">
					<label for="power_{{ $id_eo }}" class="col-3">Мощность</label>
					<input type="text" name="power[]" id="power_{{ $id_eo }}" 
						class="form-control col-9 change-id" value="{{ $arr_power[$id_eo] }}">
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeEO_{{ $id_eo }}" class="col-3">Тип оборудования</label>
					<select name="typeEO[]" id="typeEO_{{ $id_eo }}" class="form-control col-9 change-id">
						@foreach ($typesEO AS $id => $typeEO)
							<option value="{{$id}}" <?=($id==$arr_type_eo[$id_eo])?'selected':''?>>
								{{ $typeEO }}
							</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeProt_{{ $id_eo }}" class="col-3">Тип защиты</label>
					<select name="typeProt[]" id="typeProt_{{ $id_eo }}" 
						class="form-control col-9 change-id">
						@foreach ($typeProt AS $id => $prot)
							<option value="{{$id}}" <?=($id==$arr_type_prot[$id_eo])?'selected':''?>>
								{{ $prot }}
							</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="material_{{ $id_eo }}" class="col-3">Материал линии</label>
					<select name="material[]" id="material_{{ $id_eo }}" 
						class="form-control col-9 change-id">
						<option value="Cu" <?=('Cu'==$arr_type_prot[$id_eo])?'selected':''?>>
							Медь
						</option>
						<option value="Al" <?=('Al'==$arr_type_prot[$id_eo])?'selected':''?>>
							Аллюминий
						</option>
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="lineLength_{{ $id_eo }}" class="col-3">Длина линии</label>
					<input type="text" name="lineLength[]" id="lineLength_{{ $id_eo }}" 
						class="form-control col-9 change-id" value="{{ $arr_line_length[$id_eo] }}">
				</p>
			</div>
			@endforeach
			<button type="submit" class="btn btn-success">Рассчитать</button>
			@csrf
		</div>
	</form>
@endsection