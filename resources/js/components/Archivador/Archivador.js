// SERVICIOS
import ArchivadorService from '@/services/ArchivadorService'
import GenericTablesService from '@/services/GenericTablesService'
import UserService from '@/services/UserService'

export default {
	name: 'SfArchivador',
	data() {
		return {
            id: 0,
            idDependencia: null,
            nombre: '',
            periodo: null,
            isPersonal: false,

            searchBy: 'nombre',
            inputSearch: '',

            isView : false,
            nroPorPagina: 10,
            titleModal : 'Crear',
            accion: 1, //(1 => 'New',2 => 'Edit')
            listArchivadores: {},

            procesando:false,

            listDependencias: [],
            listUsersArea :[],
            usuario:null,
		}
	},
    created(){
        
    },
	mounted(){
        if (this.currentUser.idRol == 1) {
            this.getListDependencias()
        }
		this.getListArchivadores()
        this.idDependencia = this.currentUser.idDependencia
        
	},
    computed: {
        currentYear() {
            return new Date().getFullYear()
        },
    },
	watch: {
        nroPorPagina(newVal,oldVal) {
            this.getListArchivadores()
        },
        idDependencia(n,o){
            this.getListAllUserArea(this.idDependencia)
            this.usuario = null
        
            
            // 
        },
        isPersonal(n,o){
            if (!n) {
                this.usuario = null
            }
        }
	},
	methods:{
        async getListAllUserArea() {
            const data  = await UserService.listForAreaValue(this.idDependencia)
            this.listUsersArea = await data
        },
        handleMinMaxValuePeriodo(newValue) {
            const maxValue = this.currentYear
            const minValue = 1990
            if(newValue < minValue) {
                this.periodo = minValue
            } else if(newValue > maxValue) {
                this.periodo = this.currentYear
            }
        },
        async getListDependencias() {
            try {
                const { data } = await GenericTablesService.listAll('dependencias')
                this.listDependencias = data
            } catch (error) {

            }
        },
        async getListArchivadores(page = 1){
            let params = {
                searchBy: this.searchBy,
                inputSearch: this.inputSearch,
            }
            this.procesando = true
            const { data } = await ArchivadorService.list(page,this.nroPorPagina,params)
            this.listArchivadores = data
            this.procesando = false
        },
        modalShowFormNewUser() {
            this.clearForm()
            this.idDependencia = this.currentUser.idDependencia;
            this.titleModal = "Crear"
            $("#modal-archivador").modal({backdrop: 'static', keyboard: false})
        },
        showModalEdit(archivador) {
            this.accion = 2
            this.titleModal = "Editar"
            this.isView = false
            this.setDataToForm(archivador)
            $("#modal-archivador").modal({backdrop: 'static', keyboard: false})
        },
        setDataToForm(archivador) {
           
            this.id = archivador.id
            this.idDependencia = archivador.idDependencia
            this.nombre = archivador.nombre
            this.periodo = archivador.periodo
            this.isPersonal = Boolean(archivador.isPersonal)
            if ((this.currentUser.idRol == 1 && archivador.isPersonal) || (this.isView &&  archivador.isPersonal)) {
                this.usuario = archivador.idUser
            }
            else{
                this.usuario = null
            }
        },
        showModalView(archivador){
            this.accion = 3
            this.titleModal = "Detalle"
            this.isView = true
            this.setDataToForm(archivador)
            // this.usuario = archivador.idUser
            $("#modal-archivador").modal({backdrop: 'static', keyboard: false})
        },
        constructData() {
            return {
                id: this.id,
                idDependencia: this.idDependencia,
                nombre: String(this.nombre).toUpperCase(),
                periodo: String(this.periodo).toUpperCase(),
                isPersonal: this.isPersonal,
                idUser:this.usuario,
            }
        },
        async sendForm() {
            const data = this.constructData()
            try {
                this.procesando = true
                const res = await ArchivadorService.insert(data)
                if(res.errors){
                    $.toast({
                        heading: 'Corriga los errores',
                        text: res.errors,
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000
                    })
                    this.procesando = false
                    return
                } else if (res.id || res == 1) {
                    this.getListArchivadores()
                    $('#modal-archivador').modal('hide')
                    Swal.fire({icon: 'success',title: 'Bien',text: 'El Proceso se realizo correctamente'})
                } else {
                    Swal.fire({icon: 'error',title: 'Espera',text: 'Algo salio mal, intentelo nuevamente'})
                }
                this.procesando = false
            } catch (error) {
                console.error(`Next error:  ${error}`)
            }
        },
        async setUpdateStatus(data) {
            const { id,isActive } = data
            const newStatus = !isActive
            await GenericTablesService.changeStatus('archivadors',id,newStatus)
            const estado = newStatus ? "activo" : "desactivo"
            $.toast({
                heading: 'Bien',
                text: `El archivador se ${estado} correctamente`,
                icon: 'success',
            })
            data.isActive = Boolean(newStatus) ? 1 : 0
        },
        async setDeleteModel(id) {
            const { value } = await Swal.fire({
                title: 'Espera!',
                text: "Desea eliminar registro?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#FF5252',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            })
            if (value) {
                this.procesando = true
                await GenericTablesService.delete('archivadors',id)
                await this.getListArchivadores()
                this.procesando = false
                Swal.fire(
                    'Eliminado!',
                    'Registro se elimino correctamente.',
                    'success'
                )
            }
        },
        clearForm() {
            this.id = 0
            this.idDependencia = null
            this.nombre = ''
            this.periodo = this.currentYear
            this.isPersonal = false
            this.usuario = null
        }

	}
}
