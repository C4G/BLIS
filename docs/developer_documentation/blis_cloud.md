# Running BLIS on a Cloud Provider

There is experimental support for running BLIS on a cloud provider in the form of a Docker container!

## Quick Version

**Skip this section for step-by-step instructions on getting BLIS running.**

1. You must already have an account with a cloud provider to continue, and you must create a virtual machine running a relatively modern Linux distribution. For testing, Digital Ocean and the minimum-level $5/month droplet was used.

2. You must [install Docker Engine](https://docs.docker.com/engine/install/) for the Linux distro you are running.

3. You must [install Docker Compose](https://docs.docker.com/compose/). Either V1 (`docker-compose`) or V2 (`docker compose`) will work, but for this example, **docker-compose V1 will be used.**

## Creating a Droplet

1. You can follow the [instructions on DigitalOcean to create a droplet here](https://docs.digitalocean.com/products/droplets/how-to/create/).
  - Any Linux distribution should work, but for the purposes of this guide, it is assumed you will use Ubuntu.
2. After creating the droplet, make sure you either note down the root user password you set, or you have an key configured for passwordless login.
3. [Follow the instructions here to connect to the droplet via SSH](https://docs.digitalocean.com/products/droplets/how-to/connect-with-ssh/).

## Installing Docker

1. When you are SSH'd into the droplet, in the terminal, run these commands to install Docker:

  ```bash
   sudo apt-get update
   sudo apt-get install ca-certificates curl gnupg lsb-release

   curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg \
     --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
   
   echo \
     "deb [arch=$(dpkg --print-architecture) \
     signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] \
     https://download.docker.com/linux/ubuntu \
     $(lsb_release -cs) stable" | sudo tee \
     /etc/apt/sources.list.d/docker.list > /dev/null
     
  sudo apt-get update
  sudo apt-get install -y docker-ce docker-ce-cli containerd.io
  ```

2. Install Docker Compose V1:

  ```bash
   sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
   
   chmod +x /usr/local/bin/docker-compose
  ```

Now you're ready to run BLIS!

## Running BLIS

1. In the DigitalOcean Droplet via SSH, clone the BLIS repository:

    ```bash
    $ git clone https://github.com/c4g-spr22-blis/BLIS.git
    ```

1. Change to the BLIS Docker directory

    ```bash
    $ cd BLIS/docker
    ```

1. Initialize BLIS!

    ```bash
    $ docker-compose up -d
    ```

These commands will set up two containers:

1. The `app` container: This contains all of the BLIS source code, as well as the Apache2 web server and PHP 5.6 runtime.
1. The `db` container: This contains the MySQL 5.7 database. The files inside the `docker/database/` folder are executed when the container is created, providing the seed data that the BLIS database needs to start.

## Accessing BLIS

Now, BLIS should be running. You can access it by visiting a URL that looks like:

```plain
http://[your droplet IP address]/
```

Substitute your droplet IP address above - you should have this from SSHing into it.

## Upgrading BLIS

When you want to upgrade BLIS, you can follow these commands to pull the latest version of the Docker image and restart the containers:

```bash
$ docker-compose down
$ docker-compose pull app
$ docker-compose up -d
```

And that's it!

## Adding an HTTPS certificate to BLIS

By default, BLIS will only communicate over HTTP on port 80 (see `docker/docker-compose.yml` 
for the full port configuration.)

BLIS includes support for automatically retrieving and configuring a certificate from
[Let's Encrypt](https://letsencrypt.org/) for communicating over HTTPS. However, you must
already have a domain configured and pointing at the host you are running BLIS on. **This process
is not included in this guide.** If you are using DigitalOcean, [there is a guide you can use as
a jumping-off point here](https://docs.digitalocean.com/products/networking/dns/quickstart/).

### After your domain is pointing to your BLIS host IP address

You will need to add the `BLIS_SERVER_NAME` to the `docker-compose.yml` configuration:

```yml
services:
  app:
    # This image is automatically built and pushed from the GitHub action in .github/workflows/ folder
    image: "ghcr.io/c4g-spr22-blis/blis:latest"
    environment:
      DB_HOST: 'db'
      DB_PORT: '3306'
      DB_USER: '[blis database user here]'
      DB_PASS: '[blis database password here]'
      # Add or uncomment this line, and change the domain value to your own
      BLIS_SERVER_NAME: 'blis.mydomain.com'
```

Then, (re)start BLIS:

```bash
# if BLIS is running
$ docker-compose down

# bring the database container up first and daemonize it
$ docker-compose up -d db

# bring the app container up alone, syncronously, so we can see the output
$ docker-compose up app
```

Make sure there are no errors in the output. The container will attempt to read the value
of `BLIS_SERVER_NAME` and set the appropriate `ServerName` directive in the Apache2
web server configuration and a message will say that it is successful.

Assuming it is successful, you can quit with Ctrl-C and restart as a background process
(`docker-compose up -d app`).

In a separate terminal window, while BLIS is running, run the script:

```bash
$ docker-compose exec app get-https-cert.sh
```

This will verify the environment configuration seems correct and execute the certificate tool for you!
Answer the questions about the domain to the best of your knowledge.

Once the domain is verified and the certificate installed, you can visit your BLIS instance 
with an `https://` URL and hopefully it just works!


## Troubleshooting

1. There maybe a error when you call `docker-compose` API, the error will show similar to:

  ```bash
  root@blis-test:~/BLIS/docker#docker-compose
  -bash: /usr/local/bin/docker-compose: Permission denied
  ```
Using a `chmod +x /usr/local/bin/docker-compose` will help the work.

