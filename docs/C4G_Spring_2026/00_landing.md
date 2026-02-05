# Landing

Welcome to the C4G BLIS project!

You are looking at the documentation site for C4G BLIS. The website is generated
by the tool [mkdocs](https://www.mkdocs.org/) from code in the
[C4G BLIS GitHub repository](https://github.com/C4G/BLIS).

## The Project

Here is the official brief:

> Open source system to track patients, specimens, and lab results. One of the original C4G projects,
> continuously in operation since 2010 and deployed in over a dozen countries, mostly in sub-Saharan Africa.
>
> [http://blis.cc.gatech.edu](http://blis.cc.gatech.edu)
>
> Goals for Spring 2025 include:
>
> - Implement a self-update feature of the BLIS-NG desktop launcher
> - Implement a password reset tool in the BLIS-NG desktop launcher
> - Test the PHP 7 upgrade and support BLIS online development


## What is BLIS?

Great question! You can start poking around BLIS without installing anything
on our demo site: [demo.c4gblis.org](https://demo.c4gblis.org).

There are stock usernames and passwords on [this page](../developer_documentation/test-accounts.md).

## Getting Started

### tl;dr

If you are a "clone n' code" type of engineer, here's what you need:

- git
- GitHub.com (NOT `github.gatech.edu` account)
- Docker and docker-compose
- Windows or [WINE](https://www.winehq.org/) (for running BLIS.exe)
- Visual Studio Code (...is the supported editor but not required)

### Windows Users

**Using [WSL2](https://learn.microsoft.com/en-us/windows/wsl/about) is highly
recommended for developing BLIS.** You don't have to, but if you follow these instructions, that is what you will be using.

First, create a fork of the C4G BLIS repository:

1. Log in to GitHub.com using your GitHub credentials
   (NOT your Georgia Tech credentials)
1. Go to [https://github.com/C4G/BLIS](https://github.com/C4G/BLIS)
   and click "Fork"
1. Now you can go to the resulting `https://github.com/[your username]/BLIS`
   and see your own copy of the repository!

#### BLIS Cloud Development

Second, let's set up the BLIS code repository for **BLIS cloud development.**

1. Install [Visual Studio Code](https://code.visualstudio.com/).
1. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/).
   This will enable WSL2 and Docker for the platform. You may have to reboot
   during the installation.
1. After Docker Desktop is finished installing, install
   [Ubuntu 24.04](https://apps.microsoft.com/detail/9nz3klhxdjp5?hl=en-us&gl=US)
   from the Microsoft store.
1. Open Ubuntu 24.04 from the start menu and set up your local user account
1. Open Docker Desktop, click the Settings gear icon, then under Resources
   click "WSL integration" and make sure the "Ubuntu" option is enabled,
   then click "Apply & Restart."
1. In the Ubuntu window, type
   `git clone https://github.com/[your username]/BLIS` to clone the repository
1. Type `cd BLIS`, then `code` to open VS Code
1. VS Code will eventually say "This folder contains a `.devcontainer` folder"
   and ask you to reopen in a container. Click the button!

#### Local Windows development

Finally, let's clone the repository again so you can run the Windows version
as well.

1. Install [Git for Windows](https://git-scm.com/downloads/win) or another
   Git installation if you do not have one already.
1. Open a Windows command prompt or PowerShell.
1. Type `git clone https://github.com/[your username]/BLIS` wherever you'd
   like to have BLIS.
1. Download the [C4G/BLISRuntime](https://github.com/C4G/BLISRuntime/archive/refs/heads/main.zip) package
   and unzip the contents directly into the BLIS repository you cloned.
1. Run `BLIS.exe` to run BLIS!

### Mac Users

**These instructions only apply if you are using an Intel Mac.** If you are
using an M1/M2/etc. Mac, you might have issues. BLIS has hard dependecies on
x86 runtimes, although it might be possible to build it for aarch64. If this
applies to you, let me know very soon.

1. Install [Visual Studio Code](https://code.visualstudio.com/).
1. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/).
1. Open Terminal.
1. Type `git clone https://github.com/[your username]/BLIS` wherever you'd
   like to have BLIS.
1. Type `code BLIS/` to open BLIS
1. VS Code will eventually say "This folder contains a `.devcontainer` folder"
   and ask you to reopen in a container. Click the button!

Mac users cannot run the BLIS Windows desktop application. You can make
a Windows virtual machine to do this, and then follow the third set of
instructions for Windows above.

### Linux Users

If you're a Linux user, I'd recommend using Debian or Ubuntu for running
the BLIS containerized setup, but it's theoretically supported anywhere
that Docker runs<sup>1</sup>. To install Docker, if you don't have it, you can download
the installer script:

```bash
curl https://get.docker.com/ > install_docker.sh
sudo sh install_docker.sh
# Depending on your system you might need to add your user to the docker group
sudo usermod -aG docker $USER
```

Then you can run VS Code (installed separately) and open the devcontainer.

If you have WINE installed, there is a script in `bin/wine-server` that
attempts to start `BLIS.exe` in WINE.

1. I (Mitchell) have had trouble running BLIS on Fedora since
   Fedora has SELinux enabled out of the box, and BLIS does
   some funky stuff as the root user that doesn't play well
   with SELinux. Debian/Ubuntu do not have this issue.

## Next Steps

Get everything set up? Now you can proceed to [testing the BLIS cloud setup procedure!](./10_testing_blis_local_to_cloud.md)
