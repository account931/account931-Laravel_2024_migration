<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

> A Sept 2024 test to run a new Laravel 6 app from the start with migrations, seeders, factories, model binding, hasMany, ManyToMany relations, Spatie Laravel permission + UI, PhpUnit tests, 
   Rest API resource/collection, Passport API authentication(routes protected by Passport requires that user must be authed via API Login controller (& get token)), 
   Github workflow, Font Awesome 5 Icons, Vue JS (Vuex store, router) etc.

## User login credentials, see => Database\Seeds\Subfolder\UserSeeder;   or see Factories\UserFactory

<p> ----------------------------------------------------------------------------------------- </p>

## Install Laravel 6 LTS, php 7.2

<p>1. Install => <code> composer create-project --prefer-dist laravel/laravel NAME_HERE "6.*"  </code> </p>
<p>2. In browser can navigate to /public/  => the project should open </p>
<p>3. In console CLI <code> cd NAME_HERE </code> , and <code>git init   git add.   git commit</code> if necessary </p>
<p>4. Create DB and set in <code>.env (DB_DATABASE)</code> </p>

<p>5. <code>php artisan migrate </code>  or take next step if need Auth. </br>If  on migration error "1071 Specified key was too long;", 
add to app/Providers/AppServiceProvider boot() <code>Schema::defaultStringLength(191); </code> </p>
<p>5.1. Add Auth to project (cd to folder /NANE_HERE) => 
<ul> 
      <li>composer require laravel/ui "^1.0" --dev    OR  composer require laravel/ui  </li>
	  <li><code> php artisan ui vue --auth  </code>  (it will update routes in routes/web) </li>
	  <li><code> npm install && npm run dev </code> (adds  "Login and "register" to main page)(if this required in CLI as next step, do in Win cmd => npm install But most likely use  var2(tested) => npm install && npm run dev ) </li>
	  <li><code> php artisan migrate   </code>(to get users db out of the box) </li>
</ul>
</p>

<p>5.2. If any custom migration added later => <code>php artisan migrate </code></br>
     If have seeder                      => <code>php artisan db:seed </code> 
</p>
	 
<p>6. Now can add your route menu links and update route '/' instead of return view('welcome'); </br>
If new route is not found => <code>php artisan route:clear</code> </br>                            <code> composer dump-autoload </code>
</p>

<p>6. Install Passport personal token (is needed to issue user tokens) => <code>php artisan passport:client --personal </code> 
</p>

<p>NB: Laravel 6 does not supported: Enums(from php 8.1), Factory trait in model (Laravel 8), seeder ->sequence(), arrow functions (PHP 7.4), 
return type, i.e function x():string {}( PHP 7.4.0), seeding hasMany relation via ->has(), Pest test (PHP 8.2); AssertableJson ( for test) </br>
#If after install css crashes (not found app.css & app.js) -> npm intall -> npm run production
</p>

<p> ----------------------------------------------------------------------------------------- </p>

## Tables
Owners, venues, equipment
Owner can has many Venues, each Venue has 1 Owner (One to Many Relationships: HasMany)
Venues can have many equipments, each equipment may be present in many Venues (Many to Many Relationships: BelongsToMany). Pivot table.

<p> ----------------------------------------------------------------------------------------- </p>

## New features
<ul>
<li>migration, seeder, factory, Implicit Route Model Binding, local scopes, accessor, Api Resources/Collections, phpUnit test, event/listener (on owner create), Github workflow
policies, Spatie RBAC, middleware, Bootstrap Icons 5, console/Commands, Github Actions CI/CD
</li>
</ul>

<p> ----------------------------------------------------------------------------------------- </p>

## Some notes
{{ $owner->first_name  }}  escaped html </br>
{!! $owner->first_name  !!}  unescaped thml
{{-- This comment will not be present in the rendered HTML --}}   comment
composer dump-autoload
<p>git restore . is supported from git 2.23+ only, use git checkout . (or git checkout --compose.json)  ==== git clean -fd </p>

<p> ----------------------------------------------------------------------------------------- </p>

##Event/Listener
Event/Listener => Models\Owner ($dispatchesEvents = [event/listener]), Event is bound to Listener in Providers\EventServiceProvider, app\Events\OwnerCreated & app\Listeners\SendOwnerCreatedNotification themselves.


<p> ----------------------------------------------------------------------------------------- </p>


## Testing (PhpUnit)
1. create .env.testing and set 'DN_NAME_testing' there. Create a testing db itself, juxtapose to original DB in phpMyAdmin.i.e "laravel_2024_migration_testing"
2. Before testing, first time ever, do migrate tables to test database (dont seed as we run them in test itself), if have issues  <code> php artisan migrate:fresh --env=testing </code>
3. If tests are failing, clear cache in testing environment <code> php artisan config:cache --env=testing </code>
4. Run all tests    <code> php ./vendor/bin/phpunit </code>  OR  <code> php vendor/phpunit/phpunit/phpunit </code>  OR shortcut defined in composer.json <code>composer run-my-tests </code>
                        
  <p>Run one test => <code>  php ./vendor/bin/phpunit tests/Feature/Http/Api/Owners/OwnerControllerTest.php </code> </p>

4.1 If u run migration and it goes to wrong DB (prod or test) => php artisan config:cache
5. To see test errors =>  $this->withoutExceptionHandling(); //to see errors
6. Best Test example => Tests\Feature\Http\Api\Owners\OwnerControllerTest;

<p> ----------------------------------------------------------------------------------------- </p>


## Passport
<p> https://www.twilio.com/en-us/blog/build-secure-api-php-laravel-passport </p>
#to be able to generate users access tokens (on login, register, etc)) u should firstly generate personal access token =>  <code> php artisan passport:client --personal  </code>
<p> for tests, you run this command programmatically in code, see example in Tests\Feature\Http\Api\Api_Auth\ApiRegisterTest;
<p>Api unathenticated message is set in App\Exceptions\Handler</p>

<p> ----------------------------------------------------------------------------------------- </p>


## Spatie Laravel permission 5.3 
=> https://spatie.be/docs/laravel-permission/v6/installation-laravel
 <code> php artisan permission:cache-reset </code>
 <p> a.)define policy by model, e.g => App\Policies\OwnerPolicy </p>
 <p>b.) register policy in AuthServiceProvider </p>
 <p>c.)use in  Controller => $this->authorize('view', Owner::class); //must have, Policy check (403 if fails) </p>
 <p>d.) Spatie can be used both for http(sessions) and Api(token) requests (Api permission must be created with {'guard_name' => 'api'})  (No need for  additional set-up, like in "Laravel_Vue_Blog_V6_Passport" </p>

 <p> ----------------------------------------------------------------------------------------- </p>
 
 
##Github workflow action CI/CD
For example run tests (CI) on github on every commit push, see  => .github/workflow/ci.yml
<p>See CD part => https://medium.com/@ikbenezer/automate-your-laravel-app-deployment-with-github-actions-ab7b2f7417f2  </p>
 
<p> ----------------------------------------------------------------------------------------- </p>
 
 
## Spatie Laravel permission GUI 
=> https://github.com/LaravelDaily/laravel-permission-editor

## Modifying package by fork 
=> fork, pull to local, edit, push. Add changes to composer.json => add "repositories" +  change package in "require" + composer update
https://phpreel.medium.com/how-to-use-a-forked-laravel-package-instead-of-the-original-90dd5b64068a
https://snippets.khromov.se/composer-use-your-own-fork-for-a-package/

<p>Forked packages current status: forked package to my github -> edited -> changed composer.json  NOT FINISHED</p>
https://github.com/account931/laravel-permission-editor-my-modified

<p>Final result for Spatie Laravel permission GUI  : fork is not finished, used just for test, has copy-paste package https://github.com/LaravelDaily/laravel-permission-editor and modified it + re-wrote from TailWind Css to Bootstrap 4 </p>

<p> ----------------------------------------------------------------------------------------- </p>


## Screenshots
![Screenshot](public/img/screenshots/owner2.png)
![Screenshot](public/img/screenshots/ownerOne4.png)
![Screenshot](public/img/screenshots/List1.png)
![Screenshot](public/img/screenshots/List2.png)

> Api resource
![Screenshot](public/img/screenshots/owner_api.png)

> Password update
![Screenshot](public/img/screenshots/password_update.png)

> Spatie Laravel permission UI (my custom)
![Screenshot](public/img/screenshots/spatie-ui-mine.png)



> Forked (modified) Spatie Laravel permission UI ( from https://github.com/LaravelDaily/laravel-permission-editor) (to my https://github.com/LaravelDaily/laravel-permission-editor)
![Screenshot](public/img/screenshots/spatie-ui-package-forked.png)

> Spatie Laravel permission UI package, re-written from TailWind Css to Bootstrap 4  
![Screenshot](public/img/screenshots/spatie-ui-mine-edited-package.png)
![Screenshot](public/img/screenshots/spatie-ui-mine-edited-package-2.png)


<p> ----------------------------------------------------------------------------------------- </p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Several commits to one (for example 2 last)
<code>git reset --soft HEAD~2 </code>
<code>git commit -m "new commit message" <code>
<code>git push -f <code>