<template>
	<div>
		<SfLoader v-if="procesando"></SfLoader>
		<vue-pdf v-if="documentoSelected"
			:show-layout="false"
	        :float-layout="true"
	        :enable-download="false"
	        :preview-modal="true"
	        :paginate-elements-by-height="1400"
	        :filename="documentoSelected.documento.full_nro_registro"
	        :pdf-quality="2"
	        :manual-pagination="false"
	        pdf-format="a6"
	        pdf-orientation="portrait"
	        pdf-content-width="100%"
	        @progress="onProgress($event)"
	        @hasGenerated="hasGenerated($event)"
	        ref="html2Pdf"
	    >
			<section slot="pdf-content">
				<sf-qr-generator :documento="documentoSelected.documento" :tamanio="150" :key="documentoSelected.documento.id"></sf-qr-generator>
			</section>
		</vue-pdf>

		<vue-pdf v-if="documentoSelected"
			:show-layout="false"
	        :float-layout="true"
	        :enable-download="true"
	        :preview-modal="false"
	        :paginate-elements-by-height="1400"
	        :filename="documentoSelected.documento.full_nro_registro"
	        :pdf-quality="2"
	        :manual-pagination="false"
	        pdf-format="a6"
	        pdf-orientation="portrait"
	        pdf-content-width="100%"
	        @progress="onProgress($event)"
	        @hasGenerated="hasGeneratedMovil($event)"
	        ref="html2PdfMovil"

		>
			<section slot="pdf-content">
				<sf-qr-generator :documento="documentoSelected.documento" :tamanio="150" :key="documentoSelected.documento.id"></sf-qr-generator>
			</section>
		</vue-pdf>
		

		<div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"><!-- MODAL FORM ALCALDE -->
            <div class="modal-dialog modal-700" role="document">
                <div class="modal-content holds-the-iframe" style="height: 85vh !important;" v-if="documentoSelected">
                	<div class="modal-header">
                		 <h5 class="modal-title">
	                    	<i class="fas fa-file-alt mr-2"></i>
	                    	<span class="format-numero">{{ documentoSelected.documento.full_nro_registro }}</span>
	                    </h5>
                		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
                	</div>
                    <iframe :src="file" width="100%" height="100%"></iframe>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalTramite" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"><!-- MODAL FORM ALCALDE -->
            <div class="modal-dialog modal-800" role="document">
                <div class="modal-content holds-the-iframe" style="height: 85vh !important;" v-if="documentoSelected">
                	<div class="modal-header">
                		 <h5 class="modal-title">
	                    	<i class="fas fa-file-alt mr-2"></i>
	                    	<span class="format-numero">{{ documentoSelected.documento.full_nro_registro }}</span>
	                    </h5>
                		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
                	</div>
                	<iframe :src="urlDocumentoTramite" width="100%" height="100%"></iframe>
                </div>
            </div>
        </div>
		<div class="modal fade" id="modalDetalleDocumento" tabindex="-1" role="dialog">
	        <div class="modal-dialog  modal-600" role="document">
	            <div class="modal-content" v-if="documentoSelected">
	                <div class="modal-header">
	                    <h5 class="modal-title">
	                    	<i class="fas fa-file-alt mr-2"></i>
	                    	<span class="format-numero">{{ documentoSelected.documento.full_nro_registro }}</span>
	                    </h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
                	<div class="modal-body scrollable" id="scrollStyle">
            			<div class="col-12">
            				<h6 class="text-primary">
                				<i class="fas fa-clipboard-check mr-2"></i>DATOS DE REGISTRO
                			</h6>
                			<hr class="bg-primary my-2 ">
            			</div>
            			<div class="col-12">
            				<div class="table-responsive">
            					<table class="table table-mini table-tramite text-center">
		            				<tr>
		            					<th class="text-center" width="50%">FECHA DE REGISTRO</th>
		            					<th class="text-center" width="50%">URGENCIA</th>
		            				</tr>
		            				<tr>
		            					<td>{{ documentoSelected.documento.fechaRegistro | fechaNormal }}</td>
		            					<td>{{ documentoSelected.documento.urgencia_texto }}</td>
		            					
		            				</tr>
		            			</table>
            				</div>
            			</div>
		            	<div class="col-12">
            				<h6 class="text-primary">
                				<i class="fas fa-cog mr-2"></i>DATOS DE ORIGEN
                			</h6>
                			<hr class="bg-primary my-2 ">
            			</div>
            			<div class="col-12">
            				<div class="table-responsive">
            					<table class="table table-mini table-detalle text-center table-bordered">
		            				<tr>
		            					<th class="text-right" width="120">ORIGEN DEL DOCUMENTO</th>
		            					<td class="text-left">{{ documentoSelected.documento.origenDocumento == 0 ? "INTERNO" : "EXTERNO"}}</td>
		            				</tr>
		            				<tr>
		            					<th class="text-right">REMITENTE</th>
		            					<td class="text-left">
		            						<template  v-if="documentoSelected.documento.origenDocumento == 1" >
												<label v-if="documentoSelected.documento.tipoPersona == 1" class="label  label-warning">P. NATURAL</label>
												<label v-else class="label  label-inverse">P. JURIDICA</label>
											</template>
											<template  v-else >
												<label class="label label-primary"><i class="fas fa-university  mr-1"></i>MUNI SECCLLA</label>
											</template>
											{{ documentoSelected.documento.origenDocumento == 1 ? 
												(documentoSelected.documento.tipoPersona == 2 ? 
													documentoSelected.documento.dependencia : '') : 
													documentoSelected.documento.dependencia }}
											<span v-if="documentoSelected.documento.tipoPersona == 2 || documentoSelected.documento.origenDocumento == 0"><br > FIRMA: </span>
											<strong>{{ documentoSelected.documento.firma }}</strong>
		            					</td>
		            				</tr>
		            			</table>
            				</div>
            			</div>

		            	<div class="col-12">
            				<h6 class="text-primary">
                				<i class="fas fa-file-pdf mr-2"></i>DATOS DEL DOCUMENTO
                			</h6>
                			<hr class="bg-primary my-2 ">

            			</div>
            			<div class="col-12">
            				<div class="table-responsive">
            					<table class="table table-mini table-detalle text-center table-bordered">
            						<tr>
            							<th class="text-center">DOCUMENTO</th>
            						</tr>
            						<tr>
            							<td class="format-numero">{{ documentoSelected.documento.full_documento }}</td>
            						</tr>
            					</table>
            					<table class="table table-mini table-detalle text-center table-bordered">
            						<tr>
            							<th class="text-center">ASUNTO</th>
            						</tr>
            						<tr>
            							<td class="text-uppercase">{{ documentoSelected.documento.asunto }}</td>
            						</tr>
            					</table>
            					<table class="table table-mini table-detalle text-center table-bordered">
            						<tr>
            							<th class="text-center" width="50%">FOLIOS</th>
            							<th class="text-center" width="50%">FECHA DE DOC.</th>
            							<th class="text-center"  v-if="documentoSelected.documento.archivo" width="50%">ARCHIVO</th>
            						</tr>
            						<tr>
            							<td class="text-uppercase">{{ documentoSelected.documento.folios }}</td>
            							<td class="text-uppercase">{{ documentoSelected.documento.fechaDocumento | fechaNormal }}</td>
            							<td class="text-uppercase" v-if="documentoSelected.documento.archivo" >
            								<button class="btn btn-primary btn-mini m-1" data-toggle="modal" data-target="#modalPdf" >
            									<i class="far fa-file-pdf mr-"></i> Archivo
            								</button>
            								
            							</td>
            						</tr>
            					</table>
            					<table class="table table-mini table-detalle text-center table-bordered">
            						<tr>
            							<th class="text-center">ADJUNTOS</th>
            						</tr>
            						<tr>
            							<td class="text-uppercase">{{ documentoSelected.documento.adjuntos}}</td>
            						</tr>
            					</table>
            				</div>
            			</div>
            			<div class="col-12 d-flex justify-content-between">
            				<button class="btn btn-sm btn-dark d-none d-md-inline-block" @click='generateReport()'>
            					<i class="fas fa-qrcode mr-2"></i>
            					<span class="d-none d-md-inline">Imprimir</span> Ticket
            				</button>
            				<button class="btn btn-sm btn-dark  d-md-none" @click='generateReportMovil()'>
            					<i class="fas fa-qrcode mr-2"></i>
            					<span class="d-none d-md-inline">Imprimir</span> Ticket
            				</button>
            				<button  class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTramite">
            					<i class="fas fa-file-invoice mr-2"></i>
            					Seguimiento
            				</button>
            			</div>
            		</div>
	            </div>
	        </div>
	    </div>
		<div class="card" >
			<div class="card-header  p-3">
				<h4 class="user-select-none m-0 p-0">
					<i class="fas fa-share-square fa-flip-vertical fa-lg mr-2"></i>
					Documentos por Recibir
				</h4>
			</div>
			<div class="card-body">
				<div class="form-row d-flex justify-content-between mb-2" >
					<div class="col-12 col-sm-6 col-md-6">
						<div class="input-group input-group-secondary  justify-content-center  justify-content-md-start  mx-md-0" >
							<span class="input-group-prepend">
								<small>Mostrar</small>
							</span>
							<select v-model="nroPorPagina" class="selectNroPorPagina form-control mx-2" >
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="20">20</option>
							</select>
							<span class="input-group-prepend">
								<small>Registros</small>
							</span>
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-4 mt-2 mt-sm-0">
						<div class="form-row">
	                        <div class="col-auto">
	                        	<div class="input-group">
		                            <input
		                            	autocomplete="off"
										v-model="inputSearch"
										@keyup.enter="getListDocumentos()"
										required
										type="search"
										class="form-control"
										id="inputSearch"
										placeholder="Buscar...">
									<div class="input-group-append">
										<span
											@click="getListDocumentos()"
											class="input-group-text bg-secondary"
											type="button"
											id="button-addon2">
											<i class="fas fa-search mr-0 mr-md-2"></i>
											<span class="d-none d-md-inline-block f-12">Buscar</span>
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
								<th width="80px">Acciones</th>
								<th width="80px" class="text-center">Registro</th>
								<th width="100px">Fecha de envio</th>
								<th class="text-left">Documento</th>
								<th>Forma</th>
								<th class="text-left">Oficina de Origen</th>
								<th class="text-left">Oficina de Destino</th>
							</tr>
						</thead>
						<tbody>
							<template v-if="listDocumetos && listDocumetos.data && listDocumetos.data.length<=0 ">
								<tr  class="text-center">
									<td colspan="7">
										<h5>No se encontraron documentos</h5>
									</td>
								</tr>
							</template>
							<template v-else>
								<tr v-for="(documento,index) in listDocumetos.data" :key="index" class="text-uppercase text-center">
									<td >
										<button class="btn btn-success btn-mini" @click="antesRecibir(documento)">
											<i class="fas fa-file-signature"></i>
											Recibir
										</button>
									</td>
									<td class="format-numero f-14" style="font-size: 13px !important">
										<a :href="'/seguimiento-externo/'+documento.documento.id" target="printEvento2" onclick="window.open(this.href, this.target, ' width=800, height=700, menubar=no');return false;">
											{{documento.documento.full_nro_registro}}
										</a>
									</td>
									<td class="text-center">{{ documento.fechaOperacion | fechaNormal}}</td>
									<td class="format-numero text-left">
										<button class="btn btn-link text-info m-0 p-0" title="ver detalles" @click="mostrarDetalles(documento)">
											<i class="far fa-file-search mr-0"></i>
										</button>
										{{ documento.documento.full_documento }}
									</td>
									<td>{{ documento.forma_documento }}</td>
									<td class="text-left">
										<label class="label label-primary"><i class="fas fa-tint mr-1 "></i>MUNI SECCLLA</label>
										{{ documento.origen_oficina.abreviado }}
									</td>
									<td class="text-left">
										<label class="label label-primary"><i class="fas fa-university  mr-1"></i>MUNI SECCLLA</label>
										{{ documento.derivado_oficina.abreviado }}
										<template v-if="documento.derivado_usuario">
											<br>
											<label class="label label-success"><i class="fas fa-user"></i></label>
											{{ documento.derivado_usuario.username }}
										</template>
									</td>
									
								</tr>
							</template>
									
						</tbody>
						<tfoot>
							<tr class="text-center">
								<th width="80px">Acciones</th>
								<th width="80px" class="text-center">Registro</th>
								<th width="100px">Fecha de envio</th>
								<th class="text-left">Documento</th>
								<th>Forma</th>
								<th class="text-left">Oficina de Origen</th>
								<th class="text-left">Oficina de Destino</th>
							</tr>
						</tfoot>
					</table>
					<pagination :show-disabled="false" :data="listDocumetos" @pagination-change-page="getListDocumentos">
						<span slot="prev-nav"><i class="far fa-angle-left mr-2"></i>Anterior</span>
						<span slot="next-nav">Siguiente<i class="far fa-angle-right ml-2"></i></span>
					</pagination>
				</div>
			</div>
		</div>
	</div>
</template>
<script src="@/components/PorRecibir/PorRecibir.js"></script>
<style scoped>
	.vue-html2pdf{
		width: auto !important;
	}
</style>