CI flow for github actions. Runs on every push to main branch.

So far, has 4 jobs:
1. Run PhpUnit tests (& was Codesniffer)
2. Run Psalm check
3. Run Dokerfile and docker-compose.yml test. We build images -> run containers -> check php/console command/sql connectiom/PhpUnit test in container.
NB: Since we run it in github CI, there is no .env, we have to create it manually. When we start Laravel on Docker in normal way on localhost, there is always a .env.
Info: we do this wierd test, as can not test Dokerfile and docker-compose.yml in normal way on localhost, since Docker in not supported on Win 7 we use.
4. Codesniffer check