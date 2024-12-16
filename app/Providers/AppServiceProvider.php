<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;

class AppServiceProvider extends ServiceProvider
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
        //
		Schema::defaultStringLength(191); //to suppress migration error "SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long;"
        
		//register policies (only some of them, which dont follow Laravel convention
		Gate::policy(Role::class, RolePolicy::class); //have to manually register this policy as model folder place does not follow Laravel convention. For example, no need for OwnerPolicy
	}
}
