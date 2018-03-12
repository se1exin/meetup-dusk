#!/usr/bin/env groovy

node('master') {
    try {
        stage('build') {
            checkout scm

            sh "cp .env.circleci .env"
            sh "composer install --no-interaction"
            sh "php artisan key:generate"

            sh "npm install"
            sh "npm run prod"
        }

        stage('test') {
            sh -e "Xvfb -ac :0 -screen 0 1280x100000x16 &"
            sh "chromedriver &"
            sh "php artisan serve &"
            sh "./vendor/bin/phpunit tests"
        }

        stage('deploy') {
            // ansible-playbook -i ./ansible/hosts ./ansible/deploy.yml
            sh "echo 'WE ARE DEPLOYING'"
        }
    } catch(error) {
        sh "echo 'JENKINS FILE ERROR'"
        throw error
    } finally {

    }
}