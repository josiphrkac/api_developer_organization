
# Containerized API

This is an API that has been containerized using Docker Compose and built with PHP and MySQL. By cloning this repository and running the command `docker-compose up`, you can easily launch the API on your local machine.

## Prerequisites

- Docker and Docker Compose installed on your system.

## Installation and Usage

- Clone this repository to your local machine.
- Navigate to the root directory of the project.
- Install vendor packages for dotenv - Follow the steps:https://github.com/vlucas/phpdotenv
- Start the Docker Compose containers: `docker-compose up`.
- Open your preferred web browser and go to http://localhost:80 to access the API.

### Configuration

The following environment variables can be configured through a `.env` file in the `api_php` directory:

- `DB_HOST`: The hostname of the MySQL database container.
- `DB_NAME`: The name of the MySQL database.
- `DB_USER`: The username of the MySQL database user.
- `DB_PASSWORD`: The password of the MySQL database user.
- `DB_PORT`: Set it equal to the port number you want to use for your MySQL database.

Make sure to update the values in the `.env` file according to your desired configuration.


