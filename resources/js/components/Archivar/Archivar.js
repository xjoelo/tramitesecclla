import ArchivadorService from '@/services/ArchivadorService'
import axios from "axios"

export default {
	name: 'SfArchivar',
	components:{

	},
	props: [],
	data(){
		return {
            operacion:null,
            procesando:false,

            documentoSelected : null,
            /******** DATOS DE FORMULARIO *********/
            descripcionArchivo:null,
            archivador:null,
            listArchivadores:{},

        };
	},
    mounted(){
        this.getListArchivadores()
    },
	methods:{
        async showArchivar(operacion){

            this.operacion =  await operacion

            this.descripcionArchivo = null
            if (this.operacion) {
                $('#modalArchivarDocumentos').modal({
                    keyboard: false,
                    show: true,
                    backdrop: 'static'
                })
            }
        },
        async getListArchivadores(page = 1){
            let params = {
                searchBy: 1,
                inputSearch: 1,
            }
            this.procesando = true
            const { data } = await ArchivadorService.listUserArea(page,this.nroPorPagina,params)
            this.listArchivadores = data
            this.procesando = false
        },
        async archivar() {
            this.procesando = true
            const params = {
                operacionAntes: this.operacion.id,
                descripcionArchivo : this.descripcionArchivo,
                idArchivador : this.archivador
            }
            try {
                await axios.post('/documento/archivar', params)
                this.procesando = false
                $('#modalArchivarDocumentos').modal('hide')
                this.$emit("archivado", true)
                Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })   

            }catch (error) {
                this.isLoadend = false
                await Swal.fire({ icon: 'error', title: 'Espera!', html: '<span style="line-height:17px !important;font-size:15px !important">No se puede realizar la operación<br><small>Asegurate que el documento que intenta archivar este en tu bandeja de documentos en proceso</small></span>' })
            }   
        },
	}
};
