# Migrating labs to Cloud
1. Upgrade your labs to version 3.8 from [C4G BLIS web page](http://blis.cc.gatech.edu/).
2. Open your Firefox browser.
3. Go to the Digital Ocean hosted BLIS webpage. Example: http://142.93.49.10/login.php
4. Go to the url http://\<digital-ocean-blis-url>/ajax/download_key.php?role=dir to download the public key needed to encrypt the back-up. Example: http://142.93.49.10/ajax/download_key.php?role=dir
    <p align="center">
    <img src="../../images/user_guide/download_public_key_onl.png" width="100%"/>
    </p>
5. Next, inorder to create an encrypted backup of the local lab:
    1. Navigate to the **Backup Data** tab.
    2. Upload the public key dowloaded in the previous step.
        <p align="center">
        <img src="../../images/user_guide/add_new_dir_key.png" width="100%"/>
        </p>
    3. Click on **Backup** and save the .zip encrypted backup.
6. Now the country Director can upload this lab's encrypted backup onto cloud:
    1. Login onto http://\<digital-ocean-blis-url>/login.php as a Director.
    2. Navigate to **Lab Configurations**.
    3. Click on **Import Lab Data** and upload the encrypted lab backup.
        <p align="center">
        <img src="../../images/user_guide/importing_ofl_backup.png" width="100%"/>
        </p>
    4. Upon successfully importing the lab you will see something like this: 
        <p align="center">
        <img src="../../images/user_guide/successful_ofl_lab_import.png" width="100%"/>
        </p>
    5. And in the **Lab Configuration** tab you would see:
        <p align="center">
        <img src="../../images/user_guide/post_ofl_lab_import.png" width="100%"/>
        </p>
7. Now the new admin created for the newly imported lab can login using the default credentials using C4G BLIS in the cloud. 
