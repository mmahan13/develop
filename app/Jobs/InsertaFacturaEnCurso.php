<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

use App\Traits\PdfTrait;

use Carbon\Carbon;

use App\Factura;
use App\OperacionFactura;

use App\Http\Controllers\FacturaController;

class insertaFacturaEnCurso implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PdfTrait;

     protected $factura_en_curso;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $factura_en_curso)
    {
        $this->factura_en_curso = $factura_en_curso;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
                $factura_en_curso = $this->factura_en_curso;
                $factura_insertada = new Factura($factura_en_curso);
                $factura_insertada->fecha_date = Carbon::parse($factura_insertada->fecha_date)->timezone('Europe/Madrid');
                $factura_insertada->save();

                $factura = \App\Factura::where('idfactura', $factura_insertada['idfactura'])->firstOrFail(); 
                //insertamos las operaciones
                if(!is_null($factura_en_curso['conceptos']))
                {
                    foreach ($factura_en_curso['conceptos'] as $conceptos) {
                        $conceptos_insertado = new OperacionFactura($conceptos);
                        $conceptos_insertado->factura_emitida_id = $factura->id;
                        $conceptos_insertado->save();
                    }   
                }
                return response("Factura Guardada Correctamente.", 200);

            }catch(Exception $e){
                 $factura_insertada->delete();
                 $conceptos_insertado->delete();
            }             
    }
}
