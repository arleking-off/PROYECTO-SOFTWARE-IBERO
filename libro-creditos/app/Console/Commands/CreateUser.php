<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Crear un nuevo usuario de forma interactiva';

    public function handle()
    {
        $this->info('=== CREAR NUEVO USUARIO ===');
        $this->newLine();

        // Solicitar datos
        $name = $this->ask('Nombre completo del usuario');
        $email = $this->ask('Email del usuario');

        // Validar email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            $this->error('Error: ' . $validator->errors()->first('email'));
            return 1;
        }

        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        $passwordConfirm = $this->secret('Confirmar contraseña');

        // Validar contraseñas
        if ($password !== $passwordConfirm) {
            $this->error('Las contraseñas no coinciden');
            return 1;
        }

        if (strlen($password) < 8) {
            $this->error('La contraseña debe tener al menos 8 caracteres');
            return 1;
        }

        // Confirmar creación
        $this->newLine();
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Nombre', $name],
                ['Email', $email],
                ['Contraseña', str_repeat('*', strlen($password))]
            ]
        );

        if (!$this->confirm('¿Deseas crear este usuario?', true)) {
            $this->warn('Operación cancelada');
            return 0;
        }

        // Crear usuario
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);

            $this->newLine();
            $this->info('✅ Usuario creado exitosamente');
            $this->table(
                ['ID', 'Nombre', 'Email'],
                [[$user->id, $user->name, $user->email]]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error('Error al crear usuario: ' . $e->getMessage());
            return 1;
        }
    }
}
