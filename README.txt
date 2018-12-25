
Documentation : http://cdapi.com/api/doc

SQLs database : ROOT/api.sql

user:
 - register: POST /api/register
 - login: POST /api/login_check
 
products:
 - add: POST /api/v1/products
 - edit: PUT /api/v1/products  //not done
 - delete: DELETE /api/v1/products/{id}  //not done
 - list: GET /api/v1/products
 - list-item: GET /api/v1/products/{id}   //not done
