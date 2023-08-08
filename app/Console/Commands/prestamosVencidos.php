<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;

class prestamosVencidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vencimiento:prestamo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar estado del pretamo cuando este se venza';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $prestamosVencidos = Prestamo::where('estado_prestamo', 1)
            ->where('fecha_entre_prestamo', '<', now())
            ->get();

        foreach ($prestamosVencidos as $prestamo) {
    
            $prestamo->update(['estado_prestamo' => 2]);

        }

        $this->info('Tarea completada: Estados de prestamos actualizados cuando se venció el perioso de entrega del libro.');
    }
}
