import configService from '@/services/config'
import GenericTablesService from '@/services/GenericTablesService'

const Service =  {}

Service.list = function (page,paginate,params) {
    const url = GenericTablesService.urlSearchParams(page,paginate,params)
	return axios.get(configService.apiUrl + `user/list?${url}`)
	.then(response => response)
	.catch(error  => error.response.data)
}

Service.listForArea = function () {
    // const url = GenericTablesService.urlSearchParams(page,paginate,params)

	return axios.get(configService.apiUrl + `user/list/area`)
	.then(response => response.data)
	.catch(error  => error.response.data)
}
Service.listForAreaValue = function (area) {
    // const url = GenericTablesService.urlSearchParams(page,paginate,params)

	return axios.get(configService.apiUrl + `user/list/area-value/${area}`)
	.then(response => response.data)
	.catch(error  => error.response.data)
}



Service.insert = function (data) {
	var url = data.id > 0  ? 'user/update' : 'user/insert'
	return axios({
		method: 'post',
		url: configService.apiUrl + url,
		data
	}).then(({ data }) => data )
	.catch(error  => error.response.data)
}



export default Service
