<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Documento;
use Endroid\QrCode\QrCode;
use URL;

class TramiteVirtualRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $documento;
    public $imageQR;
    public $url;

    public function __construct(Documento $documento)
    {
        $documento->load('tipoDocumento');
        $this->documento = $documento;
        $this->url = URL::to('/')."/seguimiento-externo/{$this->documento->id}/{$this->documento->nroDocumentoPersona}";

        $qrCode = new QrCode($this->url);
        $qrCode->setSize(180);
        $image= $qrCode->writeString();
        $this->imageQR = base64_encode($image);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $nroDocumento = str_pad($this->documento->nroDocumento,  7, "0",STR_PAD_LEFT);
      return $this->subject("Registro de Trámite Virtual [E-$nroDocumento] - MUNI SECCLLA")
        ->view('emails.tramite_virtual.register');
    }
}
