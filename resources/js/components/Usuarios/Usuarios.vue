<template>
	<div>
		<SfLoader v-if="procesando"></SfLoader>
		<div class="modal fade" id="modalFormUser" tabindex="-1" role="dialog">
	        <div class="modal-dialog  modal-600" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title">
	                    	<i class="fas fa-user mr-2"></i>
	                    	{{ titleModal }}
	                    </h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <form autocomplete="off" >
	                	<div class="modal-body scrollable" id="scrollStyle">
							<div class="form-row ">
								<div class="form-group col-sm-12 col-md-6">
									<label for="dni">DNI :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-address-card"></i>
											</label>
										</span>
										<input v-model="dni" required type="text" class="form-control" :readonly="isView" id="dni" placeholder="Documento">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="nombres">Nombres :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-address-card"></i>
											</label>
										</span>
										<input v-model="nombres" required type="text" class="form-control" :readonly="isView" id="nombres" placeholder="Juan">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="apellidoPaterno">Apellido Paterno :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-address-card"></i>
											</label>
										</span>
										<input v-model="apellidoPaterno" required type="text" class="form-control" :readonly="isView" id="apellidoParerno" placeholder="Perez">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="apellidomaterno">Apellido Materno :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-address-card"></i>
											</label>
										</span>
										<input v-model="apellidoMaterno" required type="text" class="form-control" :readonly="isView" id="apellidomaterno" placeholder="Perez">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="iniciales">Iniciales :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="far fa-text"></i>
											</label>
										</span>
										<input v-model="iniciales" required type="text" class="form-control" :readonly="isView" id="iniciales" placeholder="JPP">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="fechaNacimiento">Fecha de Nac. :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-calendar-alt"></i>
											</label>
										</span>
										<input v-model="fechaNacimiento" required type="date" class="form-control" :readonly="isView" id="fechaNacimiento">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="celular">Celular :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-mobile"></i>
											</label>
										</span>
										<input v-model="celular" required type="text" class="form-control" :readonly="isView" id="celular" placeholder="999 999 999">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="email">Email :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-envelope"></i>
											</label>
										</span>
										<input v-model="email" required type="text" class="form-control" :readonly="isView" id="email" placeholder="ejemplo@algo.com">
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label for="direccion">Dirección :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-map-marked"></i>
											</label>
										</span>
										<input v-model="direccion" required type="text" class="form-control" :readonly="isView" id="direccion" placeholder="Jr. Algo # 123">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="username">Usuario :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-user"></i>
											</label>
										</span>
										<input v-model="username" required type="text" class="form-control" :readonly="isView" id="username" placeholder="jperez">
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="password">Contraseña :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-lock-alt"></i>
											</label>
										</span>
										<input v-model="password" required type="password" class="form-control" :readonly="isView" id="password" placeholder="contraseña">
										<span class="input-group-prepend" @click="showHidePassword(isShowPassword)">
											<label class="input-group-text cursor-pointer">
												<i v-if="isShowPassword" class="fal fa-eye"></i>
                                                <i v-else class="fal fa-eye-slash"></i>
											</label>
										</span>
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="role">Rol :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-user-tag"></i>
											</label>
										</span>
										<select id="role"
                                            :class="{
                                                'form-control' : true,
                                                'disabled-select' : isView
                                            }"
                                            :readonly="isView" v-model="idRol">
											<option :value="null"> Seleccione..</option>
											<option v-for="(role,index) in listRoles" :key="index" :value="role.id">
												{{ role.nombre }}
											</option>
										</select>
									</div>
								</div>
								<div class="form-group col-sm-12 col-md-6">
									<label for="isPublico">Atiende al Público :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-street-view"></i>
											</label>
										</span>
										<select id="isPublico"
                                            :class="{
                                                'form-control' : true,
                                                'disabled-select' : isView
                                            }"
                                             :readonly="isView" v-model="isPublico">
											<option :value="null"> Seleccione..</option>
											<option value="1">Si</option>
											<option value="0">No</option>

										</select>
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label for="area">Area :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-building"></i>
											</label>
										</span>
										<v-select
                                            :readonly="isView"
                                            placeholder="SELECCIONE.."
                                            class="form-control text-uppercase"
                                            v-model="idDependencia"
                                            :class="{'disabled-select': isView }"
                                            :options="listDependencias"
                                            :reduce="dependencia => dependencia.id"
                                            :getOptionLabel="dependencia => dependencia.nombre"
                                        >
                                            <div slot="no-options">Sin resultados para mostrar.</div>
                                        </v-select>
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label for="cargo">Cargo :</label>
									<div class="input-group input-group-primary">
										<span class="input-group-prepend">
											<label class="input-group-text">
												<i class="fal fa-user-tie"></i>
											</label>
										</span>
										<input v-model="cargo" required type="text" class="form-control" :readonly="isView" id="cargo" placeholder="Jefe de  Area">
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label for="observaciones">Observaciones :</label>
									<textarea v-model="observaciones"
                                        id="observaciones"
                                        class="form-control form-control-primary"
                                        placeholder="Escriba una observación"
                                        :readonly="isView" ></textarea>
								</div>
							</div>
						</div>
					</form>
					<div class="modal-footer">
						<button  class="btn btn-outline-danger" data-dismiss="modal" type="button" >
							<i class="fal fa-times-circle mr-2"></i>
							Salir
						</button>
						<button v-if="accion == 1" class="btn btn-primary" @click="setUserForm()" >
							<i class="fal fa-paper-plane"></i>
							Enviar
						</button>
						<button v-if="accion == 2" class="btn btn-primary" @click="setUserForm()" >
							<i class="fal fa-paper-plane"></i>
							Actualizar
						</button>
					</div>

				</div>
			</div>
		</div>

		<div class="card" >
			<div class="card-header  p-3">
				<h4 class="user-select-none">
					<i class="fad fa-users mr-2"></i> GESTIÓN DE USUARIOS
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
										<option :value="null"> Seleccione.. </option>
										<option value="apellidoPaterno">Apellido Paterno</option>
										<option value="apellidoMaterno">Apellido Materno</option>
										<option value="nombres">Nombres</option>
										<option value="dni">DNI</option>
									</select>
									<input
										v-model="inputSearch"
										@keyup.enter="getListUser()"
										required
										type="search"
										class="form-control"
										id="inputSearch"
										placeholder="Escriba aquí..">
									<div class="input-group-append">
										<span
											@click="getListUser()"
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
								<th width="100px">Dni</th>
								<th>Apellidos y Nombres</th>
								<th>Usuario</th>
								<th>Area</th>
								<th>Rol</th>
								<th width="100px">Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(user,index) in listUser.data" :key="index" class="text-uppercase">
								<td class="text-center">
									<button class="btn btn-sm btn-success btn-state" @click="setStatusUser(user)" title="Desarctivar" v-if="user.isActive">
										<i class="fal fa-check-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Activado</span>
									</button>
									<button class="btn btn-sm btn-danger btn-state"  @click="setStatusUser(user)" title="Activar" v-else>
										<i class="fal fa-times-circle mr-0 mr-md-2"></i>  <span class="d-none d-md-inline-block">Desactivado</span>
									</button>
								</td>
								<td>{{ user.dni }}</td>
								<td>{{ user.full_name }}</td>
								<td>{{ user.username }}</td>
								<td>{{ user.dependencia.nombre }}</td>
								<td>{{ user.role.nombre }}</td>
								<td class="text-center">
									<button
										class="btn btn-primary btn-sm"
										data-toggle="tooltip"
										title=""
										data-placement="bottom"
										data-original-title="Editar"
										@click="ShowModalEditUser(user)">
										<i class="fal fa-edit mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Editar</span>
									</button>
									<button
										class="btn btn-warning btn-sm"
										data-toggle="tooltip"
										title="Ver Detalles"
										data-placement="bottom"
										data-original-title="ver detalles"
										@click="ShowModalViewUser(user)">
										<i class="fal fa-eye mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Ver</span>
									</button>
									<button
										class="btn btn-danger btn-sm"
										data-toggle="tooltip"
										title=""
										data-placement="bottom"
										data-original-title="Eliminar"
										@click="setDeleteUser(user.id)">
										<i class="fal fa-trash-alt mr-0 mr-md-2"></i> <span class="d-none d-md-inline-block">Eliminar</span>
									</button>

								</td>
							</tr>

						</tbody>
						<tfoot>
							<tr class="text-center">
								<th width="80px">Estado</th>
								<th width="100px">Dni</th>
								<th>Apellidos y Nombres</th>
								<th>Usuario</th>
								<th>Area</th>
								<th>Rol</th>
								<th width="100px">Acciones</th>
							</tr>
						</tfoot>
					</table>
					<pagination :show-disabled="false" :data="listUser" @pagination-change-page="getListUser">
						<span slot="prev-nav"><i class="far fa-angle-left mr-2"></i>Anterior</span>
						<span slot="next-nav">Siguiente<i class="far fa-angle-right ml-2"></i></span>
					</pagination>
				</div>
			</div>
		</div>
	</div>
</template>
<script src="@/components/Usuarios/Usuarios.js"></script>
