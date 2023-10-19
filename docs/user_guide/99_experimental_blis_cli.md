# Experimental: BLIS Cloud Command-Line Interface

The BLIS Cloud CLI is an experimental way to install and manage BLIS on cloud-based virtual machines.

!!! warning "This tool is in preview!"

    Unless you are comfortable debugging issues, you should instead use the [article on Running BLIS on a Cloud Provider.](../11_blis_cloud/)

## Installation

The tool is intended to be used on **Ubuntu** installations only. In order to install the tool, you must first install the prerequisites:

```bash
sudo apt-get install -y python3-pip
echo "export PATH=\"\$HOME/.local/bin:\$PATH\"" | tee -a ~/.bashrc
```

Then you can install the tool with:

```bash
pip3 install git+https://github.com/mrysav/blis-cloud-cli.git
```

## Usage

### Docker status

You can check the status of Docker with:

```bash
blis docker status
```

If Docker is not installed, then you should run:

```bash
blis docker install
# You might need to run this with "sudo"
```

### BLIS Installation

```bash
blis install
```

### BLIS Update

```bash
blis update
```
