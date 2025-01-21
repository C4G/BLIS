# Testing BLIS on the Cloud

Your second task (after setting up your development environment) is to test setting BLIS up in a cloud environment.

For this task, you'll need access to a Linux server. You can absolutely run one of these yourself
as a physical or virtual machine, or you can buy a VPS on AWS, Digital Ocean, Azure, or any number of other
providers. The minimum requirements are **at least 1 vCPU and at least 1 GB of RAM.** However, you'd be
much better off with at least 2 vCPUs and 2 GB or more of RAM, if you can.

??? "Supported server types"
    Ubuntu 20.04 (Focal), 22.04 (Jammy), or 24.04 (Noble) are the supported distros.

    ARM-based machines are not supported.

## Installing BLIS

Using the Linux server, follow the [cloud setup guide](../user_guide/11_blis_cloud.md). You may use the automatic
setup script.

Please report any problems you run into! This is valuable information for us so we can improve documentation
for end users.

## Synchronizing BLIS on Windows to the Cloud

On your Windows machine, make sure you can run `BLIS.exe`. Additionally, make sure you have a URL to your
Linux BLIS server that the Windows machine can access (a URL on the local network is fine.)

Next, follow the instructions for testing
[the data synchronization feature here](../user_guide/13_syncing_with_blis_cloud.md), and once
again please report any issues you experience (This is a very new feature so I expect there will be some!)
