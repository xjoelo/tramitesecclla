import configService from '@/services/config'

const UserService =  {}

UserService.list = function(){
	return axios.get(configService.apiUrl + 'user/list')
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}

UserService.insert = function (data) {
	var url = data.id > 0  ? 'user/update' : 'user/insert'
	return axios({
		method: 'post',
		url: configService.apiUrl + url,
		data
	}).then(function (response) {
		return response
	})
	.catch(error  => error.response.data)
}


export default UserService