import configService from '@/services/config'
import GenericTablesService from '@/services/GenericTablesService'

const Service =  {}

Service.list = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `dependencia/list?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}

Service.insert = function (data) {
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


export default Service

