// SERVICIOS
import DependenciaService from '@/services/DependenciaService'
import GenericTablesService from '@/services/GenericTablesService'

export default {
	name: 'SfDependencia',
	data() {
		return {
			//datos formulario new SUCURSAL
            id: 0,
            nombre: '',
            abreviado: '',
            siglas: '',
            representante: '',
            cargo: '',
            observaciones: '',
            fechaRegistro: '',
            maxEnProceso: '',
            isActive: true,

            searchBy: 'nombre',
            inputSearch: '',

            isView : false,
            nroPorPagina: 10,
            titleModal : 'Crear',
            accion: 1, //(1 => 'New',2 => 'Edit')
            listDependencias: {},

            procesando:false,
		}
	},
	mounted(){
		this.getListDependencias()
	},
	watch:{
        nroPorPagina(newVal,oldVal){
            this.getListDependencias()
        }
	},
	methods:{
        async getListDependencias(page = 1){// lista todos los Usuarios
            let params = {
                searchBy: this.searchBy,
                inputSearch: this.inputSearch,
            }
            this.procesando = true
            const { data } = await DependenciaService.list(page,this.nroPorPagina,params)
            this.listDependencias = data
            this.procesando = false
        },
        modalShowFormNewUser() {
            this.clearForm()
            this.titleModal = "Crear"
            $("#modalFormTypeDocument").modal({backdrop: 'static', keyboard: false})
        },
        showModalEdit(tipoDocumento) {
            this.accion = 2
            this.titleModal = "Editar"
            this.isView = false
            this.setDataToForm(tipoDocumento)
            $("#modalFormTypeDocument").modal({backdrop: 'static', keyboard: false})
        },
        setDataToForm(tipoDocumento) {
            this.id = tipoDocumento.id
            this.nombre = tipoDocumento.nombre
            this.abreviado = tipoDocumento.abreviado
            this.siglas = tipoDocumento.siglas
            this.representante = tipoDocumento.representante
            this.cargo = tipoDocumento.cargo
            this.observaciones = tipoDocumento.observaciones
            // this.fechaRegistro = tipoDocumento.fechaRegistro
            // this.maxEnProceso = tipoDocumento.maxEnProceso
        },
        showModalView(tipoDocumento){
            this.accion = 3
            this.titleModal = "Detalle"
            this.isView = true
            this.setDataToForm(tipoDocumento)

            $("#modalFormTypeDocument").modal({backdrop: 'static', keyboard: false})
        },
        constructData() {
            return {
                id: this.id,
                nombre: String(this.nombre).toUpperCase(),
                abreviado: String(this.abreviado).toUpperCase(),
                siglas: String(this.siglas).toUpperCase(),
                representante: String(this.representante).toUpperCase(),
                cargo: String(this.cargo).toUpperCase(),
                observaciones: String(this.observaciones).toUpperCase()
            }
        },
        async sendForm() {
            const data = this.constructData()
            try {
                this.procesando = true
                const res = await DependenciaService.insert(data)
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
                    this.getListDependencias()
                    $('#modalFormTypeDocument').modal('hide')
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
            await GenericTablesService.changeStatus('dependencias',id,newStatus)
            const estado = newStatus ? "activo" : "desactivo"
            $.toast({
                heading: 'Bien',
                text: `El tipo de documento se ${estado} correctamente`,
                icon: 'success',
            })
            data.isActive = Boolean(newStatus) ? 1 : 0
        },
        async setDeleteModel(id){ //Muestra msn confirmacion para eliminar y elimina Usuario
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
                await GenericTablesService.delete('dependencias',id)
                await this.getListDependencias()
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
            this.nombre = ''
            this.abreviado = ''
            this.representante=null
            this.siglas=null
            this.cargo=null
            
            this.isActive = true
            this.isView = false
            this.accion = 1
        }

	}
}
