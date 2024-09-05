
# Code directories and organization

As you can see [in the directory](https://github.com/C4G/BLIS), there is the first level file tree directory. And in the following sections, we will cover the some of important file/directory for your faster & better understanding about the BLIS code organization.

```bash
├── .devcontainer
├── .github
├── .editorconfig
├── .gitignore
├── API_documentation.txt
├── Dockerfile
├── README.md
├── Update_Instructions.txt
├── bin
├── composer.json
├── composer.lock
├── docker
├── files
├── htdocs
├── local
├── log
├── splash.png
├── tools
├── update_C4GBLIS_v3.3.bat
└── vendor
```
??? tips "Tips about file structure"

    The above tree structure can be generated via the `tree` command. For more details, [read this doc](https://linux.die.net/man/1/tree).

## Developer tools directories

### Docker related
```bash
├── Dockerfile
├── docker
├── .devcontainer
```
The above files are mostly for development usage. As mentioned above, we use docker to containize the application and make it easily deployable in Linux platforms. `.devcontainer` contain the setup for docker setup locally when running in devcontainer; `Dockerfile` contains the details for pushing image to `ghcr.io` in the CI/CD stage (Also mentioned in the below **Github related** section). And `docker/` directory contains the `docker-compose` file, bash files for deployment at Linux machine. More details can be seen in the [Deployment](./testing-deployments.md) page.

### Github related
```bash
├── README.md
├── files
├── log
├── .github
├── splash.png
```
You will find mostly directory empty (As of April, 2022). And in the `.github/` directory, there is a CI/CD step: releasing latest changes to the [`ghcr.io`](https://docs.github.com/en/packages/quickstart), thus we can easily deploy the latest changes when needed. You can see more details in `release-docker.yml`.

### Composer Related
```bash
├── composer.json
├── composer.lock
├── tools
├── vendor
```
Start from Version [TODO], we introduced [`Composer`](https://getcomposer.org/) as the php package manager for BLIS. You will need to set it up before using it, [see more details here](https://getcomposer.org/doc/00-intro.md). But this is not necessary till you want to make changes to the BLIS dependencies.

As for the `composer.json` and `composer.lock` file, you can refer to [this documentation](https://getcomposer.org/doc/02-libraries.md#lock-file) to understand how they work. `composer.lock` records the exact versions that are installed. So that you are in the same versions with your co-workers. And `composer.json` records the packages you specify and want to use in the project.

And the `vendor` directory is where the specified packages installed.

## Source code directories
After going through the developer tools directories, you will find one few files/directories left.
```bash
├── API_documentation.txt
├── Update_Instructions.txt
├── bin
├── htdocs
├── local
├── update_C4GBLIS_v3.3.bat
```
And among those, the most important two directories are `htdocs` and `local`. The `htdocs` contains almost all the modules in BLIS. And `local` directory contains the localization versions' settings of phrases, tips, UI appearance. Due to the complexity of this section, few features will be focused for illustration, feel free to add your findings when working on some features. :smile:

### Backup Data and Cloud Backup
Cloud backup means you can specify the IP Address and then send backup to the BLIS instance hosted on that IP Address. (More details of UI can be found in User Guide -> Backup Data section).

This functionality mainly lives in `./htdocs/export`. The latest changes mainly live in `backupData.php` and `backupDataUI.php`. We can refer to specific git commits for better understanding.

## UI changes
UI and tips have been refactored in the version [TODO], and we found out that the UI settings is reflected in both `./htdocs/Language` and `local/lab_id` directory. Changes in `./htdocs` don't necessary propogate to the local labs. So if you want to your changes to be reflected in both new labs and old existed labs, you will need to change the files in `./local/lab_id` accordlingly.

There may be some confusion on `default`, `en`, `fr` versions across the repo. TLDR is `default` is the version will be setup by your country directory when setting up the lab, and can be `en` or `fr`. To better understand this scenario, let's imagine we are going to change the tips for english version, then potentially, we will make 4 changes (2 for `default` and `en`, 2 for `local_lib` and `htdocs`)
