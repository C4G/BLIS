# Automated Tests

If you want to run smoke tests on BLIS you can find them in the [smoke_tests folder](https://github.com/C4G/BLIS/tree/master/smoke_tests) on the C4G BLIS Github. Below are the tests that are implemented and instructions for running the smoke tests.

Tests

1. Login
   
1. Specimen test

1. Registering a patient

1. Registering a specimen

Running Instructions

1. You will need python 3 installed, the latest is preferred

2. You will need to pip install selenium, if pip is not on your command line you can do python -m pip install selenium

3. Create a folder called test or something of that variety to extract your smoke test zip file to

4. Extract the zip to that folder

5. Ensure you have Firefox installed on the local machine, you will need to also get the gecko driver

6. Get the gecko driver from here for your platform you are running the tests on https://github.com/mozilla/geckodriver/releases

7. Put the gecko driver into the folder where your tests are running

8. Either run BLIS locally or have it installed on digital ocean

9. Get the address for your BLIS installation, this is what you put in the address bar in your browser to access BLIS 

10. Edit the BLIS_URL in test.py with your address from step 9, so if your address was http://172.24.80.1:4001 that line should now be blis_url = "http://172.24.80.1:4001"

11. Open up command prompt or terminal

12. Navigate to the directory with cd

13. Run python main.py in your terminal or command prompt

14. The testing platform will run and will report back if any tests failed and with any errors or if all the tests ran successfully
