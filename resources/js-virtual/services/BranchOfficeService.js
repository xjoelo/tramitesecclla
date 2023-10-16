import configService from '@/services/config'

const BranchOfficeService =  {}

BranchOfficeService.list = function(){
	return axios.get(configService.apiUrl + 'branch-office/list')
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}

BranchOfficeService.insert = function (data) {
	var url = data.id > 0  ? 'branch-office/update' : 'branch-office/insert'
	return axios({
		method: 'post',
		url: configService.apiUrl + url,
		data
	}).then(function (response) {
		return response
	})
	.catch(error  => error.response.data)
}


export default BranchOfficeService