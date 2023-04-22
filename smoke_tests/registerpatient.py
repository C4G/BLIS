from test import Test
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select


class RegisterPatientTest(Test):
    def runTest(self):
        self.login()
        workAsTechnicianLink = self.get_element_by_xpath("//a[@href='switchto_tech.php?id=127']")
        workAsTechnicianLink.click()
        registerationTab = self.get_element_by_xpath("//a[@href='find_patient.php']")
      
        registerationTab.click()
        patientSearch = self.get_element_by_id("psearch_button")
        patientSearch.click()

        addNewPatient = self.get_element_by_id("add_anyway_link")
        addNewPatient.click()
        
        patientId = self.get_element_by_id("pid")
        patientId.send_keys("123")

        patientNumber = self.get_element_by_id("dnum")
        patientNumber.send_keys("123")
        self.SelectPatientGender("Male")
        patientName = self.get_element_by_id("name")
        patientName.send_keys("Test")
        patientAge = self.get_element_by_id("age")
        patientAge.send_keys("20")
        submitButton = self.get_element_by_id("submit_button")
        submitButton.click()
        WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, "//span[text()='Specimen Registration']")))

        #Register a specimen for a new patient
        patientNumberforRegisteringSpecimen = self.get_element_by_id("dnum")
        patientNumberforRegisteringSpecimen.send_keys("123")
        select = Select(self.get_element_by_id('specimenform_1_stype'))
        select.select_by_visible_text('Stool')
        WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, "//*[contains(text(),'Stool Analysis')]")))
        self.SelectTests("Stool Analysis", "enable")

        submitspecimenButton = self.get_element_by_id("add_button")
        submitspecimenButton.click()

    def SelectPatientGender(self,gender):
        if( gender.lower() == "male") :
            patientGender = self.get_element_by_xpath("//input[@value='M']")
        if( gender.lower() == "female") :
            patientGender = self.get_element_by_xpath("//input[@value='f']")
        if( gender.lower() == "other") :
            patientGender = self.get_element_by_xpath("//input[@value='O']")
        patientGender.click()

    def SelectTests(self,test,checkstatus):
        selectTestCheckboxElement = self.driver.find_elements(By.XPATH,f"//td[contains(text(),'{test}')]/parent::*//input[@checked]")
        selectTestElement = self.driver.find_element(By.XPATH,f"//td[contains(text(),'{test}')]/parent::*//input")
        if ((len(selectTestCheckboxElement) > 0 and  checkstatus.lower() == "disable") or (len(selectTestCheckboxElement) == 0 and  checkstatus.lower() == "enable")):
            selectTestElement.click()

      