import configService from '@/services/config'
import GenericTablesService from '@/services/GenericTablesService'

const Service =  {}

Service.list = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `archivadores/list?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}

Service.listUserArea = function(page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `archivadores/list/user?${url}`)
	.then( function (response) {
        return response
    })
	.catch(error  => error.response.data)
}


Service.insert = function (data) {
	var url = data.id > 0 ? 'archivadores/update' : 'archivadores/insert'
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

