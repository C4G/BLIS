# C4G BLIS User Guide Version 3.72

## User Instruction Manual Rev 3.72

C4G Basic Laboratory Information System is a collaboration between Computing-for-Good (C4G) at Georgia Tech, the CDC, and participating PEPFAR countries.

<div style="page-break-after: always;"></div>

# Table of contents
1. [Introduction to C4G BLIS](#introduction)
2. [BLIS Start-Up Guide](#startup)
    1. [BLIS For Windows](#blis_windows)
    2. [BLIS On The Cloud](#blis_cloud)
    3. [BLIS In A Devcontainer](#blis_devcontainer)
3. [Roles in BLIS](#blis_roles)
    1. [Manager Overview](#manager_overview)
    2. [Technician Overview](#technician_overview)
    3. [Director Overview](#director_overview)

# Introduction to C4G BLIS <a name="introduction"></a>
The Basic Laboratory Information System, BLIS, is a freeware Web-based system that can be installed in a local, district, or national laboratory. It is a tool that can help to standardize data, which improves the ability to run useful reports and can both give a realistic picture of laboratory services and assist with staff and budget planning. With enough data, BLIS can be used to track disease prevalence over time.

Features of BLIS include:
- One-time entry of each unique patient
- Standardization of data collected (allowable entries for specimen type, test type, patient data, reagents are set at MOH level and then entered consistently throughout a country)
- Customization to a country’s needs
- Ability to track lab supplies such as test kits, reagents
- Ability to run reports as specified by a country
- Automatic alerting of data values that may be out of range(reference ranges and panic values are set at the regional or national level)
- Daily logs to be reviewed for data verification
- Simple data backup to a zipped file 
- [NEW] BLIS running on a cloud provider
- [NEW] Manual data backup to a version of BLIS running on a remote server

As with any properly implemented electronic record system, BLIS may be found over time to improve data accuracy and reduce costs in laboratories. Benefits already seen in labs using BLIS:
- Reduced burden for technicians, as results are available soon after testing
- Improved consistency of data entry
- Ability to view patient history and track samples
- Ability to aggregate data and analyze data patterns and trends at a regional or national level
- Printed patient records in place of handwritten records
- Printed daily logs that make the reports look like the paper forms used in the laboratory

# BLIS Start-Up Guide <a name="startup"></a>
There are three versions of BLIS that currently exists. 

Firstly, <b>BLIS on Windows</b> was the original version developed for end-users. Stand-alone versions, updates, and packaged content are still publically available on the C4G BLIS home page, [accessible here](http://blis.cc.gatech.edu/). 

Secondly, <b>BLIS on the Cloud</b> is a newly deployed version of BLIS that is capable of running on a Cloud Provider, and was originally intended to be used as an online backup database for aggregating country-wide data for analysis. 

Thirdly, <b>BLIS in a Devcontainer</b> is an instantiation of BLIS that allows for developers to specify the development environment, and is intended to be used by developers only.

### BLIS For Windows <a name="blis_windows"></a>
BLIS was originally developed to run on Windows using a discontinued project called Server2Go. This packages Apache2, MySQL, PHP, and Firefox together into a package that can be run all at once on a desktop computer. BLIS on Windows is the primary way that end-users are using BLIS, but can and should be used by developers to test updates.

#### Prerequesites
Installing command-line tools can be done with a Windows package manager such as [Scoop](https://scoop.sh/).

* `git`


### BLIS On The Cloud <a name="blis_cloud"></a>
Insert information about BLIS on the Cloud

### BLIS In A Devcontainer <a name="blis_devcontainer"></a>
Insert informationa bout BLIS in a Devcontainer

## Roles in BLIS <a name="blis_roles"></a>
Overview of the three roles in BLIS

### Manager Overview <a name="manager_overview"></a>

### Technician Overview <a name="technician_overview"></a>

### Director Overview <a name="director_overview"></a>
