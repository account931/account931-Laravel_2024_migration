This folder contains .env-s that will be used in Github CI/CD only, in ci.yml, in job 3 (testing Doker images and containers).
This folder's files have set up for connecting Docker Laravel (php/apache) container to Docker SQL Container.
In ci.yml in job 3 when testing Docker image we copy the content of these donored files to original '.env.' & '.env.testing'. We need this as donored file has settings for connection to SQL Docker container, but so far we want to keep original '.env.testing' with settings for localhost, not Docker

NB: When you decide to use Docker on localhost instead of OpenServer, you may simply copy/paste the content of these files to .env & env.testing