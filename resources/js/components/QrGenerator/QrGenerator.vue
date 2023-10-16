<template>
	<div class="container-fluid p-4">
		<div class="col-12 text-center">
			<h5 class="py-1 px-3 bg-secondary d-inline-block text-white">
				NUMERO DE REGISTRO 
			</h5>
			<h4>
				<span class="font-weight-bold format-numero">{{ documento.full_nro_registro }}</span>
			</h4>
			<span class="d-inline-block mx-auto">
				<qr-code :text="url" :size="tamanio"></qr-code>
			</span>
		</div>
		<div class="col-12">
			<div class="col-12 text-center">
				<small class="text-muted">
              		Con el <span class="font-weight-bold">NUMERO DE REGISTRO </span> ud. podrá consultar el seguimiento de su <span class="font-weight-bold">TRÁMITE</span>
          		
	          		<p>
	          			Tambien puede consultar en la siguiente URL <br>
	          			<a href="//localhost:3000/seguimiento-externo/2/46447409" class="btn-link">
	             		{{ url }}
	             		</a>
	             	 </p>
             	</small>
             </div>
		</div>
		<table class=" mb-2 table-mini table-detalle text-center table-bordered" width="100%" >
			<tr>
				<th class="text-center" >DOCUMENTO</th>
			</tr>
			<tr>
				<td class="text-center">{{ documento.full_documento}}</td>
			</tr>
		</table>
		<table class="table table-mini table-tramite text-center table-bordered">
			<tr>
				<th class="text-center" width="50%">FECHA DE REGISTRO</th>
				<th class="text-center" width="50%">ORIGEN DEL DOCUMENTO</th>
			</tr>
			<tr>
				<td>{{ documento.fechaRegistro | fechaNormal }}</td>
				<td>{{ documento.origenDocumento == 0 ? "INTERNO" : "EXTERNO" }}</td>
				
			</tr>
		</table>
		
			
	</div>
</template>
<script src="@/components/QrGenerator/QrGenerator.js"></script>
