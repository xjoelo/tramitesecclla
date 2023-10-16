import configService from '@/services/config'

const GenericTablesService =  {}

GenericTablesService.listAll = model => axios({
  method: 'post',
  url : configService.apiUrl + 'generic-table/list-all-actives',
  data: {
      model
  }
})

GenericTablesService.changeStatus = function (model,id,isActive) {
	var data = {
		'model' : model,
		'id' : id,
		'isActive' : isActive
	}
	return axios({
		method: 'post',
		url : configService.apiUrl + 'generic-table/change-status',
		data
	}).then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}

GenericTablesService.delete = function (model, id) {
	var data = {
		'model' : model,
		'id' : id
	}
	return axios({
		method: 'post',
		url : configService.apiUrl + 'generic-table/delete',
		data
	}).then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}


export default GenericTablesService
