// SERVICIOS
import UbigeoService from '@/services/UbigeoService'

// COMPONENTES


export default {
	name: 'SfUbigeo',
	components:{

	},
	props: [
		'pubigeo'
	],
	data() {
		return {
			distrito : null,
            provincia : null,
            departamento : null,

            listDepartamentos:[],
            listProvincias:[],
            listDistritos:[],

		};
	},
	created(){

	},
	mounted(){
		if(this.pubigeo){
			this.departamento = this.pubigeo.departamento
			this.provincia = this.pubigeo.provincia
			this.distrito = this.pubigeo.distrito
			this.getListDepartamentos()
			this.getListProvincias(this.departamento)
			this.getListDistritos(this.provincia)
		}
		else{
			this.getListDepartamentos()
		}
		
	},
	watch:{
		distrito : function(nv,ov){
			nv ? this.emitUbigeo() : ''
			
		},
		pubigeo : function(nv,ov){
			this.departamento = nv.departamento
			this.provincia = nv.provincia
			this.distrito = nv.distrito
			this.getListDepartamentos()
			this.getListProvincias(this.departamento)
			this.getListDistritos(this.provincia)
		}
	},
	computed:{

	},
	methods:{
		getListDepartamentos(){
            UbigeoService.listDepartamento().then(res =>{
                this.listDepartamentos = res  
            })
        },
        getListProvincias(departamento){
            UbigeoService.listProvincia(departamento).then(res =>{
                this.listProvincias = res  
            })
        },
        getListDistritos(provincia){
            UbigeoService.listDistrito(provincia).then(res =>{
                this.listDistritos = res  
            })
        },
        changeDepartamento(event){
            this.getListProvincias(event.target.value)
            this.provincia = null
            this.listDistritos = []
        },
        changeProvincia(event){
            this.getListDistritos(event.target.value)
            this.distrito = null
        },
		emitUbigeo(){
			var ubigeo = {
				departamento : this.departamento,
				provincia : this.provincia,
				distrito : this.distrito
			}
			this.$emit('sendUbigeo',ubigeo)
		},
		
	}
};