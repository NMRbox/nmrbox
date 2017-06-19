# NMRbox Angular-Heroku App

This project is a clone of 'Angular-Heroku Boilerplate App' `git@gitlab.com:visallimedia/angular-heroku-boilerplate.git`, which was generated with [Angular CLI](https://github.com/angular/angular-cli) version 1.0.1.

VERSION 0.6 - Styling

## Development server

Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The app will automatically reload if you change any of the source files.

### Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|module`.

### Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory. Use the `-prod` flag for a production build.

### Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

### Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via [Protractor](http://www.protractortest.org/).
Before running the tests make sure you are serving the app via `ng serve`.

### Further help

To get more help on the Angular CLI use `ng help` or go check out the [Angular CLI README](https://github.com/angular/angular-cli/blob/master/README.md).

## Remote Heroku server

Create Heroku server instance by running `heroku create` and then `heroku open` to view the new site in the browser. 

Commit changes and run `git push heroku master` to re-build the node environment and angular app.

NOTE: unique scripts are defined in package.json to run `ng build -prod` and move build files to root directory.

## GitLab updates

Run `git push origin master`
