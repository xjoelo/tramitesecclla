// SERVICIOS
import TipoDocumentoService from '@/services/TipoDocumentoService'
import GenericTablesService from '@/services/GenericTablesService'

export default {
	name: 'SfTipoDocumento',
	data() {
		return {
			//datos formulario new SUCURSAL
            id: 0,
            nombre: '',
            abreviado: '',
            isActive: true,

            searchBy: 'nombre',
            inputSearch: '',

            isView : false,
            nroPorPagina: 10,
            titleModal : 'Crear',
            accion: 1, //(1 => 'New',2 => 'Edit')
            listTypeDocuments: {},

            procesando:false,
		}
	},
	mounted(){
		this.getListTypeDocuments()
	},
	watch:{
        nroPorPagina(newVal,oldVal){
            this.getListTypeDocuments()
        }
	},
	methods:{
        async getListTypeDocuments(page = 1){// lista todos los Usuarios
            let params = {
                searchBy: this.searchBy,
                inputSearch: this.inputSearch,
            }
            this.procesando = true
            const { data } = await TipoDocumentoService.list(page,this.nroPorPagina,params)
            this.listTypeDocuments = data
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
            this.id = tipoDocumento.id
            this.nombre = tipoDocumento.nombre
            this.abreviado = tipoDocumento.abreviado
            $("#modalFormTypeDocument").modal({backdrop: 'static', keyboard: false})
        },
        showModalView(tipoDocumento){
            this.accion = 3
            this.titleModal = "Detalle"
            this.isView = true
            this.id = tipoDocumento.id
            this.nombre = tipoDocumento.nombre
            this.abreviado = tipoDocumento.abreviado

            $("#modalFormTypeDocument").modal({backdrop: 'static', keyboard: false})
        },
        constructData() {
            return {
                id: this.id,
                nombre: String(this.nombre).toUpperCase(),
                abreviado: String(this.abreviado).toUpperCase()
            }
        },
        async sendForm() {
            const data = this.constructData()
            try {
                this.procesando = true
                const res = await TipoDocumentoService.insert(data)
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
                    this.getListTypeDocuments()
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
            await GenericTablesService.changeStatus('tipo_documentos',id,newStatus)
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
                await GenericTablesService.delete('tipo_documentos',id)
                await this.getListTypeDocuments()
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
            this.isActive = true
            this.isView = false
            this.accion = 1
        }

	}
}
