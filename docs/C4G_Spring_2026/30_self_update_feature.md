# Feature Addition: Launcher-Based Self Update for Desktop Application

## Overview

The self-update feature allows lab administrators to update the BLIS desktop application directly through the BLIS-NG launcher, without requiring a technician or outside IT support.

Previously, updating BLIS required a technician to manually copy files from a USB drive, overwrite the existing installation, and migrate data by hand. This process frequently resulted in mixed old and new files across the installation, making it difficult to determine exactly which version a lab was running and complicating future support.

The self-update feature replaces this workflow with a guided, two-stage process handled entirely by the launcher. The administrator selects a downloaded update package, and the launcher takes care of staging the new files, backing up the database, and restarting services. A versioned release directory structure tracks active and previous versions, allowing one rollback version to be retained after each update. Database migrations are handled through the existing process in the BLIS PHP application.

Update packages are built automatically through a GitHub Actions workflow, producing both standalone and update release artifacts. Packages are available for download from the project site at docs.c4gblis.org.

---

## Prerequisites

**Supported environment:** The self-update feature is only available on Windows. It is not supported on Mac or Linux.

**Permissions:** The update is performed through the BLIS-NG launcher, which runs on the local PC acting as the server for the lab. In practice, only the lab administrator has physical access to this machine.

**Obtaining the update package:** The update ZIP file should be downloaded from the project site at docs.c4gblis.org before starting the update process.

**Upgrading from an older version:** The self-update feature is supported for BLIS 4.0 and later. For labs running an older version, a fresh install is recommended instead. The recommended process is to back up existing data through the BLIS application, perform a fresh install, and then import the backup.

---

## How to Perform and Update

1. Download the update ZIP file from the project site at docs.c4gblis.org.
2. Open the BLIS-NG launcher on the lab server PC.
3. Click "More Options" button near the bottom right of the launcher window.
4. Select "Update with ZIP File" from the dropdown options.
5. Select the update ZIP file when prompted.
6. The launcher will proceed through the two-stage update process automatically. This includes staging the new files into a versioned release directory, updating the launcher, stopping Apache and MySQL, backing up the database, updating `state.json` to reflect the new active version, and restarting services.
7. The BLIS PHP application will prompt the administrator to apply any pending database migrations through the existing migration process.
8. Verify the update succeeded by confirming the new version number is displayed on the launcher.

---

## Update Process Details

**Part 1: Launcher Update**
The launcher extracts the contents of the selected Update ZIP file into a local staging directory for temporary storage. The extracted files contain a new launcher executable as part of the update, which uses the base directory as it's source. The old launcher exe file essentially gets renamed by the new launcher exe file which then takes its place, completing the launcher update.

**Part 2: BLIS Application Update**
The launcher halts Apache and MySQL, then stages the new application files into a versioned release directory. MySQL is restarted to generate a database backup. The `state.json` file is then updated to set the new version as active and the previous version as the prior release. The old launcher quits and then starts up the updated launcher and rebuilds the httpd.conf file using a Liquid template that references the active version from `state.json`, and restarts Apache and MySQL to bring the application back online.

**Cleanup**
After the update completes, temporary staging files are removed. The previous version is retained in the release directory, and its path is recorded in `state.json`. There is no active rollback mechanism in the launcher at this time.

---

## Known Limitations and Issues

**No rollback mechanism:** The previous version is retained in the release directory and recorded in state.json, but there is no option in the launcher to roll back to it. Rolling back requires manual intervention. For labs running BLIS versions prior to 4.0, see the Prerequisites section.

**Fresh installs only for pre-4.0 versions:** The self-update feature does not support upgrading from versions prior to BLIS 4.0. Labs on older versions must follow the fresh install process described in the Prerequisites section.

---

## Troubleshooting

**The update failed or the launcher displayed an error.**
Check that the ZIP file was downloaded from docs.c4gblis.org and that it contains both a server and launcher version at minimum. If the issue persists, inspect the logs in the `logs/` directory in the root of the project.

**The version displayed on the launcher did not change after the update.**
Check the `state.json` file in the BLIS standalone directory to confirm whether the active version was updated. If the active version in `state.json` still reflects the previous version, the update did not complete successfully.

**BLIS is not accessible in the browser after the update.**
Verify that Apache and MySQL are running through the launcher. If the `httpd.conf` file was not rebuilt correctly, check that the active version in `state.json` corresponds to a valid release directory.

**Database migrations are pending after the update.**
This is expected behavior. Log into the BLIS PHP application and follow the existing migration process to apply pending migrations.

---

## Contributors (Spring 2026)

Luqman Rashad
Haki Atalov
