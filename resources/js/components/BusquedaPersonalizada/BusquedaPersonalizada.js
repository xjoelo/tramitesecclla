import UserService from '@/services/UserService'
import GenericTablesService from '@/services/GenericTablesService'

var moment = require('moment');
moment.locale('es');



export default {
	name: 'SfBusquedaPersonalizada',
	components:{
             
	},
	props: ['user','nuevo'],
	data(){
		return {
            
            rucdni:null,
            origenDocumento:0,
            desde:null,
            hasta:null,
            dependencia:null,
            tipoDocumento:null,
            nroDocumentoTipo:null,
            siglas:null,
            asunto:null,
            firma:null,
            dependenciaSelected:null,
            listDependencias:[], // lista de todas las aread
            listDocumentos:[], // lista de todas las aread

       
		};
	},
	created(){
        this.getListDependencias()
        this.getListDocumentos()
	},
	mounted(){
	    
    },
	filters:{

	},
	watch:{
        dependencia(n,o){
            this.dependenciaSelected = this.dependencia.id
        }
	},
	computed:{

	},
	methods:{
        async getListDependencias() {
            const { data } = await GenericTablesService.listAll('dependencias')
            this.listDependencias = data
        },
        async getListDocumentos() {
            const { data } = await GenericTablesService.listAll('tipo_documentos')
            this.listDocumentos = data
        },
        
	}
};
