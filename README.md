# Laravel AWS S3 Integration Demo

This project is a demonstration of how to integrate AWS S3 storage into a Laravel application. It serves as a guide for getting started with AWS and using it to store and retrieve files in your Laravel applications.

## Getting Started

### Prerequisites

- PHP ^8.0.2
- Composer
- AWS Account
- AWS S3 Bucket

### Installation

1. Clone the repository:

    ```sh
    git clone https://github.com/Edmundtutu/AWS-AI-POC.git
    cd laravel-aws-s3-demo
    ```

2. Install the dependencies:

    ```sh
    composer install
    ```

3. Copy the  file to  and configure your environment variables:

    ```sh
    cp .env.example .env
    ```

4. Set up your AWS credentials in the  file:

    ```env
    AWS_ACCESS_KEY_ID=your-access-key-id
    AWS_SECRET_ACCESS_KEY=your-secret-access-key
    AWS_DEFAULT_REGION=your-region
    AWS_BUCKET=your-bucket-name
    ```

5. Generate an application key:

    ```sh
    php artisan key:generate
    ```

6. Run the migrations:

    ```sh
    php artisan migrate
    ```

### Usage
WiP