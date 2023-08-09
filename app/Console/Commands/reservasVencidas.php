<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use App\Models\Libro;

class reservasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vencimiento:reserva';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar estado de la reserva cuando esta se venza';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $reservasPorVencer = Reserva::where('estado_reserva', 1)
            ->where('fecha_fin_reserva', '<', now())
            ->get();

        foreach ($reservasPorVencer as $reserva) {

            $libroId = $reserva->id_libro; 

            $libro = Libro::find($libroId);

            $libro->stock_libro += 1;
            
            $libro->save();

            $reserva->update(['estado_reserva' => 4]);

        }

        $this->info('Tarea completada: Estados de reservas actualizados cuando se venció el periodo.');

    }
}
