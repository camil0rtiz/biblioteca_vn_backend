<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Reserva;

class membresiasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vencimiento:membresia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar estado del usuario cuando se venza la membresía';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $usuariosMembresiaVencida = User::where('estado_usuario', 1)
            ->whereHas('membresias', function ($query) {
                $query->where('fecha_venci_membresia', '<', now());
            })->get();

        foreach ($usuariosMembresiaVencida as $usuario) {
            
            $usuario->update(['estado_usuario' => 3]);

        }

        $this->info('Tarea completada: Estados de usuarios actualizados cuando se venció la membresía.');

    }
}
