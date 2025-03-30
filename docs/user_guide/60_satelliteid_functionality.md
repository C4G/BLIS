# Satellite ID Functionality

## What is Satellite ID?
Satellite ID is a unique identifier assigned to satellite labs within the BLIS system. Satellite labs collect patient samples and send them to a reference lab for testing. The Satellite ID ensures that satellite labs can only view test results specifically related to their lab, enhancing data privacy and reducing the risk of misinterpretation.

## Why Satellite ID is Added
Satellite ID functionality is added to:
- Restrict satellite labs to viewing only their own test results.
- Enhance data security by preventing unnecessary exposure of unrelated patient data.
- Increase accuracy and efficiency in handling and interpreting test results.

## How to Create a Satellite ID
1. Open your Firefox browser.
2. Log in as `testlab1_admin`.
3. Navigate to the **Lab Configurations** tab.
4. Select **User Accounts** and click on **Add New Account**.
5. From the dropdown menu, select user type `SATELLITE_LAB`.
6. Click **Add** and verify the user creation.

<p align="center">
<img src="/workspaces/BLIS/docs/images/user_guide/satelitte_as_usertype.png" width="50%"/>
</p>

## How to Use Satellite ID

### Creating Patients with Satellite Lab ID
1. Stay logged in as `testlab1_admin`.
2. Click on **Work as Technician** in the top right corner.
3. Navigate to **Registration**, then click **Search**.
4. Click **Add New Patient**:
   - Fill out patient details.
   - Assign a specific Satellite Lab ID (e.g., `1` for `satellite_lab_1`).
   - Click **Submit**.

<p align="center">
<img src="/workspaces/BLIS/docs/images/user_guide/assign_satelliteid_for_new_user.png" width="50%"/>
</p>

### Viewing Results with Satellite ID
1. Log in as the satellite lab user (e.g., username: `satellite_lab_1`, password: `blis123`).
2. Navigate to the **Search** tab.
3. Enter the patient's name associated with your Satellite Lab ID.
4. Click **Search** to view results relevant only to your lab.

<p align="center">
<img src="/workspaces/BLIS/docs/images/user_guide/user_for_satellite_id.png" width="50%"/>
</p>
