# Project Webpage
This page has been created as part of Spring 2025's P3 assignment: Project Webpage.

## Project Description
Our project expanded on C4G's existing BLIS project. C4G Basic Laboratory Information System is a collaboration between Computing for Good (C4G) at Georgia Tech, the Center for Disease Control (CDC), and participating PEPFAR countries. The project provides software for tracking of lab test results in developing countries. Our worked focus on adding features for satellite labs that perform tests on behalf of reference labs that don’t have the necessary equipment. Additionally, we expanded the French translation.

## Overall Project Goal
Our project had a few different goals

- We built a system for refrence labs to seamlessly access results from satellite labs
    - Reference labs extract specimens from patients and send the specimens to satellite labs that have full capabilities to perform the tests needed. When satellite labs have extracted the results, these are currently sent through PDF's over email or even physically to the source labs. We built a feature within the BLIS system for satellite labs to seamlessly and privately share these results with reference labs.
- We expanded the translation of text for French speakers.

## Team Members
- Sofia Muller: 
    - Team webpage. 
        - https://github.com/C4G/BLIS/pull/113
        - https://github.com/C4G/BLIS/pull/114 
        - https://github.com/C4G/BLIS/pull/131 
        - https://github.com/C4G/BLIS/pull/133 
    - Functionality to extract satellite lab id when searching from a satellite lab account. https://github.com/C4G/BLIS/pull/129
    - Ensured accurate search result count when searching patients from a satellite lab perspective. https://github.com/C4G/BLIS/pull/137
    - Added documentation. https://github.com/C4G/BLIS/pull/148
- Princesca Dorsaint: 
    - Developed functionality to create a satellite lab user type in the db and allow satellite lab user ability to search for patient results. https://github.com/C4G/BLIS/pull/121
    - Remove satellite lab users ability to remove/modify specimen data. https://github.com/C4G/BLIS/pull/126
    - Add functionality to auto generate a satellite_lab_id for satellite lab users when creating  a satellite lab user type in the user table. Modify search_patients_by_...dyn functions to take in the $satellite_lab_id variable. Modify sql queries associated with search functions to filter for patients associated with the logged in satellite lab user. https://github.com/C4G/BLIS/pull/130
    - QA'd changes to ensure end to end functionality.
    - Fixed satellite lab filter patient search to apply only to satellite lab users. Use session level to check if user is a satellite lab. If user is a satellite lab, then a satellite lab filter is applied to patient search functions.
    - Worked on P7 FieldEvaluation.
    -Attended team, mentor, and stakeholder meetings.
- Disha Patel: 
    - [Requirements gathering for Satellite labs feature](https://github.com/C4G/BLIS/pull/116)
    - [UI and database code changes related to adding satellite lab ID, updating satellite lab ID and viewing the satellite lab ID](https://github.com/C4G/BLIS/pull/127)
    - Performed end-to-end testing of the satellite lab ID feature
- Mishwa Bhavsar:
    - French translation
    - Survey for peer evaluations

## Peer Evaluations
1. Please find our demo application here: https://demo.c4gblis.org/login.php
2. Answer the following survey: [BLIS Peer Evaluation Survey](https://forms.office.com/r/snWhypaQiy)
3. Troubleshooting contact: Sofia Muller or Mishwa Bhavsar on Microsoft teams

## Lighthouse Scores
- Performance: 94
- Accessibility: 92
- Best Practices: 96
- SEO: 90
![Screenshot](../images/spring_2025/lighthouse.png)