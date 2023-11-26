# product-management-system

## Patients System
The system aims to provide a comprehensive platform for managing patient information, including personal details, next of kin, medical conditions, allergies, and medication records. It facilitates CRUD (Create, Read, Update, Delete) operations on patient-related data, with features such as dynamic form creation, collapsible sections, and interactive user interfaces. Additionally, the system includes functionality for inserting patient data from a JSON file using a custom Artisan command.

## Before you start

- Create two databases "patientsSystem"
- DB user name = root
- DB password = 
- To create tables and seed data please run "php artisan migrate:refresh --seed" in command line
- To run command please run "php artisan insert:patient-data storage/app/patient.json" in command line to import data
- Run php artisan serve and then open this link in browser http://localhost:8000/patients/list
