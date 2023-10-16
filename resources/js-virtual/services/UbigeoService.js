import configService from '@/services/config'

const UbigeoService =  {}

UbigeoService.listDepartamento = function(){
	return axios.get(configService.apiUrl + 'ubigeo/listar/departamento',{
		params:{
			id:'01'
		}
	})
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.data)
}

UbigeoService.listProvincia = function(argDepartamento){
	return axios.get(configService.apiUrl + 'ubigeo/listar/provincia',{
		params:{
			department_id : argDepartamento
		}
	})
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.data)
}

UbigeoService.listDistrito = function(argProvincia){
	return axios.get(configService.apiUrl + 'ubigeo/listar/distrito',{
		params:{
			province_id : argProvincia
		}
	})
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.data)
}




export default UbigeoService