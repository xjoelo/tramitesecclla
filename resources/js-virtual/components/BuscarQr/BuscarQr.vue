<template>
    <div>
        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit" >
          <div v-if="validationSuccess" class="validation-success">
            Redireccionando
          </div>

          <div v-if="validationFailure" class="validation-failure">
            No es valido
          </div>

          <div v-if="validationPending" class="validation-pending">
            Escaneando el CODIGO QR
          </div>
        </qrcode-stream>
    </div>     
</template>
<script src="@2/components/BuscarQr/BuscarQr.js"></script>
<style scoped>
.validation-success,
.validation-failure,
.validation-pending {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, .8);
  text-align: center;
  font-weight: bold;
  font-size: 1.4rem;
  padding: 10px;

  display: flex;
  flex-flow: column nowrap;
  justify-content: center;
}
.validation-success {
  color: green;
}
.validation-failure {
  color: red;
}
</style>