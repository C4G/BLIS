from test import Test

class SpecimenTest(Test):
    def runTest(self):
        self.login()
        lab_config = self.get_a_tag_by_href("lab_configs.php")
        self.assertIsNotNone(lab_config, "Lab Configuration does not exist")
        lab_config.click()
        tests = self.get_element_by_id("test")
        self.assertIsNotNone(tests, "tests do not exist")
        tests.click()
        specimen_test_types = self.get_element_by_id("option2")
        self.assertIsNotNone(specimen_test_types, "Specimen test types does not exist")
        specimen_test_types.click()
        test_types_hide = self.get_element_by_id("ttype_link")
        self.assertIsNotNone(test_types_hide, "hide button does not exist")
        test_types_hide.click()
        test_catalog = self.get_a_tag_by_href("catalog.php")
        self.assertIsNotNone(test_catalog, "test catalog does not exist")
        test_catalog.click()
        specimen_types = self.get_element_by_id("specimen_types_div_menu")
        self.assertIsNotNone(specimen_types, "Specimen types does not exist")
        specimen_types.click()
        stool_test = self.get_a_tag_by_href("specimen_type_edit.php?sid=12")
        self.assertIsNotNone(stool_test, "stool type does not exist")
        stool_test.click()
        name_field = self.get_element_by_id("name")
        self.assertIsNotNone(name_field, "specimen name field does not exist")