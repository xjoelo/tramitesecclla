import UserService from '@/services/UserService'
import GenericTablesService from '@/services/GenericTablesService'

import axios from "axios"
var moment = require('moment');
moment.locale('es');


import VueHtml2pdf from 'vue-html2pdf'

export default {
	name: 'SfDerivar',
	components:{
             
	},
	props: ['user','nuevo'],
	data(){
		return {
            operacion:null,
            procesando:false,

            documentoSelected : null,
            /******** DATOS DE FORMULARIO *********/
            areaDerivar:'',
            usuarioDerivar:null,
            proveidoAtencion:"SU ATENCIÓN",
            presentacionDocumento:1,

            listUsersArea:[],// lista de usuarios de un area en accion

            listAreasDerivar:[],// areas seleccionada a derivar
            
            listDependencias:[], // lista de todas las aread
            listaAntiDup:[]
       
		};
	},
	created(){
        this.getListDependencias()
	},
	mounted(){
	    
    },
	filters:{

	},
	watch:{
        areaDerivar(newValue,oldValue){
            if(this.areaDerivar){
                if(this.areaDerivar.id == this.user.dependencia.id){
                    if (this.listUsersArea.length <= 0 ) {
                        this.getListAllUserArea()
                    }
                }else{
                    this.usuarioDerivar = null
                }
            }  
        }
	},
	computed:{

	},
	methods:{
        /********** PETICIONES **************/
        async getListAllUserArea() {
            const data  = await UserService.listForArea()
            this.listUsersArea = await data
        },
        async getListDependencias() {
            const { data } = await GenericTablesService.listAll('dependencias')
            this.listDependencias = data
        },

        async showDerivar(operacion){
            this.operacion =  await operacion

            this.areaDerivar = ''
            this.usuarioDerivar = null
            this.proveidoAtencion = "SU ATENCIÓN"
            this.presentacionDocumento = 1
            this.listaAntiDup = []
            this.listAreasDerivar = []
            
            if (this.operacion) {
                $('#modalDerivarDocumentos').modal({
                    keyboard: false,
                    show: true,
                    backdrop: 'static'
                })
            }
        },

        async addAreaDerivar() {
            if(!this.areaDerivar) return
            this.listaAntiDup.push(this.areaDerivar.id)
            const duplicados = [...new Set(this.listaAntiDup.filter((value, index, self)=> self.indexOf(value)!== index))];
            // if (duplicados.length > 0) {
            //     Swal.fire({ icon: 'error', title: 'Espera!', html: 'La oficina ya se encuentra en la lista' })
            //     this.listaAntiDup = [...new Set(this.listaAntiDup)]
            //     return
            // }
            await this.listAreasDerivar.push({
                usuario : this.usuarioDerivar,
                proveidoAtencion : this.proveidoAtencion,
                dependencia : this.areaDerivar,
                presentacionDocumento : this.presentacionDocumento
            })
            
            this.keyVueSelect = this.keyVueSelect +1
            this.usuarioDerivar = null
        },
        removeListAreasDerivar(index) {
            this.listAreasDerivar.splice(index,1) 
        },

        async derivar() {
            if(this.listAreasDerivar.length <= 0)return
            this.procesando = true
            const params = {
                operacionAntes: this.operacion.id,
                idDocumento :this.operacion.id,
                derivaciones : this.listAreasDerivar
            }
            try {
                await axios.post('/documento/derivar', params)
                this.procesando = false
                $('#modalDerivarDocumentos').modal('hide')

                if (this.nuevo) {
                    await Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })
                    this.$emit("derivado", true)
                }else{
                    this.$emit("derivado", true)
                    Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })
                }    
            }catch (error) {
                this.procesando = false
                await Swal.fire({ icon: 'error', title: 'Espera!', html: '<span style="line-height:17px !important;font-size:15px !important">No se puede realizar las derivaciones<br><small>Asegurate que el documento que intentas derivar este en tu bandeja de documentos en proceso</small></span>' })
            }   
        },
	}
};
