# Reference & Satellite Labs

_Last updated by [@mrysav](https://github.com/mrysav)_

# Use Case: 1 reference lab, 2 satellite labs

- The reference lab admin can create accounts for satellite lab users.
- The reference lab technician can enter results into the reference lab and tag those results as belonging to satellite labs.
- The satellite labs can log in to the reference lab cloud BLIS and view results only for their labs.

```mermaid
sequenceDiagram
    participant A as Reference Lab BLIS Cloud
    participant B as Reference Lab Admin
    participant C as Reference Lab Technician
    participant D as Satellite Lab A
    participant E as Satellite Lab B

    B->>A: Creates Account for Satellite Lab A
    B->>A: Creates Account for Satellite Lab B

    D->>C: Send Specimen A for test
    E->>C: Send Specimen B for test

    C->>A: Log in as Reference Lab Technician and Enter Test Result for Specimen A
    C->>A: Log in as Reference Lab Technician and Enter Test Result for Specimen B

    D->>A: Log in as Satellite Account A
    A->>D: Can ONLY view result for Specimen A

    E->>A: Log in as Satellite Account B
    A->>E: Can ONLY view result for Specimen B

```

# Data Model (in progress)

```mermaid
classDiagram
    BLISCloud <-- Lab
    BLISCloud <-- UserAccountType
    BLISCloud <-- UserAccount
    UserAccountType <-- UserAccount

    class BLISCloud {

    }

    class Lab {
        - Contains specimens and test results specific to a particular lab
    }

    class UserAccountType {
        - List of permissions
    }

    class UserAccount {
        - Has access to specific lab or labs
    }
```
