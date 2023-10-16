<template>
	<div>
		<SfLoader v-if="procesando"></SfLoader>

		<div class="modal fade" id="modal-archivador" tabindex="-1" role="dialog">
	        <div class="modal-dialog modal-700" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title">
	                    	<i class="fad fa-file-alt mr-2"></i>
	                    	{{ titleModal }} archivador
	                    </h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <form autocomplete="off">
	                	<div class="modal-body scrollable" id="scrollStyle">
							<div class="form-row">
								<template v-if="currentUser.idRol == 1">
									<div class="form-group col-sm-12">
										<label for="nombre">Área :</label>
										<div class="input-group input-group-primary">
											<span class="input-group-prepend">
												<label class="input-group-text">
													<i class="fal fa-briefcase"></i>
												</label>
											</span>
	                                        <v-select
	                                            :readonly="isView"
	                                            placeholder="SELECCIONE.."
	                                            class="form-control text-uppercase"
	                                            v-model="idDependencia"
	                                            :class="{ 'disabled-select': isView }"
	                                            :options="listDependencias"
	                                            :reduce="dependencia => dependencia.id"
	                                            :getOptionLabel="dependencia => dependencia.nombre"
	                                        >
	                                            <div slot="no-options">Sin resultados para mostrar.</div>
	                                        </v-select>
										</div>
									</div>
								</template>
								<div class="form-group col-sm-12 col-md-6">
									<label for="nombre">Nombre :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-folder-open"></i>
											</label>
										</span>
										<input v-model="nombre" required type="text" class="form-control text-uppercase" :readonly="isView" id="nombre" placeholder="Nombres">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="periodo">Periodo :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-calendar-alt"></i>
											</label>
										</span>
										<input v-model.number="periodo"
                                        @blur="handleMinMaxValuePeriodo(periodo)"
                                        type="number"
                                        :max="currentYear"
                                        min="1990"
                                        class="form-control text-uppercase" :readonly="isView" id="periodo" placeholder="periodo">
									</div>
								</div>

								<div class="form-group col-sm-12 col-md-6">
									<label for="isPersonal">Es personal :</label>
                                    <div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-user"></i>
											</label>
										</span>
                                        <select v-model="isPersonal"
                                            :readonly="isView"
                                            :class="{
                                                'form-control': true,
                                                'disabled-select': isView
                                            }"
                                            id="isPersonal">
                                            <option :value="true">Si</option>
                                            <option :value="false">No</option>
                                        </select>
									</div>
								</div>
								<template v-if="(currentUser.idRol == 1 && isPersonal) || (isView && isPersonal) ">
									<div class="form-group col-sm-6">
										<label for="nombre">Usuario :</label>
										<div class="input-group input-group-primary">
											<span class="input-group-prepend">
												<label class="input-group-text">
													<i class="fal fa-user"></i>
												</label>
											</span>
	                                        <select class="form-control" 
	                                        	v-model="usuario" :class="{
	                                                'form-control': true,
	                                                'disabled-select': isView
	                                            }"
		                                        :readonly="isView">
	                                        	<option :value="null">..Seleccione..</option>
	                                        	<option v-for="user in listUsersArea" :value="user.id">{{ user.username }}</option>
	                                        </select>
	                                           
										</div>
									</div>
								</template>
							</div>
						</div>
					</form>

					<div class="modal-footer">
						<button  class="btn btn-outline-danger" data-dismiss="modal" type="button">
							<i class="fal fa-times-circle mr-2"></i>
							Salir
						</button>
						<button v-if="accion == 1 || accion == 2" class="btn btn-primary" @click="sendForm()">
							<i class="fal fa-paper-plane"></i>
                            {{ accion == 1 ? 'Enviar' : 'Actualizar' }}
						</button>
					</div>

				</div>
			</div>
		</div>

		<div class="card" >
			<div class="card-header p-3">
				<h4 class="user-select-none">
					<i class="fad fa-file-alt mr-2"></i> GESTIÓN DE ARCHIVADORES
				</h4>
				<div class="card-header-right mr-0 align-middle">
					<button class="btn btn-primary" @click="modalShowFormNewUser">
						<i class="fas fa-plus-circle"></i> Nuevo Registro
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
										<option value="">Seleccione.. </option>
										<option value="nombre">Nombre</option>
										<option value="periodo">Periodo</option>
										<option value="nombreArea">Nombre de área</option>
									</select>
									<input
										v-model="inputSearch"
										@keyup.enter="getListArchivadores()"
										required
										type="search"
										class="form-control"
										id="inputSearch"
										placeholder="Escriba aquí..">
									<div class="input-group-append">
										<span
											@click="getListArchivadores()"
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
								<th width="120px" class="text-center">Propiedad</th>
								<th>Nombre</th>
								<th>Área</th>
								<th width="90px" class="text-center">Periodo</th>
								
								<th width="100px">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item,index) in listArchivadores.data" :key="index" class="text-uppercase">
								<td class="text-center">
									<button class="btn btn-sm btn-success btn-state" @click="setUpdateStatus(item)" title="Desactivar" v-if="item.isActive">
										<i class="fal fa-check-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Activado</span>
									</button>
									<button class="btn btn-sm btn-danger btn-state"  @click="setUpdateStatus(item)" title="Activar" v-else>
										<i class="fal fa-times-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Desactivado</span>
									</button>
								</td>
								<td width="120px" class="text-center">
									<span v-if="item.isPersonal">
										<i class="fas fa-user fa-lg"></i>
									</span>
									<span v-else>
										<i class="fas fa-network-wired fa-lg"></i>
									</span>
								</td>
								<td> {{ item.nombre }} - <strong>{{ item.isPersonal ? item.user.username : 'OFICINA'}}</strong> </td>
                                <td> {{ item.area.nombre || '-' }} </td>
								<td width="90px" class="text-center"> {{ item.periodo }} </td>
								<td class="text-center">
									<template v-if="item.idUser == currentUser.id">
										<button
											class="btn btn-primary btn-sm"
											data-toggle="tooltip"
											title=""
											data-placement="bottom"
											data-original-title="Editar"
											@click="showModalEdit(item)">
											<i class="fal fa-edit mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Editar</span>
										</button>
									</template>
										
									<button
										class="btn btn-warning btn-sm"
										data-toggle="tooltip"
										title="Ver Detalles"
										data-placement="bottom"
										data-original-title="ver detalles"
										@click="showModalView(item)">
										<i class="fal fa-eye mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Ver</span>
									</button>
									<template v-if="item.idUser == currentUser.id">
										<button
											class="btn btn-danger btn-sm"
											data-toggle="tooltip"
											title=""
											data-placement="bottom"
											data-original-title="Eliminar"
											@click="setDeleteModel(item.id)">
											<i class="fal fa-trash-alt mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Eliminar</span>
										</button>
									</template>

								</td>
							</tr>

						</tbody>
						<tfoot>
							<tr class="text-center">
								<th width="80px">Estado</th>
								<th>Propiedad</th>
								<th>Nombre</th>
								<th>Área</th>
								<th>Periodo</th>
								<th width="100px">Acciones</th>
							</tr>
						</tfoot>
					</table>
					<pagination :show-disabled="false" :data="listArchivadores" @pagination-change-page="getListArchivadores">
						<span slot="prev-nav"><i class="far fa-angle-left mr-2"></i>Anterior</span>
						<span slot="next-nav">Siguiente<i class="far fa-angle-right ml-2"></i></span>
					</pagination>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="@/components/Archivador/Archivador.js"></script>
