# PHP API Implementation for ReactJS Client
This repository contains the PHP API implementation required to provide data from a MySQL database instance to the ReactJS client.

## Server Details
- **Server**: Apache/PHP
- **Client**: Postman
- **Database**: MySQL

## Task Description
The task involves implementing the server components in PHP to facilitate communication between the ReactJS client and a MySQL database instance. 
The API endpoints are designed to handle various operations related to the following database entities:
- **Product**: Contains fields for description, image, pricing, and shipping cost.
- **User**: Includes fields for email, password, username, purchase history, and shipping address.
- **Comments**: Relates to product reviews with fields for product, user, rating, image(s), and text.
- **Cart**: Manages user's shopping cart with fields for products, quantities, and user information.
- **Orders**: Includes fields such as like user_id, products,id

## Testing
I have conducted a thorough validation of our API endpoints using Postman, meticulously assessing their performance in both successful and error scenarios. 

### Testing Endpoints
- Used Postman to send requests to the implemented API endpoints.
- Validated the functionality of CRUD operations for each entity in my database.

