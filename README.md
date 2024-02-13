
# FTRU ECommerce

FTRU is a comprehensive eCommerce platform built on Laravel, designed to provide users with a seamless shopping experience. Whether you're a customer browsing products or an admin managing category, subCategory, products, customers, orders and inventory, FTRU offers a user-friendly interface and robust features to meet your needs.


## Table of Contents
* Installation
* Usage
* Features
* Technologies Used
* License
## Installation

Install FTRU ECommerce

1- clone this repo
```bash
  git clone https://github.com/RizkUssef/FTRU-Backend-E-Commerce.git
```
2- cd into it
```bash
cd FTRU-Backend-E-Commerce
```

3- run composer install
```bash
composer install
```
    
## Usage

1- create new database

2- setup the .env file
`
Rename the .env.example file to .env and input your configuration settings within it.
`

3- Run php artisan key:generate
```bash
php artisan key:generate
```
4- run the project
```bash
php artisan serv
```
5- create all the table in the database
```bash
php artisan migrate
```
6- create the admin in the database
```bash
php artisan db:seed
```
7- run storage:link
```bash
php artisan storage:link
```
8- run the schedule
```bash
php artisan schedule:run
```
9- to access the home page use this link "http://127.0.0.1:8000/FTRU/Home"

10- to access the dashboard use this link "http://127.0.0.1:8000/Dashboard"
Note: credentials to access admin panel (email: `admin@ftru.com`, password: `12345678910`)
after you login as admin, you can access the admin page from "http://127.0.0.1:8000/Dashboard"




## Features

- ### User Features:
    - #### ___User Management:___
        - User registration
        - User login and authentication
        - User profile management
    - #### ___Product Browsing and Shopping:___
        - Browse products by categories and subCategory
        - Search products by keywords
        - View product details, including images, and prices
        - Add products to the shopping cart
        - Manage the shopping cart (update quantities, remove items)
        - Proceed to checkout and place orders
        - Track order status and history
        - Leave reviews and ratings for products
        - Create and manage a wishlist
    - #### ___Account Management:___
        - Update user profile information
        - View and manage order history
- ### Admin Features:
    - #### ___Admin Dashboard:___
        - Admin login and authentication
        - Dashboard overview with key statistics and reports
    - #### ___Product Management:___
        - Add new products
        - Edit existing product information
        - Manage product categories and subCategory
        - Upload and manage product images
        - Set product pricing and inventory levels
    - #### ___Order Management:___
        - View and manage orders (view details, update status, generate invoices)
        - Track order fulfillment and delivery
    - #### ___User Management:___
        - View all user acounts
    - #### ___Sales Reports and Analytics:___
        - Generate sales reports and analytics
    - #### ___Responsive Design:___
        - Ensure the website is optimized for all devices and screen sizes

## Technologies Used

**Front-End:** HTML, Css, Scss, JavaScript

**Back-End:** PHP, Laravel


## License

[MIT](https://choosealicense.com/licenses/mit/)

