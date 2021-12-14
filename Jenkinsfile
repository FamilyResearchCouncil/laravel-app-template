#!/usr/bin/env groovy
node {
    try{
        emailext    to: 'eab@frc.org',
                    body: "View build output here: $BUILD_URL/console",
                    subject: "BUILDING ${env.REPO_NAME}: ${env.BRANCH_NAME} : ${BUILD_ID}",
                    replyTo: 'eab@frc.org'

        stage('env'){

            checkout scm

//             sh "echo 'Pulling credentials from jenkins...'"

//             withCredentials([usernamePassword(credentialsId: 'database_creds', usernameVariable: 'DB_USERNAME', passwordVariable: 'DB_PASSWORD')]) {
//                 sh 'sed -i "s/^DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/" .env'
//                 sh 'sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" .env'
//             }
//             withCredentials([string(credentialsId: 'client_id', variable: 'CLIENT_ID')]) {
//                 sh 'sed -i "s/^CLIENT_ID=.*/CLIENT_ID=${CLIENT_ID}/" .env'
//             }

        }

        stage('build'){
            sh 'docker-compose up -d'
            sh 'docker-compose exec app composer install'
        }

        stage('test') {
            sh "docker-compose exec app vendor/bin/phpunit"
        }

        if( env.BRANCH_NAME == 'main' ){

            stage('deploy') {
                echo "Deploying"

//                 emailext    to: 'eab@frc.org',
//                             subject: "BUILD ${env.BRANCH_NAME} : ${env.BUILD_ID} Deployed!",
//                             body: "The api application has been bulit and deployed.",
//                             replyTo: 'eab@frc.org'
            }
        }

    } catch(error) {

        emailext    to: 'eab@frc.org',
                    body: "Pipeline error: '${error}'\nFix me please...\n\nView build output here: $BUILD_URL/console",
                    subject: "BUILD FAILED: ${env.BRANCH_NAME} : ${env.BUILD_ID}",
                    replyTo: 'eab@frc.org'

        throw error

    } finally {

        // Spin down containers no matter what happens
        sh 'docker-compose down'
        sh 'docker container prune --force'
        sh 'test -f ".env" && { rm .env; }'
    }
}
