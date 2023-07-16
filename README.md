Chat Application

The Chat Application is a backend system that allows users to create chat groups, join existing groups, and send messages within those groups. It is built using PHP and utilizes a SQLite database to store the data. The communication between the client and server is handled through a RESTful JSON API over HTTP(s).
Features

    User creation: Users can be created using the /user/create endpoint.
    Group creation: Users can create chat groups using the /group/create endpoint.
    Group joining: Users can join existing chat groups using the /group/{group_id}/join endpoint.
    Message sending: Users can send messages within a chat group using the /group/{group_id}/message/create endpoint.
    Message listing: Users can retrieve a list of all messages within a chat group using the /group/{group_id}/messages endpoint.

Project Structure

The project follows the structure below:

    api.php: Contains the routes and endpoints for handling user, group, and message operations using the Slim framework.
    UserController.php: Controller class for user-related operations, including user creation.
    GroupController.php: Controller class for group-related operations, including group creation and joining.
    MessageController.php: Controller class for message-related operations, including message creation and listing.
    tests/: Directory containing test files for unit testing the application.

Running Tests

To run the tests for the chat application, you can use the following commands:

    phpunit tests/MessageTest.php: Runs the tests for message-related operations.
    phpunit tests/GroupTest.php: Runs the tests for group-related operations.
    phpunit tests/UserTest.php: Runs the tests for user-related operations.

Installation and Usage

To install and use the Chat Application, follow these steps:

    Clone the repository: git clone <repository-url>
    Install the required dependencies: composer install
    Configure the database: Update the database configuration in config/database.php to point to your SQLite database file.
    Start the development server: php -S localhost:8000 -t public

Contributing

Contributions to this project are welcome. If you find any issues or have suggestions for improvement, please open an issue or submit a pull request.