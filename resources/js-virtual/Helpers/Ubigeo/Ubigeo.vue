<template>
	<div class="form-row">
		<div class="form-group col-sm-12 col-md-4">
			<label for="Departamento">Departamento :</label>
			<div class="input-group input-group-primary input-group-sm">
				<span class="input-group-prepend">
					<label class="input-group-text">
						<i class="fal fa-map-marker-alt"></i>
					</label>
				</span>
				<select required name="select" v-model="departamento" @change="changeDepartamento($event)" class="form-control">
                    <option :value="null">Seleccione...</option>
                    <option :value="departamento.id" v-for="departamento in listDepartamentos">
                        {{ departamento.name }}
                    </option>
                </select>
			</div>
		</div>
		<div class="form-group col-sm-12 col-md-4">
			<label for="Provincia">Provincia :</label>
			<div class="input-group input-group-primary input-group-sm">
				<span class="input-group-prepend">
					<label class="input-group-text">
						<i class="fal fa-map-marker-alt"></i>
					</label>
				</span>
				<select required name="select" v-model="provincia" @change="changeProvincia($event)" class="form-control">
                    <option :value="null">Seleccione...</option>
                    <option :value="provincia.id" v-for="provincia in listProvincias">
                        {{ provincia.name }}
                    </option>
                </select>
			</div>
		</div>
		<div class="form-group col-sm-12 col-md-4">
			<label for="Distrito">Distrito :</label>
			<div class="input-group input-group-primary input-group-sm">
				<span class="input-group-prepend">
					<label class="input-group-text">
						<i class="fal fa-map-marker-alt"></i>
					</label>
				</span>
				<select required name="select" v-model="distrito" class="form-control">
                    <option :value="null">Seleccione...</option>
                    <option :value="item.id"  v-for="item in listDistritos">
                        {{ item.name }}
                    </option>
                </select>
			</div>
		</div>							
	</div>
</template>

<script src="@/Helpers/Ubigeo/Ubigeo.js"></script>