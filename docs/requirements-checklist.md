# Requirements checklist (tickets NMP-0001 to NMP-0007)


## Admin login URL

https://v.je/login.php

## Superadmin username/password

Superadmin username: **superadmin**
Superadmin password: **password**

---

## Tickets completed

### Ticket NMP-0001: User accounts

#### 1. A superadmin can log in and add new accounts
Completed: Yes
File(s) containing feature:
- (public/login.php) 
- (public/manage-users.php )

#### 2. Once a new account is added that new user can log in to the website and add subject areas (NMP-0002) and courses (NMP-0003)
Completed: Yes
File(s) containing feature:
- (public/login.php) 
- (public/subject-areas.php)
- (public/manage-courses.php) 

#### 3. A superadmin can delete accounts
Completed: Yes
File(s) containing feature:
- (public/manage-users.php) 

#### 4. The superadmin account cannot be deleted
Completed: Yes
File(s) containing feature:
- (public/manage-users.php)

#### 5. Accounts that are not the superadmin should not be able to add/remove accounts
Completed: Yes
File(s) containing feature:
- (public/manage-users.php) 


### Ticket NMP-0002: Add/display subject areas

#### 1. Logged in admin users can add new subject areas and rename existing subject areas or delete them entirely
Completed: Yes
File(s) containing feature:
- (public/subject-areas.php )

#### 2. Users who are not logged in should not be able to add/edit/delete subject areas
Completed: Yes
File(s) containing feature:
- (public/subject-areas.php) 

#### 3. Once a subject area is added it appears in the menu as a clickable link
Completed: Yes
File(s) containing feature:
- (Templates/header.php)

#### 4. Clicking one of the subject areas should go to a page (within the standard layout provided) that has a heading of the chosen subject area
Completed: Yes
File(s) containing feature:
- (public/subject-area.php)


### Ticket NMP-0003: Add/display courses

#### 1. Courses can be added with all the data listed above
Completed: Yes
File(s) containing feature:
- (public/manage-courses.php)
- (public/manage-courses.php) 

#### 2. Once a course is added it can be edited or updated
Completed: Yes
File(s) containing feature:
- public/manage-courses.php 

#### 3. It should be possible to move the course from one subject area to another
Completed: Yes
File(s) containing feature:
- public/manage-courses.php 

#### 4. After a course has been added it should be visible on the public side of the website on the relevant subject area page
Completed: Yes
File(s) containing feature:
- public/subject-area.php 


### Ticket NMP-0004: Enquiries

#### 1. Anyone viewing the website can submit an enquiry
Completed: Yes
File(s) containing feature:
- (public/enquiry.php) 

#### 2. Submitted enquiries are visible to admins as long as they are logged in
Completed: Yes
File(s) containing feature:
- (public/admin-enquiry.php) 

#### 3. Enquiries can be marked as "Responded to" and it logs who responded to the enquiry based on who's logged in
Completed: Yes
File(s) containing feature:
- (public/admin-enquiry.php)

#### 4. Have a way to show pending enquiries (those which have not been responded to)
Completed: Yes
File(s) containing feature:
- (public/admin-enquiry.php)

#### 5. Have a way to show responded to enquiries
Completed: Yes
File(s) containing feature:
- (public/admin-enquiry.php) 


### Ticket NMP-0005: Course search

#### 1. Users can search for courses by keyword
Completed: Yes
File(s) containing feature:
- (public/search.php)

#### 2. Search results display course information
Completed: Yes
File(s) containing feature:
- (public/search.php)


### Ticket NMP-0006: Part time courses

#### 1. Add an option to mark a course as having a part time option when adding and editing a course
Completed: Yes
File(s) containing feature:
- public/manage-courses.php 

#### 2. Display whether a course can be completed part time on the course information on the list when clicking the subject area
Completed: Yes
File(s) containing feature:
- (public/subject-area.php)

#### 3. Display whether a course can be completed part time on the course information on the list in the search results from NMP-0005
Completed: Yes
File(s) containing feature:
- (public/search.php)

#### 4. Update the search functionality from NMP-0005 with an option to only show courses which can be completed part time
Completed: Yes
File(s) containing feature:
- (public/search.php)


### Ticket NMP-0007: Pagination

#### 1. Display 10 courses on the subject area page with a list of page numbers which can be clicked on and navigated to
Completed: Yes
File(s) containing feature:
- (public/subject-area.php)

#### 2. Add the same pagination to the search results page
Completed: Yes
File(s) containing feature:
- (public/search.php)
