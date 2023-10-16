import configService from '@/services/config'
import GenericTablesService from '@/services/GenericTablesService'

const TramiteService =  {}


TramiteService.selectNumeracionUserAuth = function (data) {

	return axios({
		method: 'post',
		url: configService.apiUrl + 'numeracion-tipo-documento/seleccionar-usuario-autenticado',
		data
	}).then(function (response) {
        return response.data
    })
	.catch(error  => error.response.data)
}


export default TramiteService

