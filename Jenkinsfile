#!/usr/bin/env groovy

node('master') {
    try {
        stage('build') {
            checkout scm

            sh "cp .env.circleci .env"
            sh "composer install --no-interaction"
            sh "php artisan key:generate"
        }

        stage('prepare_test') {
            sh export DISPLAY=:99.0
            sh -e /etc/init.d/xvfb start
            sh ./vendor/laravel/dusk/bin/chromedriver-linux &
            sh php artisan serve &
        }

        stage('test') {
            sh "./vendor/bin/phpunit tests"
        }

        stage('deploy') {
            // ansible-playbook -i ./ansible/hosts ./ansible/deploy.yml
            sh "echo 'WE ARE DEPLOYING'"
        }
    } catch(error) {
        throw error
    } finally {

    }

}
