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
            sh "DISPLAY=:0 chromedriver &"
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
        archiveArtifacts 'tests/Browser/screenshots/**'
    }
}