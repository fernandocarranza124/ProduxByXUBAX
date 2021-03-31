<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('administrador', __('Administrador'), [
            'create-product',
            'read-product',
            'update-product',
            'delete-product',
            'create-categoria',
            'read-categoria',
            'update-categoria',
            'delete-categoria',
            'create-member',
            'read-member',
            'update-member',
            'delete-member',
        ])->description(__('Los Administradores pueden ejecutar cualquier accion.'));

        Jetstream::role('creador', __('Creador'), [
            'create-product',
            'read-product',
            'update-product',
            'create-categoria',
            'read-categoria',
            'update-categoria',
            'create-member',
            'read-member',
            'update-member',
        ])->description(__('Los creadores tienen el permiso de ver, crear y actualizar dispositivos, categorias y miembros del equipo.'));

        Jetstream::role('editor', __('Editor'), [
            'read-product',
            'update-product',
            'read-categoria',
            'update-categoria',
            'read-member',
            'update-member',
        ])->description(__('Los editores tienen el permiso de very actualizar dispositivos, categorias y miembros del equipo.'));

        Jetstream::role('monitor', __('Monitorista'), [
            'read-product',
            'read-categoria',
            'read-member',
        ])->description(__('Los monitores unicamente tienen el permiso de ver dispositivos, categorias y miembros del equipo.'));
    }
}
