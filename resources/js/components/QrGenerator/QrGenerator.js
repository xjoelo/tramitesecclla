
import VueQRCodeComponent from 'vue-qr-generator'
import configService from '@/services/config'

export default {
	name: 'SfQrGenerator',
	components:{
    'qr-code':VueQRCodeComponent
	},
	props: ['documento','tamanio'],
	data() {
		return {
            url:'',
		};
	},
	created(){
       this.generarUrl()
	},
	mounted(){

		
    },
	filters:{

	},
	watch:{

	},
	computed:{

	},
	methods:{
        generarUrl(){
            let documento = this.documento.origenDocumento == 0 ? '':this.documento.nroDocumentoPersona
            this.url = configService.apiUrl+'seguimiento-externo/'+this.documento.id+'/'+documento
        },

	}
};

