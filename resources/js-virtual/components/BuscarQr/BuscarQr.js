
import { QrcodeStream } from 'vue-qrcode-reader'


export default {
  name: 'SfQr',
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
        
            isValid: undefined,
            camera: 'auto',
            result: null,

        };
  },
    computed: {
        validationPending () {
          return this.isValid === undefined
            && this.camera === 'off'
        },

        validationSuccess () {
          return this.isValid === true
        },

        validationFailure () {
          return this.isValid === false
        }
      },
    mounted(){
       
    },

  methods:{
        onInit (promise) {
        promise
            .catch(console.error)
            .then(this.resetValidationState)
        },

        resetValidationState () {
          this.isValid = undefined
        },

        async onDecode (content) {
          this.result = content
          this.turnCameraOff()

          // pretend it's taking really long
          await this.timeout(3000)
          this.isValid = content.indexOf('/seguimiento-externo') >= 0

          this.separarUrl(content)
          // window.location.href=content 
          // some more delay, so users have time to read the message
          // await this.timeout(2000)

          this.turnCameraOn()
        },

        turnCameraOn () {
          this.camera = 'auto'
        },

        turnCameraOff () {
          this.camera = 'off'
        },

        timeout (ms) {
          return new Promise(resolve => {
            window.setTimeout(resolve, ms)
          })
        },
        logErrors (promise) {
        promise.catch(console.error)
        },
        separarUrl(url){
          let isDominio = url.indexOf('/seguimiento-externo')
          if(isDominio >= 0){
            window.location.href=url 
          }else{
            location.reload();
          }
        }
  }
};
