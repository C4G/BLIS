# Requirements for Satellite Lab ID Tagging

## Definitions

**Reference Labs:** An independent laboratory responsible for processing and analyzing test samples.

**Satellite Lab:** A smaller and geographically distributed lab that collects patient samples, submits the samples to a reference lab and relies on the reference lab for processing the sample.

## Problem Statement

BLIS currently allows satellite labs to log in and view test results. However, satellite labs are able to view the test results conducted by the reference lab including those that do not belong to them. The lack of filtering capabilities results in increased risk of unnecessary data exposure, risk of misinterpreting results, and additional inefficiencies. Hence, a solution is required in order to restrict satellite labs to viewing only their specific test results.

## Technical Requirements

### User Authentication and Authorization
- Ensure satellite labs can only access results relevant/submitted by their lab.

### Test Result Tagging
- Implement a tagging system where each test result is associated with a unique satellite lab identifier.
- Ensure tags are assigned to the results at the time of result entry by the reference lab.

### Filtering Mechanism
- Modify the query for retrieving test results to take satellite lab tag into consideration.
- Ensure UI elements are available to allow for filtering based on satellite lab.
- Alternative: Do not show the UI elements for filtering. Ensure that the logged in account is tagged with the satellite lab unique identifier, and by default filter based on the tag.

### Data Consistency and Integrity
- Ensure tagged results cannot be altered (ensure READ-ONLY permissions of results).
- Maintain a historical record of entries for each satellite lab.

### Performance Consideration
- Ensure the updated query and filtering does not impact page and data load times.
- Utilize database indexing strategies to ensure efficient retrieval of data based on a respective satellite lab.

## Non-Technical Requirements
- Satellite labs should be able to print the test results submitted by them to the reference lab.
- The system should have a user-friendly interface and should be intuitive to use to account for users that may not be well-versed with technology.
- The system should provide an option to generate and store reports offline for use. This would be critical in low bandwidth areas.

## Proposed Solution
The solution involves creating unique satellite lab identifiers and tagging each of results with the tag matching the respective lab. This would involve the following:

### Tagging Results
- The test results would consist of an additional field. The reference lab would assign the correct satellite lab id tag to each test result. This would be done at the time of the result entry. 
- Ensure that each satellite lab id is unique using UUIDs for data integrity and consistency purposes.

### Filtering based on tag
- The database will have to be modified to account for the new field. This could be in the form of a new column to an existing results table. With such information available, the database queries can be modified to include the following to allow for filtering based on satellite id: `WHERE satellite_lab_id = <user_lab_id>`. With the capability of filtering based on satellite id being available in the backend, the user interface will need to be updated to ensure visibility based on the satellite lab id corresponding to the logged in user.

## Success Metrics
- Data accuracy: Percent of correctly tagged results.
- System/query performance: Measure the impact on page and data load times with the additional column.
- Access control: Ensure that only matching lab tag has access to designated results.
- Efficiency: Track success rates by looking at efficiency times using the unique satellite lab id.