<template>
	<div>
		<SfLoader v-if="procesando"></SfLoader>
		<div class="modal fade" id="modalFormTypeDocument" tabindex="-1" role="dialog">
	        <div class="modal-dialog modal-sm" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title">
	                    	<i class="fad fa-file-alt mr-2"></i>
	                    	{{ titleModal }} tipo de documento
	                    </h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <form autocomplete="off">
	                	<div class="modal-body scrollable" id="scrollStyle">
							<div class="form-row">
								<div class="form-group col-sm-12">
									<label for="nombre">Nombre :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-file-alt"></i>
											</label>
										</span>
										<input v-model="nombre" required type="text" class="form-control text-uppercase" :readonly="isView" id="nombre" placeholder="Nombres">
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label for="abreviado">Abreviado :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="far fa-text"></i>
											</label>
										</span>
										<input v-model="abreviado" required type="text" class="form-control text-uppercase" :readonly="isView" id="abreviado" placeholder="abreviado">
									</div>
								</div>
							</div>
						</div>
					</form>

					<div class="modal-footer">
						<button  class="btn btn-outline-danger" data-dismiss="modal" type="button" >
							<i class="fal fa-times-circle mr-2"></i>
							Salir
						</button>
						<button v-if="accion == 1" class="btn btn-primary" @click="sendForm()" >
							<i class="fal fa-paper-plane"></i>
							Enviar
						</button>
						<button v-if="accion == 2" class="btn btn-primary" @click="sendForm()" >
							<i class="fal fa-paper-plane"></i>
							Actualizar
						</button>
					</div>

				</div>
			</div>
		</div>

		<div class="card" >
			<div class="card-header p-3">
				<h4 class="user-select-none">
					<i class="fad fa-file-alt mr-2"></i>
          GESTIÓN DE TIPOS DE DOCUMENTO
				</h4>
				<div class="card-header-right mr-0 align-middle">
					<button
					class="btn btn-primary"
					@click="modalShowFormNewUser">
						<i class="fas fa-plus-circle"></i>
						Nuevo Registro
					</button>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<form class="form-inline">
							<div class="form-group mx-sm-3 mb-2">
								<label for="inputPassword2" class="">Mostrar</label>
								<select v-model="nroPorPagina" class="form-control mx-2">
									<option value="5">5</option>
									<option value="10">10</option>
									<option value="20">20</option>
								</select>
								<label for="inputPassword2" class="">registros</label>
							</div>

						</form>
					</div>
					<div class="col">
						<div class="row">
							<div class="form-group col">
								<div class="input-group">
									<span class="input-group-prepend">
										<label class="input-group-text">Buscar por: </label>
									</span>
									<select id="searchBy" class="form-control" v-model="searchBy">
										<option value=""> Seleccione.. </option>
										<option value="nombre">Nombre</option>
										<option value="abreviado">Abreviado</option>
									</select>
									<input
										v-model="inputSearch"
										@keyup.enter="getListTypeDocuments()"
										required
										type="search"
										class="form-control"
										id="inputSearch"
										placeholder="Escriba aquí..">

									<div class="input-group-append">
										<span
											@click="getListTypeDocuments()"
											class="input-group-text"
											type="button"
											id="button-addon2">
											<i class="fal fa-search mr-2"></i>
											Buscar
										</span>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-xs table-personal">
						<thead>
							<tr class="text-center">
								<th width="80px">Estado</th>
								<th>Nombre</th>
								<th>Abreviado</th>
								<th width="100px">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(typeDocument,index) in listTypeDocuments.data" :key="index" class="text-uppercase">
								<td class="text-center">
									<button class="btn btn-sm btn-success btn-state" @click="setUpdateStatus(typeDocument)" title="Desactivar" v-if="typeDocument.isActive">
										<i class="fal fa-check-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Activado</span>
									</button>
									<button class="btn btn-sm btn-danger btn-state"  @click="setUpdateStatus(typeDocument)" title="Activar" v-else>
										<i class="fal fa-times-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Desactivado</span>
									</button>
								</td>
								<td>{{ typeDocument.nombre }}</td>
								<td>{{ typeDocument.abreviado }}</td>
								<td class="text-center">
									<button
										class="btn btn-primary btn-sm"
										data-toggle="tooltip"
										title=""
										data-placement="bottom"
										data-original-title="Editar"
										@click="showModalEdit(typeDocument)">
										<i class="fal fa-edit mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Editar</span>
									</button>
									<button
										class="btn btn-warning btn-sm"
										data-toggle="tooltip"
										title="Ver Detalles"
										data-placement="bottom"
										data-original-title="ver detalles"
										@click="showModalView(typeDocument)">
										<i class="fal fa-eye mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Ver</span>
									</button>
									<button
										class="btn btn-danger btn-sm"
										data-toggle="tooltip"
										title=""
										data-placement="bottom"
										data-original-title="Eliminar"
										@click="setDeleteModel(typeDocument.id)">
										<i class="fal fa-trash-alt mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Eliminar</span>
									</button>

								</td>
							</tr>

						</tbody>
						<tfoot>
							<tr class="text-center">
								<th width="80px">Estado</th>
								<th>Nombre</th>
								<th>Abreviado</th>
								<th width="100px">Acciones</th>
							</tr>
						</tfoot>
					</table>
					<pagination :show-disabled="false" :data="listTypeDocuments" @pagination-change-page="getListTypeDocuments">
						<span slot="prev-nav"><i class="far fa-angle-left mr-2"></i>Anterior</span>
						<span slot="next-nav">Siguiente<i class="far fa-angle-right ml-2"></i></span>
					</pagination>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="@/components/TipoDocumento/TipoDocumento.js"></script>
