<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<!-- Status badges -->
[![Laravel](https://github.com/account931/account931-Laravel_2024_migration/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/account931/account931-Laravel_2024_migration/actions/workflows/ci.yml)
![PHP Version](https://img.shields.io/badge/PHP-7.2.10-blue)

> Php 7.2, mysql 5.6, db: 'laravel_2024_migration',
Visual Studio Code ()
     -> VS package extension -> 
           -> PHP Namespace Resolver (to import class -> RMC -> import class)(https://marketplace.visualstudio.com/items?itemName=MehediDracula.php-namespace-resolver)
           -> Git History, GitLense, Php Intellisense, Prittier, Highlight Matching Tag

> A Sept 2024 test to run a new Laravel 6 app from the start with migrations, seeders, factories, model binding, hasMany, ManyToMany relations, Spatie Laravel permission + UI, PhpUnit tests, 
   Rest API resource/collection, Passport API authentication(routes protected by Passport requires that user must be authed via API Login controller (& get token)), 
   Github workflow CI/CD, Font Awesome 5 Icons, Vue JS (Vuex store, router), PHP_CodeSniffer, Psalm static analysis tool, Docker, SSH, cookie consent banner,
   BackPack Admin Panel, Sentry, CloudFlare, etc.

### User login credentials 
<p> see => Database\Seeds\Subfolder\UserSeeder;   or see Factories\UserFactory </p>

<p> ----------------------------------------------------------------------------------------- </p>


### Content
- [1. Install Laravel 6 LTS, php 7.2](#1-install-laravel-6-lts-php-72)
- [2. Tables](#2-tables) 
- [3. New features](#3-new-features) 
- [4. Some notes](#4-some-notes)
- [5. Event/Listener](#5-eventlistener)
- [6. Testing (PhpUnit)](#6-testing-phpunit)
- [7. Passport](#7-passport)
- [8. Spatie Laravel Permission 5.3](#8-spatie-laravel-permission-53)
- [9. Github Workflow Action CI/CD](#9-github-workflow-action-cicd)
- [10. Spatie Laravel Permission GUI](#10-spatie-laravel-permission-gui)
- [11. PHP_CodeSniffer](#11-php_codesniffer)
- [12. Docker](#12-docker)
- [13. Psalm Static Analysis Tool](#13-psalm-static-analysis-tool)
- [14. Vue](#14-vue)
- [15. Notification (via database and email)](#15-notification-via-database-and-email)
- [16. Queue Job](#16-queue-job) 
- [17. Deploy CD](#17-deploy-cd)
- [18. SSH](#18-shh)
- [19. SQL Grafana](#19-sql-grafana)
- [20. Linux mate xfce](#20-linux-mate-xfce)

- [102. Known errors](#102-known-errors)
- [103. Screenshots](#103-screenshots)
- [104. Several commits to one](#104-several-commits-to-one)

<p> ----------------------------------------------------------------------------------------- </p>

## 1. Install Laravel 6 LTS, php 7.2

<p>1. Install => <code> composer create-project --prefer-dist laravel/laravel NAME_HERE "6.*"  </code> </p>
<p>2. Install dependencies => <code> composer install </code> </p>
<p>3. Generates the APP_KEY and writes it to .env => <code> php artisan key:generate </code> </p>
<p>4. In browser can navigate to /public/  => the project should open </p>
<p>5. In console CLI <code> cd NAME_HERE </code> , and <code>git init   git add.   git commit</code> if necessary </p>
<p>6. Create DB and set in <code>.env (DB_DATABASE)</code> </p>

<p>7. <code> php artisan migrate:fresh </code>  or take next step if need Auth. </br>If  on migration error "1071 Specified key was too long;", 
add to app/Providers/AppServiceProvider boot() <code>Schema::defaultStringLength(191); </code> </p>

<p>8. Add Auth to project (cd to folder /NANE_HERE) => 
<ul> 
      <li>composer require laravel/ui "^1.0" --dev    OR  composer require laravel/ui  </li>
	  <li><code> php artisan ui vue --auth  </code>  (it will update routes in routes/web) </li>
	  <li><code> npm install && npm run dev </code> (adds  "Login and "register" to main page)(if this required in CLI as next step, do in Win cmd => npm install But most likely use  var2(tested) => npm install && npm run dev ) </li>
	  <li><code> php artisan migrate   </code>(to get users db out of the box) </li>
</ul>
</p>

<p>9. If any custom migration added later => <code>php artisan migrate </code></br>
     If have seeder  => <code>php artisan db:seed </code>     (we need seeders data in dev not testing, NB: now seeder also contains <code>php artisan migrate:fresh </code>, if not needed disable in seeder)        
</p>
	 
<p>10. Now can add your route menu links and update route '/' instead of return view('welcome'); </br>
If new route is not found => <code>php artisan route:clear</code> </br>    <code> composer dump-autoload </code>
</p>

<p>11. Install Passport personal token (is needed to issue user tokens) => <code>php artisan passport:client --personal </code> 

    php artisan passport:client --personal --name=SomeName #Generate Passport personal token
    php artisan passport:install                           #Passport install
    php artisan passport:keys --force                      #Generates Passport encryption keys
		
</p>

<p>NB: Laravel 6 does not supported: Enums(from php 8.1), Factory trait in model (Laravel 8), seeder ->sequence(), arrow functions (PHP 7.4), 
return type, i.e function x():string {}( PHP 7.4.0), seeding hasMany relation via ->has(), Pest test (PHP 8.2); AssertableJson ( for test) </br>
#If after install css crashes (not found app.css & app.js) -> npm intall -> npm run production
</p>








<p> ----------------------------------------------------------------------------------------- </p>

## 2. Tables
Owners, venues, equipment
Owner can has many Venues, each Venue has 1 Owner (One to Many Relationships: HasMany)
Venues can have many equipments, each equipment may be present in many Venues (Many to Many Relationships: BelongsToMany). Pivot table.








<p> ----------------------------------------------------------------------------------------- </p>

## 3. New features
<ul>
<li>migration, seeder, factory, Implicit Route Model Binding, local scopes, accessor, Api Resources/Collections, phpUnit test, event/listener (on owner create), Github workflow
policies, Spatie RBAC, middleware, Bootstrap Icons 5, console/Commands, Github Actions CI/CD, Docker
</li>
</ul>







<p> ----------------------------------------------------------------------------------------- </p>

## 4. Some notes
{{ $owner->first_name  }}  escaped html </br>
{!! $owner->first_name  !!}  unescaped thml
{{-- This comment will not be present in the rendered HTML --}}   comment
composer dump-autoload
<p>git restore . is supported from git 2.23+ only, use git checkout . (or git checkout --compose.json)  ==== git clean -fd </p>






<p> ----------------------------------------------------------------------------------------- </p>

## 5. Event/Listener
Event/Listener => Models\Owner ($dispatchesEvents = [event/listener]), Event is bound to Listener in Providers\EventServiceProvider, app\Events\OwnerCreated & app\Listeners\SendOwnerCreatedNotification themselves.






<p> ----------------------------------------------------------------------------------------- </p>

## 6. Testing (PhpUnit)
OK (65 tests, 974 assertions) -> Tests: 76, Assertions: 1028  </br>

1. create .env.testing and set 'DN_NAME_testing' there. Create a testing db itself, juxtapose to original DB in phpMyAdmin.i.e "laravel_2024_migration_testing"
2. Before testing, first time ever, do migrate tables to test database (dont seed as we run them in test itself), if have issues  <code> php artisan migrate:fresh --env=testing </code>
3. If tests are failing, clear cache in testing environment <code> php artisan config:cache --env=testing </code>
4. Run all tests    <code> php ./vendor/bin/phpunit </code>  OR  <code> php vendor/phpunit/phpunit/phpunit </code>  OR shortcut defined in composer.json <code>composer run-my-tests </code>
                        
  <p>Run one test Class => <code>  php ./vendor/bin/phpunit tests/Feature/Http/Api/Owners/OwnerControllerTest.php </code> </p>
  
  <p>Run one method from test Class =>   --filter {methodName} {pathToClass} => <code> php ./vendor/bin/phpunit --filter testCreatesNewOwnerWithVenues tests/Feature/Http/Controllers/Owner/OwnerControllerTest.php </code> </p>

4.1 If u run migration and it goes to wrong DB (prod or test) => php artisan config:cache
5. To see test errors =>  $this->withoutExceptionHandling(); //to see errors
6. Best Test example => Tests\Feature\Http\Api\Owners\OwnerControllerTest;





<p> ----------------------------------------------------------------------------------------- </p>

## 7. Passport
<p> https://www.twilio.com/en-us/blog/build-secure-api-php-laravel-passport </p>
#to be able to generate users access tokens (on login, register, etc)) u should firstly generate personal access token =>  <code> php artisan passport:client --personal  </code>
<p> for tests, you run this command programmatically in code, see example in Tests\Feature\Http\Api\Api_Auth\ApiRegisterTest;
<p>Api unathenticated message is set in App\Exceptions\Handler</p>
<p> Passport is enabled in routes/api with => <b> Route::middleware('auth:api')->group(.. </b> <br>, to access Passport protected route you send a header with Passport token in request ('Authorization' => 'Bearer '.$bearerToken,). Can see example in routes/console => find => 'test_api_route_protected_by_Passport'
Passport just checks if user is logged or not for API </p>


Necessary set-up:
  <code>
   php artisan passport:client --personal --name=SomeName #Generate Passport personal token
   php artisan passport:install                           #Passport install
   php artisan passport:keys --force                      #Generates Passport encryption keys
 </code>
<p> ----------------------------------------------------------------------------------------- </p>





## 8. Spatie Laravel permission 5.3 
=> https://spatie.be/docs/laravel-permission/v6/installation-laravel
 <code> php artisan permission:cache-reset </code>
  a.)define policy by model, e.g => App\Policies\OwnerPolicy 
  b.) register policy in AuthServiceProvider 
  c.)use in  Controller => $this->authorize('view', Owner::class); //must have, Policy check (403 if fails) 
  d.) Spatie can be used both for http(sessions) and Api(token) requests (Api permission must be created with {'guard_name' => 'api'})  (No need for  additional set-up, like in "Laravel_Vue_Blog_V6_Passport" 
  <p> Spatie checks if user has certain permission, if used together with Passport, Spatie works first, Passport second </p>
  
 <p> ----------------------------------------------------------------------------------------- </p>
 
 
 
 
 
 
 
 
 
## 9. Github workflow action CI/CD
For example how to run PhpUnit tests, codesniffer, Pslam on github CI on every commit push, see  => .github/workflow/ci.yml
<p>See CD deploy part example  => https://medium.com/@ikbenezer/automate-your-laravel-app-deployment-with-github-actions-ab7b2f7417f2  </p>
 
<p> ----------------------------------------------------------------------------------------- </p>
 
 
 
 
 
 
 
 
 
 
## 10. Spatie Laravel permission GUI 
=> https://github.com/LaravelDaily/laravel-permission-editor

## Modifying package by fork 
=> fork, pull to local, edit, push. Add changes to composer.json => add "repositories" +  change package in "require" + composer update
https://phpreel.medium.com/how-to-use-a-forked-laravel-package-instead-of-the-original-90dd5b64068a
https://snippets.khromov.se/composer-use-your-own-fork-for-a-package/

<p>Forked packages current status: forked package to my github -> edited -> changed composer.json  NOT FINISHED</p>
https://github.com/account931/laravel-permission-editor-my-modified

<p>Final result for Spatie Laravel permission GUI  : fork is not finished, used just for test, has copy-paste package https://github.com/LaravelDaily/laravel-permission-editor and modified it + re-wrote from TailWind Css to Bootstrap 4 </p>






<p> ----------------------------------------------------------------------------------------- </p>

## 11. PHP_CodeSniffer
> config goes to => phpcs.xml.dist
<p> Run check (if Globally installed)   => <code> phpcs c:\Users\user\Downloads\OSPanel\domains\localhost\Laravel_2024_migration </code> </p>
<p> Run check (if installed in project) =>  <code> php vendor/bin/phpcs </code>   OR as defined in composer.json script <code> composer codesniffer-check </code> </p>
<p> Run fix   (if installed in project) =>  <code> php vendor/bin/phpcbf </code>

If "php vendor/bin/phpcs" finds an error and u want to disable it => run <code> php vendor/bin/phpcs -s </code> and see details like <b>  Missing file doc comment (PEAR.Commenting.FileComment.Missing) </b>
, after add it to /phpcs.xml.dist  => <exclude name="PEAR.Commenting.FileComment.Missing"/>





<p> ----------------------------------------------------------------------------------------- </p>

## 12. Docker 
<p><b> /docker/Dockerfile  </b>    => it is instruction for building container images    </p>
<p><b> /docker-compose.yml </b>    => configuration for launching containers from images </p>

If u use Sail, you dont need Dockerfile, as Sail uses pre-build images

<code> docker-compose build </code>  => build images
<code> docker-compose up -d </code>  => start containers 

<p> After containers are running, do usual stuff to launch Laravel </p>
<p>
Starts a new shell session inside the container <code>docker exec -it laravel_app bash</code>, i.e <code>docker exec -it <container_name_or_id> bash </code> </br>
Find container name by <code> docker ps </code>
</p> 

OR
<p>To run inside container: </p>
<p><code>docker-compose exec my_larav_931_app composer install </code> => install dependencies in container, {my_larav_931_app} is php/apache container </p>
<p><code>docker-compose exec  php artisan migrate </code> </p>




Laravel goes to    => http://localhost                 </br>
PhpMyAdmin goes to => http://localhost:8080        (login=user, pass=password)

<p><b> Using Docker on localhost: </b> </p>
<p> If you decide to use Docker on localhost instead of OpenServer, install Docker desktop & make sure to make changes to <b>.env </b> & <b>.env.testing </b> that correspond to values in <b>{docker-compose.yml}</b>, e.g <b>(DB_HOST=my_sql_db_container, DB_DATABASE=laravel_2024_migration, DB_USERNAME=user, DB_PASSWORD=password )</b>, or u can simply copy/paste from in <b> /env_donor_for_cicd </b></p>
<p> 
When we test Docker in github CI we have to create <b>.env  </b> manually, as it is in .gitignore & .env is not in github.
</p>
_____________________________________

<p></br><b>Running Docker on Linux (start, stop, etc)</b></p>
<p>
<code> sudo systemctl start docker  </code>  #Start Docker daemon (Docker service)
<code> docker compose up -d </code>  #start docker-compose.yml
<code> docker ps </code>             #list containers
<code> docker exec -it laravel_app  /bin/bash  </code>  log to container
<code> exit </code>                 #leave container
<code> docker stop $(docker ps -q) && docker rm $(docker ps -a -q) </code>  #stop and remove all containers, V1
<code> docker compose down </code>     #stop and remove all containers, V2


<p></br><b>If using Sail</b></p>
<code> php artisan sail:install  </code>   #publish docker-compose.yml to project and select sql service u want to use
<code> ./vendor/bin/sail up </code>  start
<code> ./vendor/bin/sail down </code>  stop


<p> <b>Docker Permission issue (when open site in Chrome)</b></p>
<code> dfind ~/ -type d -name storage </code>  #find  and copy your storage

<code> sudo chown -R www-data:www-data /path/to/your-laravel-app/storage  </code> #give permission
<code> sudo chmod -R 775 /path/to/your-laravel-app/storage </code>                #give permission

e.g
<code> sudo chown -R www-data:www-data /home/dima/Development/Portal_2025/storage  </code> #give permission
<code> sudo chmod -R 775 /home/dima/Development/Portal_2025/storage  </code>               #give permission



<p></br><b>Clear docker cache</b></p>
docker builder prune -a
docker system prune -a
</p>

<p><b>Npm on Docker</b></p>
Instead of putting new Node service to docker-compose.yml you may simply use your local installed Node/Npm (just dont go container)



<p> ----------------------------------------------------------------------------------------- </p>

## 13. Psalm static analysis tool
Run Psalm check          => <code> php vendor/bin/psalm --no-cache </code> </br>
Generate a baseline file => <code> php vendor/bin/psalm --set-baseline </code>  (psalm-baseline.xml) </br>
Config goes to           => <b> psalm.xml </b>
<p> ----------------------------------------------------------------------------------------- </p>







<p> ----------------------------------------------------------------------------------------- </p>

## 14. Vue
  Run {npm run watch} to watch changes
  
  Mapbox => npm install mapbox-gl











<p> ----------------------------------------------------------------------------------------- </p>

## 15. Notification (via database and email)
php artisan notifications:table  => create migration for table 'notifications'. Then run <code> php artisan migrate </b>

 public function via($notifiable){return ['database', 'mail']; 
 
 
## Notification (via email) (https://mailtrap.io/)
Register at https://mailtrap.io/ get and add credentials to .env =>  MAIL_HOST=sandbox.smtp.mailtrap.io, MAIL_USERNAME, etc  </br>
Could see received email at => https://mailtrap.io/  (ac**@ukr.net, )
<p> ----------------------------------------------------------------------------------------- </p>









<p> ----------------------------------------------------------------------------------------- </p>

## 16. Queue Job
 Set up: 
   </br> create db table 'jobs' => <code> php artisan queue:table </code>, run migration, add to  .env =>  QUEUE_CONNECTION=database </br>
   </br> in .env => QUEUE_CONNECTION=database
 
 <p>Run job => ProcessPodcast::dispatch($podcast);  </p>
 php artisan queue:work  </br>
<p> ----------------------------------------------------------------------------------------- </p>



<p> ----------------------------------------------------------------------------------------- </p>



## 17. Deploy CD
(CD is the part of CI/CD) </br>

Deploy is performed when u push smth to main branch in Github, via Github actions (CI/CD): 
Steps
1. If you deploy it first time ever, create folder on server 'Laravel_2024_migration' (as specified in job_6 in /github/workflows/ci.yml) 
2. Manually copy.env to server (SSH || FTP)) 
4. Push smth to main branch, it will trigger job_6 in /github/workflows/ci.yml (it will copy code, run composer install, migrate, etc) 
3. Run one time job manually by a button in the GitHub Actions UI <b> github/workflows/manual-deploy-to-run-1-time-only.yml  </b>
 or run the content of that file in SSH manually, for example:
     <code>
	   php artisan passport:client --personal --name=SomeName
       php artisan passport:install
       php artisan passport:keys --force
	 </code>

Laravel on production server is 57 Mb (without composer development dependencies (only production dependencies) and /node_modules) . NB: no need for node_modules on Production </br>

# Current variant: now both Php/apache service and SQL DB are running at https://www.alwaysdata.com </br>
     https://www.alwaysdata.com    =>  (acc**1@ur*.n*t)  (m**1 + letter)   DB: dima_laravel_2024_migration  
           deployed web-site => https://dima.alwaysdata.net/Laravel_**********/   </br>
		   

# Old variant:Php/apache service was running at render.com, and was connected to SQL service located at https://www.alwaysdata.com        </br>
   Php/apache     => render.com  (accou**1@ur*.n*t)  uses render.yaml  https://account931-laravel-2024-migration.onrender.com  </br>

Tried also (DELETE this )=>  https://console.prisma.io/    (acc**1@ur*.n*t)  (m**1 + letter x2)   </br>
               

			   
Grafana =>  https://acc****1.grafana.net/    =>   acc****1  (without mail) (ma***1 + coreletter) </br>
Dashboards -> Live from AlwaysData_SQL (show data from DB at www.alwaysdata.com)  </br>

Infinity data source used in Grafana (gets Api from https://account931-laravel-2024-migration.onrender.com/public/api/owners) (may be down as service sleeps when inactive)









<p> ----------------------------------------------------------------------------------------- </p>

## 18. SSH
How to set-up connection via SSH (in our case we just testing transferring 1 file to remote server https://www.alwaysdata.com  in github action job):
Using SSH client:Putty OR use GIT Bash <code> ssh username@host </code>, e.g <code> ssh some-login.alwaysdata.net </code>  

 SSH host: ssh-di*****.alwaysdata.net  login:di***    p: m****+l



 <p> To set up ssh for github actions, we need to generate public and private ssh keys using Puttygen or similar, in our case we save the keys to  C:\Users\user\Downloads\Putty_SSH\: </p>
 ---

## Private key => id_rsa  =>(will go  to github secrets->SSH_PRIVATE_KEY & in git action we use secrets, like  secrets.SSH_PRIVATE_KEY )

If Puttygen generates private key as .ppk format, we need to convert it from id_rsa.pkk (or private_key.pkk) to OpenSSH Format (using Puttygen: select 'load' -> select private_key.pkk -> Conversions -> Export OpenSSH key -> save)

In github project: <b>Settings -> Secrets-> Actions-> New repo secrets </b>(if not created so far) and  paste everything from opened in editor private key file, including:
    <code>
     -----BEGIN RSA PRIVATE KEY-----
        .......
     -----END RSA PRIVATE KEY-----
	 </code>

and save as  <b> SSH_PRIVATE_KEY </b>


//--------------------------------------

## Public key  => id_rsa.pub  (will go to remote srever)


1. Make sure the .ssh directory and authorized_keys file exist on the remote server. They will be hidden, so check with <code> ls -a </code> 
You can create .ssh directory and authorized_keys file with:

in SSH => 
    <code>
        mkdir -p ~/.ssh                  #create directory
        touch ~/.ssh/authorized_keys     #Creates the file authorized_keys in the ~/.ssh/ directory if it does not already exist. If the file does exist, touch simply updates the file's "last modified" timestamp without changing its content.
        chmod 700 ~/.ssh                 #set permission
        chmod 600 ~/.ssh/authorized_keys
    </code>

2. If public key on your local starts with (view in editor) :
   <code>
   ---- BEGIN SSH2 PUBLIC KEY ----
   Comment: "rsa-key-20250527"
   ...
   </code>


it should be converted to OpenSSH Format  before moving to remote server. Converted should start with "ssh-rsa AAAAB...."
When have converted add the key to remote server with:

<code>
    echo "ssh-rsa AAAAB3N........." >> ~/.ssh/authorized_keys         #prints the public key string and appends that string to the file authorized_keys in your .ssh directory.
    chmod 600 ~/.ssh/authorized_keys
</code>

 
 
 
 
 
 
 
<p> ----------------------------------------------------------------------------------------- </p>
 
## 19. Sql Grafana


<p>Example 1:  Select & display every owner, count his venues and equipment quantity, display owner's all venues, display equipment taht belongs to owner's venues </p>

<code>
 SELECT
    o.first_name AS owner_name,
    COUNT(DISTINCT v.id) AS venue_count,
    COUNT(DISTINCT e.id) AS equip_count,
    GROUP_CONCAT(DISTINCT v.venue_name ORDER BY v.venue_name SEPARATOR ', ') AS venue_names,                                        # all owner venues in one column
	GROUP_CONCAT(DISTINCT CONCAT(e.trademark_name, ' ', e.model_name) ORDER BY e.trademark_name SEPARATOR ', ') AS equipment_names  #to list owner 'trademark_name + model name' in one column
    #GROUP_CONCAT(DISTINCT e.trademark_name ORDER BY e.trademark_name SEPARATOR ', ') AS equipment_names,                           #to list all owner 'trademark_name' in one column: [eq_trade_name1,  eq_trade_name_2, eq_trade_name_3,  eq_trade_name_4]
	#GROUP_CONCAT(DISTINCT e.model_name ORDER BY e.model_name SEPARATOR ', ') AS eq_model_names                                     # to list all owner  'model_name'in one column    : [eq_model_name1, eq_model_name_2, eq_model_name_3,  eq_model_name4 ]
FROM owners o
LEFT JOIN venues v ON v.owner_id = o.id
LEFT JOIN equipment_venue ev ON ev.venue_id = v.id
LEFT JOIN equipments e ON e.id = ev.equipment_id
GROUP BY o.id, o.first_name
ORDER BY o.first_name;
</code>

 Result will be :
 -----------------------------------------------------------------------------------------------------------------
 |owner_name|venue_count|equip_count|venue_names   |     equipment_names                                          |
  ----------------------------------------------------------------------------------------------------------------
 |Owner_1   |    2      |     4     | venue1_name, | 1.trademark_name + model_name, 2.trademark_name + model_name |
 |          |           |           | venue2_name  | 3.trademark_name + model_name, 4.trademark_name + model_name |
 |          |           |           |              |                                                              |
 ------------------------------------------------------------------------------------------------------------------
 |Owner_2   |    2      |     4     | venue1_name, |  same.........                                               |
 |          |           |           | venue2_name  |                                                              |
 ------------------------------------------------------------------------------------------------------------------
 
 
 
 
 //------------------------------
 
 
 
 <p> Example 2: Select & display every owner,</p>
 <code>
 SELECT
  o.id AS owner_id,
  o.first_name AS owner_name,
  v.id AS venue_id,
  v.venue_name AS venue_name,
  e.id AS equipment_id,
  e.trademark_name,
  e.model_name
FROM owners o
JOIN venues v ON v.owner_id = o.id
LEFT JOIN equipment_venue ev ON ev.venue_id = v.id
LEFT JOIN equipments e ON e.id = ev.equipment_id
ORDER BY o.id, v.id, e.trademark_name;

 </code>
 
  Result will be :
 ------------------------------------------------------------------------------------------------------------------------
 | owner_id |owner_name     |  venue_id |venue_name    |  equipment_id  |equipment_trademark_name |equipment_model_name  |
  -----------------------------------------------------------------------------------------------------------------------
 |   1      |  owner_1_name |     1     | venue1_name, |    1           |  trademark_name1        | model_name1          |
 -------------------------------------------------------------------------------------------------------------------------
 |   1      |  owner_1_name |     1     | venue1_name, |    2           |  trademark_name2        | model_name2          |
 | -------------------------------------------------------------------------------------------------------------------------
 |   1      |  owner_1_name |     2     | venue2_name, |    3           |  trademark_name3        | model_name3          |
 |-------------------------------------------------------------------------------------------------------------------------
 |   1      |  owner_1_name |     2     | venue2_name, |    4           |  trademark_name4        | model_name4          |
 ------------------------------------------------------------------------------------------------------------------------
 |   same for owner 2..............                                                                                       |
 -------------------------------------------------------------------------------------------------------------------------
 
 
 //-----------------------------------------------------------
 
 
The most important rule when using GROUP BY in SQL is: if you use <b>GROUP BY</b> very column in the <b>SELECT</b> clause that is not inside an aggregate function must appear in the <b>GROUP BY</b> clause.

The GROUP BY clause in SQL is used to group rows that have the same values in specified columns into summary rows, like finding the total, average, or count. It's commonly used with aggregate functions like COUNT(), SUM(), AVG(), MIN(), and MAX().
 
 HAVING is like WHERE but for groups.
 <code>
    SELECT customer_id, COUNT(*) AS orders_count
    FROM orders
    GROUP BY customer_id
    HAVING COUNT(*) > 5;
 </code>
 
 


 <p> ----------------------------------------------------------------------------------------- </p>

 ## 20. Linux mate xfce

<b>Install Docker</b></br>
Apologies for the earlier confusion. Linux Mint 22.1 "Xia" is based on Ubuntu 24.04 LTS, codenamed "Noble Numbat." To install Docker on Linux Mint 22.1, you need to configure the Docker repository to use the Ubuntu "noble" codename instead of "xia. </br>


sudo apt update
sudo apt install ca-certificates curl gnupg


curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu noble stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt update

sudo apt install docker-ce docker-ce-cli containerd.io


sudo apt install docker-ce docker-ce-cli

sudo systemctl status docker    #verify composer installed



sudo usermod -aG docker $USER
newgrp docker




-------------------------
<b>Install Composer</b>  </br>
sudo apt update
sudo apt install php-cli php-curl php-mbstring unzip curl

curl -sS https://getcomposer.org/installer -o composer-setup.php   #get installer
sudo php composer-setup.php --install-dir=/usr/local/bin –filename=composer
rm composer-setup.php    # remove installer


------------------------------
<b>Install Git</b>  </br>

sudo apt update
sudo apt install git

-----------------
<b>Install Git GUI </b>  </br>
Git GUI (start with <code> git gui  </code>)
sudo apt update
sudo apt install git-gui


-----------------
<b>Install Notepadqq </b>  </br>
 
sudo apt update
sudo apt install notepadqq




-----------
<b>Install Visual Studio Code </b></br>

wget -qO- https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > packages.microsoft.gpg
sudo install -o root -g root -m 644 packages.microsoft.gpg /usr/share/keyrings/

echo "deb [arch=amd64 signed-by=/usr/share/keyrings/packages.microsoft.gpg] \
https://packages.microsoft.com/repos/code stable main" | \
sudo tee /etc/apt/sources.list.d/vscode.list

sudo apt update
sudo apt install code



-----------
<b>Install Node.js </b></br>

curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs



-----------
<b>Install FileZilla </b></br>

sudo apt update
sudo apt install filezilla

-----------
<b>Git set up</b></br>
<code>git config core.fileMode false  </code>               #tell git to ignore mode changes
<code>git config --global core.editor "code –wait"</code>   #set vs code for commits messages
<code> git config --global init.defaultBranch main</code>   #to set main as the default branch name for all new

<code>git remote -v </code>           #check if has already connection to git repo
<code>git remote add origin https://github.com/username/repo.git </code>
<code>git push --set-upstream origin main</code>
 
 
 
<p> ----------------------------------------------------------------------------------------- </p>
## 102. Known errors
 1. Error 'There is no permission named `delete owners` for guard `web`.'  => $permissionDeleteOwner = Permission::firstOrCreate([ 'name' => 'delete owners', 'guard_name' => 'web' ]);  </br>
 2. Error on PhpUnit tests, when new test returns several Users from DB, while there should be zero =>  using in tests & in /database/seeds this => DB::table('users') ->truncate(); </br>
 
 3. Error on Render.com (css/js not loading) 'Mixed Content: The page at 'Your_page' was loaded over HTTPS, but requested an insecure stylesheet 'Your_page/public/css/app.css'. This request has been blocked; the content must be served over HTTPS.' </br>
      =>    fix  see at =>  App\Http\Middleware\TrustProxies   </br>
 
 4. If Js/Vue is creashing, not working, just => Chrome => Settings => Privace => Clear cache




<p> ----------------------------------------------------------------------------------------- </p>

## 103. Screenshots
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

> Vue, Vuex store, router
![Screenshot](public/img/screenshots/vue-1.png)
![Screenshot](public/img/screenshots/vue-2.png)

> Venues store locator
![Screenshot](public/img/screenshots/storeLocator.png)

> Grafana Live from alwaysdata.com
![Screenshot](public/img/screenshots/grafana.png)

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

<p> ----------------------------------------------------------------------------------------- </p>


## 104. Several last commits to one 
(for example 2 last)
<code>git reset --soft HEAD~2 </code>
<code>git commit -m "new commit message" <code>
<code>git push -f <code>


<p> Squash several commits to one (not last) </p>
git rebase -i HEAD~3    #3 is number of last commits to open in editor
change 'pick'  to 'squash' in commits you want to squash to prev commit (it will be merged to prev commit)



Bootstrap 3: class="col-sm-12 col-xs-12"
Bootstrap 4: class="col-12 col-sm-12"   
