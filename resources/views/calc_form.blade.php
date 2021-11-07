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
			<? 
			if (!is_null(old('calc'))) $old = old('calc');
			else $old = ['0' => []];
			?>
			@foreach ($old AS $numEO => $oldEO)
				<?
				if (!$oldEO) {
					$oldEO['power'] = '';
					$oldEO['typeEO'] = 0;
					$oldEO['typeProt'] = 1;
					$oldEO['material'] = 'Cu';
					$oldEO['lineLength'] = '';
				}
				?>
			<div class="for-copy border rounded border-success p-3 mb-2">
				<p class="d-flex justify-content-between mb-1">
					<label for="power_0" class="col-3">Мощность оборудования</label>
					<input type="text" name="calc[{{$numEO}}][power]" id="power_0" 
						class="form-control col-9" value="{{($oldEO['power'] == '')? '': $oldEO['power']}}">
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeEO_0" class="col-3">Тип оборудования</label>
					<select name="calc[{{$numEO}}][typeEO]" id="typeEO_0" class="form-control col-9">
						@foreach ($typesEO AS $id => $typeEO)
							<option value="{{$id}}" <?=($id == $oldEO['typeEO'])? 'selected': ''?>>
								{{$typeEO}}
							</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="typeProt_0" class="col-3">Тип защиты</label>
					<select name="calc[{{$numEO}}][typeProt]" id="typeProt_0" class="form-control col-9">
						@foreach ($typeProt AS $id => $prot)
							<option value="{{$id}}" <?=($id == $oldEO['typeProt'])? 'selected': ''?>>
								{{$prot}}
							</option>
						@endforeach
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="material_0" class="col-3">Материал линии</label>
					<select name="calc[{{$numEO}}][material]" id="material_0" class="form-control col-9">
						<option value="Cu" <?=("Cu" == $oldEO['material'])? 'selected': ''?>>
							Медь
						</option>
						<option value="Al" <?=("Al" == $oldEO['material'])? 'selected': ''?>>
							Аллюминий
						</option>
					</select>
				</p>
				<p class="d-flex justify-content-between mb-1">
					<label for="lineLength_0" class="col-3">Длина линии</label>
					<input type="text" name="calc[{{$numEO}}][lineLength]" id="lineLength_0" 
						class="form-control col-9" 
						value="{{($oldEO['lineLength'] == '')? '': $oldEO['lineLength']}}">
				</p>
			</div>
			@endforeach
			<button type="submit" class="btn btn-success mt-3">Рассчитать</button>
			@csrf
		</div>
	</form>
@endsection