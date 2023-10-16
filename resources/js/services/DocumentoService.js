import configService from '@/services/config'
import GenericTablesService from '@/services/GenericTablesService'

const DocumentoService =  {}

DocumentoService.listarEnProceso = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `documento/en-proceso/listar?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}

DocumentoService.listarDerivados = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `documento/derivados/listar?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}

DocumentoService.listarPorRecibir = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `documento/por-recibir/listar?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}
DocumentoService.listarArchivados = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `documento/archivados/listar?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}




DocumentoService.insert = function (data) {
	var url = data.id > 0 ? 'dependencia/update' : 'dependencia/insert'
	return axios({
		method: 'post',
		url: configService.apiUrl + url,
		data
	}).then(function (response) {
        return response.data
    })
	.catch(error  => error.response.data)
}


export default DocumentoService

