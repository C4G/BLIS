from abc import ABC, abstractmethod
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

blis_url = "http://172.24.80.1:4001"

class Test(ABC, unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.get(blis_url)

    @abstractmethod
    def runTest(self):
        pass

    def tearDown(self):
        self.driver.close()

    def get_element_by_id(self, id):
        WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.ID, id)))
        return self.driver.find_element(By.ID, id)
    
    def get_element_by_xpath(self, xpath):
        WebDriverWait(self.driver, 10).until(EC.visibility_of_element_located((By.XPATH, xpath)))
        return self.driver.find_element(By.XPATH, xpath)

    def get_a_tag_by_href(self, href):
        anchors = self.driver.find_elements(By.TAG_NAME, "a")
        for anchor in anchors:
            a_href = anchor.get_attribute("href")
            if a_href is not None and str(a_href).endswith(href):
                return anchor
        return None

    def driver(self):
        return self.driver  
     
    def login(self):
        login_field = self.get_element_by_id("username")
        password_field = self.get_element_by_id("password")
        login_button = self.get_element_by_id("login_button")
        login_field.send_keys("testlab1_admin")
        password_field.send_keys("admin123")
        login_button.click()