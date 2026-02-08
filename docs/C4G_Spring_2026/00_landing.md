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

## Two Modes of Operation

BLIS can operate either as a web service (using Apache 2, PHP, and MySQL in a Docker container) or as a desktop
application on Windows (using the same stack, except Docker is replaced with a Windows launcher application).

**The majority of work on this project this semester requires Windows (x86-64) to test effectively.** There
are instructions for running the development version of BLIS as a web service below for other platforms.

## Getting Started

### Prerequisites

- Git ([installation instructions](https://git-scm.com/install/))
- GitHub.com account
- [Visual Studio Code](https://code.visualstudio.com/)
  - Optional, but highly recommended
- [GitHub CLI](https://cli.github.com/)
  - Optional, but recommended

### Windows Desktop (x86-64)

1. [Install Docker Desktop](https://www.docker.com/products/docker-desktop/)
  - Note that this is for personal use, and you should not install this on a work computer.
1. [Install the .NET 10.x SDK](https://dotnet.microsoft.com/en-us/download)
1. Clone the main repository: `git clone https://github.com/C4G/BLIS.git`
1. Clone the BLISRuntime repository: `git clone https://github.com/C4G/BLISRuntime.git`
1. Clone the BLIS-NG repository: `git clone https://github.com/C4G/BLIS-NG.git`
1. In the **BLISRuntime** directory, highlight all the files (Ctrl-A) and **copy them** to the **BLIS/** folder
1. Open the **BLIS-NG** folder in VS Code, and in the Debug tab, click run

### BLIS Cloud Development (Linux, MacOS, WSL2, Devcontainer) (x86-64 / ARM)

**Windows Subsystem for Linux 2 Users:** Unless otherwise noted, all instructions should be followed from _within_ your WSL2 installation.

1. **Windows (including WSL2) & MacOS Users:** [Install Docker Desktop](https://www.docker.com/products/docker-desktop/)
  - Note that this is for personal use, and you should not install this on a work computer.
1. **Linux Users (NOT including WSL2):** Install [Docker Engine](https://docs.docker.com/engine/install/)
1. Clone the main repository: `git clone https://github.com/C4G/BLIS.git`
1. Enter the main repository: `cd BLIS`
1. Start the development containers: `bin/dev`

BLIS can be accessed at `http://127.0.0.1:8000/` and PHPMyAdmin can be accessed at `http://127.0.0.1:8080/`.

**WSL2 Users:** You may need to use a different local IP address. From within WSL2, run `hostname -i` to determine the correct address to use.

**Optional: Devcontainer:** BLIS contains a [devcontainer specification](https://containers.dev/). If you are using VS Code and it prompts you to "Reopen this folder in a devcontainer" - feel free to try it out and see if it works for you!
