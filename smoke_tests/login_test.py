from test import Test


class LoginTest(Test):
    def runTest(self):
        self.login()
        top_pane = self.get_element_by_id("top_pane_user_info")
        self.assertIsNotNone(top_pane, "User panel does not exist, login test failed")