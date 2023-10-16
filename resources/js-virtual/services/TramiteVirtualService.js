import configService from '@/services/config'

const Service = {}

Service.insert = function (data) {
    return axios({
        method: 'post',
        url: configService.apiUrl + 'tramite/insert',
        data
    })
        .then(response => response)
        .catch(error => error.response.data)
}

Service.delete = function (id) {
    var data = { id }
    return axios({
        method: 'post',
        url: configService.apiUrl + 'tramite/delete',
        data
    }).then(function (response) {
        return response.data
    })
        .catch(error => error.response.data)
}


export default Service
