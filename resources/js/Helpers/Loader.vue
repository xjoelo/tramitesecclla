<template>
    <div class="loaderFull">
        <div class="containerLoader">
            <div class="holder">
                <div class="box"></div>
            </div>
            <div class="holder">
                <div class="box"></div>
            </div>
            <div class="holder">
                <div class="box"></div>
            </div>
        </div>
    </div>
    
</template>
<style scoped>
.loaderFull{
    position:fixed;
    top:0;
    right: 0;
    z-index: 999999;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.7);

}

*, *:before, *:after {
  box-sizing: border-box;
}
.containerLoader {
  position: absolute;
  top: 40%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-perspective: 2000px;
          perspective: 2000px;
  -webkit-transform: rotateX(-30deg) rotateY(-45deg);
          transform: rotateX(-30deg) rotateY(-45deg);
}

.holder {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-transform: translate3d(0em, 3em, 1.5em);
          transform: translate3d(0em, 3em, 1.5em);
}
.holder:last-child {
  -webkit-transform: rotateY(-90deg) rotateX(90deg) translate3d(0, 3em, 1.5em);
          transform: rotateY(-90deg) rotateX(90deg) translate3d(0, 3em, 1.5em);
}
.holder:first-child {
  -webkit-transform: rotateZ(-90deg) rotateX(-90deg) translate3d(0, 3em, 1.5em);
          transform: rotateZ(-90deg) rotateX(-90deg) translate3d(0, 3em, 1.5em);
}
.holder:nth-child(1) .box {
  background-color: #448AFF;
}
.holder:nth-child(1) .box:before {
  background-color: #3E7ADE;
}
.holder:nth-child(1) .box:after {
  background-color: #406CB4;
}
.holder:nth-child(2) .box {
  background-color: #313156;
}
.holder:nth-child(2) .box:before {
  background-color: #1C1C40;
}
.holder:nth-child(2) .box:after {
  background-color: #1C1C40;
}
.holder:nth-child(3) .box {
  background-color: #FFFFFF;
}
.holder:nth-child(3) .box:before {
  background-color: #EAEAEA;
}
.holder:nth-child(3) .box:after {
  background-color: #CFCFCF;
}

.box {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-animation: ani-box 3s infinite;
          animation: ani-box 3s infinite;
  width: 3em;
  height: 3em;
}
.box:before, .box:after {
  position: absolute;
  width: 100%;
  height: 100%;
  content: "";
}
.box:before {
  left: 100%;
  bottom: 0;
  -webkit-transform: rotateY(90deg);
          transform: rotateY(90deg);
  -webkit-transform-origin: 0 50%;
          transform-origin: 0 50%;
}
.box:after {
  left: 0;
  bottom: 100%;
  -webkit-transform: rotateX(90deg);
          transform: rotateX(90deg);
  -webkit-transform-origin: 0 100%;
          transform-origin: 0 100%;
}

@-webkit-keyframes ani-box {
  8.33% {
    -webkit-transform: translate3d(-50%, -50%, 0) scaleZ(2);
            transform: translate3d(-50%, -50%, 0) scaleZ(2);
  }
  16.7% {
    -webkit-transform: translate3d(-50%, -50%, -3em) scaleZ(1);
            transform: translate3d(-50%, -50%, -3em) scaleZ(1);
  }
  25% {
    -webkit-transform: translate3d(-50%, -100%, -3em) scaleY(2);
            transform: translate3d(-50%, -100%, -3em) scaleY(2);
  }
  33.3% {
    -webkit-transform: translate3d(-50%, -150%, -3em) scaleY(1);
            transform: translate3d(-50%, -150%, -3em) scaleY(1);
  }
  41.7% {
    -webkit-transform: translate3d(-100%, -150%, -3em) scaleX(2);
            transform: translate3d(-100%, -150%, -3em) scaleX(2);
  }
  50% {
    -webkit-transform: translate3d(-150%, -150%, -3em) scaleX(1);
            transform: translate3d(-150%, -150%, -3em) scaleX(1);
  }
  58.3% {
    -webkit-transform: translate3d(-150%, -150%, 0) scaleZ(2);
            transform: translate3d(-150%, -150%, 0) scaleZ(2);
  }
  66.7% {
    -webkit-transform: translate3d(-150%, -150%, 0) scaleZ(1);
            transform: translate3d(-150%, -150%, 0) scaleZ(1);
  }
  75% {
    -webkit-transform: translate3d(-150%, -100%, 0) scaleY(2);
            transform: translate3d(-150%, -100%, 0) scaleY(2);
  }
  83.3% {
    -webkit-transform: translate3d(-150%, -50%, 0) scaleY(1);
            transform: translate3d(-150%, -50%, 0) scaleY(1);
  }
  91.7% {
    -webkit-transform: translate3d(-100%, -50%, 0) scaleX(2);
            transform: translate3d(-100%, -50%, 0) scaleX(2);
  }
  100% {
    -webkit-transform: translate3d(-50%, -50%, 0) scaleX(1);
            transform: translate3d(-50%, -50%, 0) scaleX(1);
  }
}

@keyframes ani-box {
  8.33% {
    -webkit-transform: translate3d(-50%, -50%, 0) scaleZ(2);
            transform: translate3d(-50%, -50%, 0) scaleZ(2);
  }
  16.7% {
    -webkit-transform: translate3d(-50%, -50%, -3em) scaleZ(1);
            transform: translate3d(-50%, -50%, -3em) scaleZ(1);
  }
  25% {
    -webkit-transform: translate3d(-50%, -100%, -3em) scaleY(2);
            transform: translate3d(-50%, -100%, -3em) scaleY(2);
  }
  33.3% {
    -webkit-transform: translate3d(-50%, -150%, -3em) scaleY(1);
            transform: translate3d(-50%, -150%, -3em) scaleY(1);
  }
  41.7% {
    -webkit-transform: translate3d(-100%, -150%, -3em) scaleX(2);
            transform: translate3d(-100%, -150%, -3em) scaleX(2);
  }
  50% {
    -webkit-transform: translate3d(-150%, -150%, -3em) scaleX(1);
            transform: translate3d(-150%, -150%, -3em) scaleX(1);
  }
  58.3% {
    -webkit-transform: translate3d(-150%, -150%, 0) scaleZ(2);
            transform: translate3d(-150%, -150%, 0) scaleZ(2);
  }
  66.7% {
    -webkit-transform: translate3d(-150%, -150%, 0) scaleZ(1);
            transform: translate3d(-150%, -150%, 0) scaleZ(1);
  }
  75% {
    -webkit-transform: translate3d(-150%, -100%, 0) scaleY(2);
            transform: translate3d(-150%, -100%, 0) scaleY(2);
  }
  83.3% {
    -webkit-transform: translate3d(-150%, -50%, 0) scaleY(1);
            transform: translate3d(-150%, -50%, 0) scaleY(1);
  }
  91.7% {
    -webkit-transform: translate3d(-100%, -50%, 0) scaleX(2);
            transform: translate3d(-100%, -50%, 0) scaleX(2);
  }
  100% {
    -webkit-transform: translate3d(-50%, -50%, 0) scaleX(1);
            transform: translate3d(-50%, -50%, 0) scaleX(1);
  }
}


</style>
