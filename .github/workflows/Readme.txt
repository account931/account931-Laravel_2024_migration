CI flow for github actions. Runs on every push to main branch.

So far, have 7 jobs:
1. Run PhpUnit tests (& was Codesniffer)
2. Run Psalm check
3. Run Dokerfile and docker-compose.yml test. We build images -> run containers -> check php/console command/sql connectiom/PhpUnit test in container.
  NB: Since we run it in github CI, there is no .env, we have to create it manually. When we start Laravel on Docker in normal way on localhost, there is always a .env.
  Info: we do this wierd test, as can not test Dokerfile and docker-compose.yml in normal way on localhost, since Docker in not supported on Win 7 we use.

4. Codesniffer check
5. Job-5 deploy one file 'last-deploy-info.php' to alwaysdata.com 
6. Job-6 deploy "Laravel_2024_migration" to alwaysdata.com
7. Job-7 send notification "Deploy successful" to telegram 



NB: manual-deploy-to-run-1-time-only.yml => This deploy to production is run manually and one time only. To be triggered by a button in the GitHub Actions UI.
It includes set-up necessary one time only, like Laravel new application key generate, Passport key generating