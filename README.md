# Retool Gql Api Support

	Disclaimer: This project is intended for educational purposes only. It is not designed for production use and may not follow best practices for deployment, security, or scalability. Use it as a learning resource and modify as needed for your own projects.

## Table of Contents

	•	Overview
	•	Features
	•	Installation
	•	Usage
	•	Environment Variables
	•	API Endpoints
	•	Built With
	•	Project Structure
	•	Contributing
	•	License

## Overview

Project Name is a [brief description of what the project does and its purpose]. This project was created to demonstrate the core concepts of [relevant technologies or frameworks] and serves as a reference or starting point for similar projects.

## Features

	•	📄 Feature 1: Describe what it does and why it’s valuable.
	•	🔒 Feature 2: Explain another feature.
	•	🚀 Feature 3: Highlight any unique capabilities.

## Installation

To get started with the project, follow these steps:

Prerequisites

	•	Software requirement 1
	•	Software requirement 2

## Clone the Repository

```bash
git clone https://github.com/yourusername/yourprojectname.git
cd yourprojectname
```

## Install Dependencies

```bash
composer install
npm install
```

## Database Setup

Make sure to set up a local or cloud database and add the connection details to .env.

```bash
php artisan migrate --seed
```

## Generate Application Key

```bash
php artisan key:generate
```

## Usage

Start the local development server with:

```bash
php artisan serve
```
Then visit http://localhost:8000 in your browser to access the application.

## Environment Variables

To configure the project, create a .env file based on .env.example and update the following:

```bash
APP_NAME=YourAppName
APP_ENV=local
APP_KEY=base64:GeneratedAppKey
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdatabase
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword
```
Note: You may need to set additional environment variables based on your setup, such as API keys and external service URLs.


## API Endpoints

### Authentication

	•	POST /api/login: Authenticate a user.
	•	POST /api/refresh: Refresh the access token.

### Orders

	•	GET /api/orders: Retrieve all orders.
	•	POST /api/orders: Create a new order (Admin only).

### Products

	•	GET /api/products: List all products.
	•	PATCH /api/products/{id}: Update a product’s delivery time and status (Supplier only).

## Built With

	•	Laravel - PHP framework for web applications
	•	GraphQL - Query language for APIs
	•	DigitalOcean - Cloud provider for deployment

## Project Structure

```paintext
retool-gql-api/
├── app/                # Application core files
├── config/             # Configuration files
├── database/           # Migrations and seeds
├── public/             # Public assets and index.php
├── resources/          # Views, layouts, and frontend assets
├── routes/             # Web and API route definitions
├── tests/              # Automated tests
└── README.md           # Project README file
```

## Contributing

Contributions are welcome! If you’d like to improve this project:

	1.	Fork the repository.
	2.	Create a new branch (git checkout -b feature-branch).
	3.	Make your changes and commit them (git commit -am 'Add new feature').
	4.	Push to the branch (git push origin feature-branch).
	5.	Open a Pull Request.

## License

This project is licensed under the MIT License. You are free to use, modify, and distribute this code with proper attribution.

This README provides a comprehensive introduction and setup guide for your repository, making it easy for others to understand and contribute. Adjust each section as needed to fit your specific project!


# TODO:

6. Retool Configuration

Set up Retool views for Admin and Supplier roles:

	•	Admin View:
	•	Use GraphQL query for orders and products.
	•	Provide fields to add new orders (limited to Admin role).
	•	Supplier View:
	•	Use GraphQL mutations to update deliveryTime and deliveryStatus for products (limited to Supplier role).

