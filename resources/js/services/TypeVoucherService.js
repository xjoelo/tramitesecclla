import configService from '@/services/config'

const TypeVoucherService =  {}

TypeVoucherService.list = function(){
	return axios.get(configService.apiUrl + 'type-voucher/list')
	.then(function (response) {
		return response.data
	})
	.catch(error  => error.response.data)
}


export default TypeVoucherService