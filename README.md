# Retool Gql Api Support

**Disclaimer:** 
This project is intended for educational purposes only.
It is not designed for production use and may not follow best practices for deployment, security, or scalability.
Use it as a learning resource and modify as needed for your own projects.

## Table of Contents

•	Overview
•	Features
•	Installation
•	Usage
•	Environment Variables
•	API Endpoints
•	Built With
•	Project Structure
•	Running with Docker Compose
•	Contributing
•	License

## Overview

Project Name is a demo integration with retool views.
This project was created to demonstrate the core concepts of creating a graphql api consumable by retool and serves as a reference or starting point for similar projects.

## Features

•	📄 Feature 1: Describe what it does and why it’s valuable.
•	🔒 Feature 2: Explain another feature.
•	🚀 Feature 3: Highlight any unique capabilities.

### Installation

To get started with the project, follow these steps:

Prerequisites

•	PHP
•	Docker
•	NodeJs

### Clone the Repository

```bash
git clone https://github.com/decebal/retool-gql-api.git
cd retool-gql-api
```

## Install Dependencies

```bash
composer install
npm install
```

### Database Setup

Make sure to set up a local or cloud database and add the connection details to .env.

```bash
php artisan migrate --seed
```

### Generate Application Key

```bash
php artisan key:generate
```

### Usage

Start the local development server with:

```bash
php artisan serve
```
Then visit http://localhost:8000 in your browser to access the application.

### Environment Variables

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


### API Endpoints

#### Authentication

•	POST /api/login: Authenticate a user.
•	POST /api/refresh: Refresh the access token.

#### Orders

•	GET /api/orders: Retrieve all orders.
•	POST /api/orders: Create a new order (Admin only).

#### Products

•	GET /api/products: List all products.
•	PATCH /api/products/{id}: Update a product’s delivery time and status (Supplier only).

### Built With

•	Laravel - PHP framework for web applications
•	GraphQL - Query language for APIs
•	DigitalOcean - Cloud provider for deployment

### Project Structure

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

### Running with Docker Compose

To simplify the setup, you can run the entire application with Docker Compose. This will spin up all necessary services, such as the web server, database, and any other dependencies defined in `docker-compose.yml`.

#### Prerequisites

- Ensure Docker and Docker Compose are installed. You can follow the official installation guides for [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/).

#### Steps to Run the Project with Docker Compose

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/decebal/retool-gql-api.git
   cd retool-gql-api
   ```

2. **Set Up Environment Variables**:

    - Copy `.env.example` to `.env` and configure any necessary values.

      ```bash
      cp .env.example .env
      ```

    - Update database, cache, and other configurations in `.env` if needed.

3. **Build and Start the Docker Containers**:

    - Run the following command to build and start the containers:

      ```bash
      docker compose up --build
      ```

    - This command will build the Docker images if they don’t already exist and start all containers defined in `docker-compose.yml`.

4. **Access the Application**:

    - Once the containers are up and running, you can access the application in your browser at `http://localhost:8000` (or another port if specified in `docker-compose.yml`).

5. **Running Migrations**:

    - To set up the database schema, run migrations inside the running application container:

      ```bash
      docker compose exec app php artisan migrate --seed
      ```

    - This command runs migrations and seeds the database (if you have seeders) in the `app` container.

6. **Stopping the Containers**:

    - To stop the containers, press `Ctrl + C` if you ran Docker Compose in the foreground, or run:

      ```bash
      docker compose down
      ```

    - This will stop and remove the containers, but the built images will remain for faster startup next time.

7. **Rebuilding Containers** (Optional):

    - If you make changes to `Dockerfile` or `docker-compose.yml`, you may need to rebuild the containers:

      ```bash
      docker compose up --build
      ```

### Additional Docker Compose Commands

- **View Logs**: To view logs for all services, use:

  ```bash
  docker compose logs -f
  ```

- **Access a Container’s Shell**: To open a bash shell in the `app` container:

  ```bash
  docker compose exec app bash
  ```

This setup allows you to easily run, test, and develop the application in a containerized environment. Modify paths or commands as needed based on your specific setup and configuration.

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

