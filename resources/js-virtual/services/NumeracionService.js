import configService from '@/services/config'

const NumeracionService =  {}

NumeracionService.insert = function (data) {
	return axios({
		method: 'post',
		url: configService.apiUrl + 'series-sucursales/insert',
		data
	}).then(function (response) {
		
		return response

	})
	.catch(error  => error.response.data)
}

NumeracionService.listIdSucursal = function (data) {
	return axios({
		method: 'post',
		url: configService.apiUrl + 'series-sucursales/list-id',
		data
	}).then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}

NumeracionService.delete = function (id) {
	var data = {
		'id' : id
	}
	return axios({
		method: 'post',
		url : configService.apiUrl + 'series-sucursales/delete',
		data
	}).then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}


export default NumeracionService