# MORPH – WordPress Starter Theme

A minimalistic starter theme for WordPress that speeds up the process of website development, simplifies tech support and scales projects.

## Features
- **Design System**: Inspired by the best design practices, MORPH contains basic rules, typography, color palettes, icons, buttons, and other elements, ensuring consistency and a professional look for your project.
- **Local Development Environment with Docker**: Offers a configured local development environment based on Docker for quick and reliable project deployment. This allows you to focus on development, bypassing server configuration complexities.
- **Project Build Automation with Gulp**: Using Gulp, project build tasks are automated, simplifying the development process and optimizing the workflow.
- **Core WordPress Functionality and Custom Features**: Includes not only core WordPress features but also custom functions necessary for developing unique and functional websites.

## Prerequisites
- [Docker](https://www.docker.com)
- [PHP](https://www.php.net) >= 8.0
- [Composer](https://getcomposer.org)
- [Node](https://nodejs.org/en) >= 20
- [NPM](https://www.npmjs.com) >= 10
- [Gulp CLI](https://gulpjs.com)

## Installation
1. Clone this repository to your local machine
2. Use the ```cp .env.example .env``` command to copy the environment variables file and edit it.
3. Use the command ```cp auth.example.json auth.json``` to copy the ACF Pro credentials file, to [install the plugin using composer](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/)
4. Start the container with the command ```docker-compose up -d```
5. Change permissions to the folder ```sudo chmod 777 -R web mysql```
6. Install composer dependencies ```composer update```
7. Go to the theme folder ```cd web/app/themes/morph``` and install npm dependencies ```npm install```

To have Git ignore ```chmod``` changes, update local git config with the command ```git config --local core.fileMode false```
