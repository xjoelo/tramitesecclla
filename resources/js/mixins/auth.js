let user = document.head.querySelector('meta[name="user"]')
let csrf = document.head.querySelector('meta[name="csrf"]')

module.exports = {
	computed:{
		currentUser(){
			return JSON.parse(user.content)
		},
		csrf(){
			return csrf.content
		}

	}
}