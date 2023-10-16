// SERVICIOS
import DependenciaService from '@/services/DependenciaService'
import UserService from '@/services/UserService'
import RoleService from '@/services/RoleService'
import GenericTablesService from '@/services/GenericTablesService'

export default {
	name: 'SfUsuarios',
	components:{
	},
	props: [],
	data() {
		return {
			//datos formulario new SUCURSAL
            id: 0,
            dni: '',
            nombres: '',
            apellidoPaterno: '',
            apellidoMaterno: '',
            iniciales : '',
            fechaNacimiento : '',
            celular : '',
            direccion : '',
            email : '',
            idDependencia : '',
            cargo : '',
            observaciones : '',
            username : '',
            password : '',
            isPublico : '',
            idRol : '',
            isActive : true,

            searchBy: 'dni',
            inputSearch: '',


            isView : false,
            nroPorPagina:10,
            titleModal : 'Crear',
            accion : 1,//(1 => 'New',2 => 'Edit')


			listBranch : {},
            listUser: {},
            listRoles: {},
            listDependencias: [],

            procesando:false,
            isShowPassword: true
		};
	},
	created(){

	},
	mounted(){
		this.getListBranchOffice();
        this.getListUser();
        this.getListRol();
        this.getListDependencias()
	},
	filters:{

	},
	watch:{
        nroPorPagina(newVal,oldVal){
            this.getListUser()
        }
	},
	computed:{

	},
	methods:{
        async getListDependencias() {
            const { data } = await GenericTablesService.listAll('dependencias')
            this.listDependencias = data
        },
        async getListBranchOffice() {
            const res = await DependenciaService.list()
            this.listBranch = res;
        },
        async getListRol() {
            const res = await RoleService.list()
            this.listRoles = res;
        },
        async getListUser(page = 1) {
            let params = {
                searchBy: this.searchBy,
                inputSearch: this.inputSearch,
            }
            this.procesando = true
            const { data } = await UserService.list(page, this.nroPorPagina, params)
            this.listUser = data;
            this.procesando = false
        },
        modalShowFormNewUser() {
            this.getClearUserData()
            this.isView = false
            this.accion = 1
            this.titleModal = "Crear Usuario"
            $("#modalFormUser").modal({backdrop: 'static', keyboard: false})
        },

        ShowModalEditUser(user) {
            this.accion = 2
            this.titleModal = "Actualizar Usuario"
            this.isView = false
            this.setDataToForm(user)
            $("#modalFormUser").modal({backdrop: 'static', keyboard: false})
        },
        setDataToForm(user) {
            this.id = user.id
            this.dni = user.dni
            this.nombres = user.nombres
            this.apellidoPaterno = user.apellidoPaterno
            this.apellidoMaterno = user.apellidoMaterno
            this.iniciales = user.iniciales
            this.fechaNacimiento = user.fechaNacimiento
            this.celular = user.celular
            this.direccion = user.direccion
            this.email = user.email
            this.idDependencia = user.idDependencia
            this.cargo = user.cargo
            this.observaciones = user.observaciones
            this.username = user.username
            this.password = 'n0tm0d1f1ed'
            this.isPublico = user.isPublico
            this.idRol = user.idRol
        },
        ShowModalViewUser(user){
            this.accion = 3
            this.titleModal = "Detalles de Usuario"
            this.setDataToForm(user)
            this.isView = true

            $("#modalFormUser").modal({backdrop: 'static', keyboard: false})
        },
        constructDataFormUser() {
            return {
                id: this.id,
                dni: this.dni,
                nombres: String(this.nombres).toUpperCase(),
                apellidoPaterno: String(this.apellidoPaterno).toUpperCase(),
                apellidoMaterno: String(this.apellidoMaterno).toUpperCase(),
                iniciales: String(this.iniciales).toUpperCase(),
                fechaNacimiento: this.fechaNacimiento,
                celular: this.celular,
                direccion: this.direccion,
                email: this.email,
                idDependencia: this.idDependencia,
                cargo: this.cargo,
                observaciones: this.observaciones,
                username: this.username,
                password: this.password,
                isPublico: this.isPublico,
                idRol: this.idRol,
            }
        },
        setUserForm() {
            var data = this.constructDataFormUser()
            this.procesando = true
            UserService.insert(data).then(res =>{
                if(res.errors){
                    $.toast({
                        heading: 'Corriga los errores',
                        text:res.errors,
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000
                    })
                    this.procesando = false
                    return
                }
                else if(res.id || res == 1){

                    this.getListUser()
                    $('#modalFormUser').modal('hide');

                    Swal.fire({icon: 'success',title: 'Bien',text: 'El Proceso se realizo correctamente'})
                }
                else{
                    Swal.fire({icon: 'error',title: 'Espera',text: 'Algo salio mal, intentelo nuevamente'})
                }
                this.procesando = false

            })
        },
        async setStatusUser(user) {
            const { id,isActive } = user
            const newStatus = !isActive
            await GenericTablesService.changeStatus('users',id,newStatus)
            const estado = newStatus ? "activo" : "desactivo"
            $.toast({
                heading: 'Bien',
                text: `El usuario se ${estado} correctamente`,
                icon: 'success',
            })
            user.isActive = Boolean(newStatus) ? 1 : 0
        },
        showHidePassword(newState) {
            const $inputPassword = document.querySelector('#password')
            this.isShowPassword = !newState
            $inputPassword.type = newState ? 'text' : 'password'
        },
        setDeleteUser(id){ //Muestra msn confirmacion para eliminar y elimina Usuario
            let me = this
            Swal.fire({
                title: 'Espera!',
                text: "Desea eliminar registro?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#FF5252',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    me.procesando = true
                    GenericTablesService.delete('personas',id).then(res =>{
                        me.getListUser()
                        me.procesando = false
                        Swal.fire(
                            'Eliminado!',
                            'Registro se elimino correctamente.',
                            'success'
                        )

                    })
                }
            })
        },
        getClearUserData() {
            this.id = null
            this.dni = null
            this.nombres = null
            this.apellidoPaterno = null
            this.apellidoMaterno = null
            this.iniciales = null
            this.fechaNacimiento = null
            this.celular = null
            this.direccion = null
            this.email = null
            this.idDependencia = null
            this.cargo = null
            this.observaciones = null
            this.username = null
            this.password = null
            this.isPublico = null
            this.idRol = null
            this.isActive = null
        }

	}
};
