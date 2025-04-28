# Upgrading to BLIS 3.94 (Limbe Regional Hospital Test Edition)

## Before Upgrading

1. Please ensure **BLIS is stopped.**
1. Enter the **local** folder
![local folder](394_upgrade/local_folder.png)
1. Right-click the **log_1.txt** file
![log_1.txt file](394_upgrade/log_1_pre_rename.png)
1. Rename the file to **log_1.2024.txt**
![log_1.txt renamed](394_upgrade/log_1_post_rename.png)


## Downloading Upgrade Package

1. Download the **3.94 upgrade package** from here: [BLIS_Upgrade_3.94.zip](https://github.com/C4G/BLIS/releases/download/v3.94.beta.1/BLIS-Upgrade-3.94.zip)
![BLIS folder](394_upgrade/blis_folder.png)

1. Apply the upgrade package by **copying all the files and folders inside BLIS-Upgrade** into the **main BLIS folder.**

## Applying the database hotfix

1. Enter the **bin** folder.
![bin folder](394_upgrade/bin_folder.png)

1. Double-click the **20250427_dhims2_hotfix.bat** file.
![hotfix](394_upgrade/dhims2_fix_bat.png)

1. Press any key to continue.
![hotfix running in console](394_upgrade/dhims2_script_fix.png)

## Running the database repair tool

1. From the **bin** folder, double-click the **windows_repair_mysql.bat** file.
![database repair bat file](394_upgrade/db_repair_script.png)

1. Press a key to continue.
![database repair running](394_upgrade/db_repair_script_fix.png)

## Start BLIS

1. Start **BLIS.exe**
1. Login as the following user:
    - **Username:** `vempala`
    - **Password:** `admin123`
![upgrade link](394_upgrade/login_vempala.png)
1. Click the upgrade link to upgrade BLIS
![upgrade done](394_upgrade/login_upgrade_complete.png)
1. Click "Lab Configurations"
![lab configurations](394_upgrade/list_of_labs.png)
1. Click the lab that you want to see
1. The lab will have a "Migrations pending" link at the top. Click it.
![lab migrations](394_upgrade/migrations_pending.png)
1. Once migrations are done, now you can make a backup.
