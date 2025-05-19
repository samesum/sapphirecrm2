Reuseable Functions

1. Function for DataTable
----------------------------------------------------
Function Name:
    - server_side_datatable()
Location:
    - resources/view/components/datatable.blade.php
Purpose:
    - The server_side_datatable() function is responsible for loading data dynamically from the database into a DataTable using server-side processing. It ensures efficient data handling, especially for large datasets, by fetching data on demand rather than loading all records at once.

Working Process:
    - Ensure DataTable Structure
    - The HTML structure of the DataTable must include <thead> and <tbody> elements.
    - Call JavaScript Function
    - The server_side_datatable() function is called within a script tag in the DataTable component.

It accepts two parameters:
    - Column Names (JSON Format): Defines the columns of the DataTable.
    - Data Route (URL): Specifies the API endpoint that returns the required dataset.
    - Server-Side Data Fetching
    - The function sends an AJAX request to the specified route.
    - This request is processed by the ServerSideDataController, where a relevant function retrieves the required rows from the database.
    - The response is then populated in the DataTable dynamically.

2. Form Submit by AJAX
----------------------------------------------------
Function Name:
    - handleAjaxFormSubmission()
Location:
    - resources/view/script.blade.php
    - line - 313
Purpose:
    - The handleAjaxFormSubmission() function is responsible for submit form with ajax and data dynamically ADD, EDIT operation with database. It ensures efficient data handling, especially for first and improve crud operation
Working Process:
    - Ensure you create a normal form with post method
    - The HTML structure of the DataTable must include <thead> and <tbody> elements.
    - Call JavaScript Function
    - The server_side_datatable() function is called within a script tag in the DataTable component.