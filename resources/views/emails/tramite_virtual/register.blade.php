<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>REGISTRO DE TRÁMITE VIRTUAL</title>
	</head>
	<body style="font-family: Arial,helvetica,sans-serif;font-size: 14px;background:#D3D3D3;">
		<div class="container" style="margin: 20px auto;width: 100%;max-width: 700px;text-align: justify;background: #fff;">
			<div style="text-align: center">
				<img src="{{ $message->embed(asset("images/logo-munisecclla-tramite-virtual.png")) }}" width="220px" >
			</div>
			<div class="barColor" style="margin-top: 10px;display: block;width: 100%;background: #0084c9;padding:10px 20px;text-align: center;color: #fff;box-sizing: border-box;">
				<h2 style="margin: 0px !important;">TRÁMITE DOCUMENTARIO VIRTUAL</h2>
			</div>
		<div id="cuerpo" style="padding: 20px;width: 100%;box-sizing: border-box;">
			<div class="text-center" style="text-align: center;">

				<img src="{{ $message->embed(asset('images/correo-electronico.png')) }}"  width="80px"  alt="Imagen de buzón de correo entregado">
			</div>
		<div class="headerCuerpo text-center" style="text-align: center;">
			<p style="margin: 0px;margin-bottom:  10px;">Estimado(a): <strong>{{ $documento->firma }}</strong><br>
				@if ($documento->tipoPersona == 2)
				Representante de <strong>{{ $documento->dependencia }}</strong> con RUC nro. <strong>{{ $documento->nroDocumentoPersona }} </strong>
				@endif
				.
			</p>
			<h5 style="padding: 5px 25px !important;background:#0084c9;color: #fff;display: inline-block;">
				NUMERO DE REGISTRO 
			</h5>
			<h2 style="margin: 0px !important;padding:0px !important;">
				<span><strong>E{{ str_pad($documento->nroDocumento,  7, "0",STR_PAD_LEFT) }}</strong></span>
			</h2>
			{{-- <img src="data:image/png;base64, {!! $imageQR !!} "> --}}
			<img src="{{ $message->embedData(base64_decode($imageQR), 'imagename.png')}}">

			<div class="col-12 text-center" style="text-align: center;">
				<small class="text-muted">
				Con el <span class="font-weight-bold">NUMERO DE REGISTRO </span> ud. podrá consultar el seguimiento de su <span class="font-weight-bold">TRÁMITE</span>
				</small>
				<p style="margin: 0px;margin-bottom:  10px;">
					Tambien puede consultar en la siguiente URL <br><br>
					<a href="{{$url}}" class="btn-link">
					{{ $url }}
					</a>
				</p>
			</div>
		</div>
		<div class="text-center" style="text-align: center;">
			<h3 style="margin: 0px !important;padding:0px !important;">DATOS DEL DOCUMENTO</h3>
			<div>
				<table  style="border:solid 2px #0084c9;border-collapse: collapse;margin: 10px auto ;width: 90%;font-size: 11px;" >
					<tbody>
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Documento :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->tipoDocumento->nombre }} {{ $documento->nroDocumentoTipo }}-{{ $documento->siglas }}</td>
						</tr>
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Fecha del Documento :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->fechaDocumento }}</td>
						</tr>
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Folios :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->folios }}</td>
						</tr>
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Asunto :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->asunto }}</td>
						</tr>
						@if ($documento->tipoPersona == 2)
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Dependencia :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->dependencia }}</td>
						</tr>
						@endif
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Firma :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->firma }}</td>
						</tr>
						@if ($documento->tipoPersona == 2)
						<tr style="border-bottom: 1px solid #A6D1E7;">
							<th style="background: #0084c9;color:#fff;text-align:right;padding: 2px 5px !important;">Cargo :</th>
							<td style="text-align: left;padding: 2px 5px !important;">{{ $documento->cargoFirma }}</td>
						</tr>
						@endif
					</tbody>
				</table>
				
			</div>

		</div>

	</div>
	<div class="mensaje" style="width: 100%;box-sizing: border-box;padding: 20px;background: #0084c9;color: #fff;font-size: 12px;text-shadow: 2px 4px 3px rgba(0,0,0,0.3);">
					<span>
					Esta dirección de correo electrónico es utilizada únicamente para enviar notificaciones de tramites realizados, por lo que agradeceremos no responder con consultas personales.<br>
					</span>
					<div style="text-align: right;">
						<a href="https://www.softicslab.com" target="_blank">
						{{-- <img id="imgSoftics" src="{{ $message->embed(asset('assets/images/logo-softics-lab.png')) }}" width="120px"></a> --}}
						<img id="imgSoftics" src="{{ $message->embed(asset('images/logo-softics-lab.png')) }}" width="120px"></a>
					</div>
				</div>
</div>
			
	</body>
</html>