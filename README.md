
## Test Assessment by Amdocs 

Enviroment:
PHP 8.1.17
Laravel Framework 10.10.1

First run php artisan migrate to build the database 
Second run php artisan db:seed
This will make us the db with 10.000 products and 10 categories and 100 tags 

RESTful API.
Get product with filter category_id 
If you are installed locally then you can hit 
1. GET http://localhost:8000/api/products ->fetch all products if give the parameter like http://127.0.0.1:8000/api/products?category_id=3->fetch product with category_id = 3
2. POST you can create a product http://localhost:8000/api/products and send webhook when event trigger to http://httpbin.org/post tags are insered by name and code is generated by the system. 
3. PUT you can update a product  http://localhost:8000/api/products/{product} with ID and send webhook when event trigger to http://httpbin.org/put tags are insered by name and the code does not change.
4. GET http://localhost:8000/api/tags ->fetch all tags.



