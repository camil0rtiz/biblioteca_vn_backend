<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use Carbon\Carbon;

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
    protected $description = 'Cambiar estado de reservas después de 15 días';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $limiteDias = 15;

        // $reservasPorVencer = Reserva::where('estado_reserva', 1)
        //     ->whereDate('fecha_reserva', '<=', Carbon::now()->subDays($limiteDias))
        //     ->get();

        // foreach ($reservasPorVencer as $reserva) {
            
        //     $reserva->update(['estado_reserva' => 4]);

        // }
    }
}
