import configService from '@/services/config'

const UserService =  {}

UserService.list = function(){
	return axios.get(configService.apiUrl + 'role/list')
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}

export default UserService