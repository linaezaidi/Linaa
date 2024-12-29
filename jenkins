pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Building the application...'
                sh 'dotnet build'
            }
        }
        stage('Tests Unitaires') {
            steps {
                echo 'Running unit tests...'
                sh 'dotnet test'
            }
        }
        stage('Analyse SonarQube') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh 'dotnet sonarscanner begin /k:"MyProjectKey" /d:sonar.host.url="http://<sonar_url>" /d:sonar.login="<token>"'
                    sh 'dotnet build'
                    sh 'dotnet sonarscanner end /d:sonar.login="<token>"'
                }
            }
        }
        stage('Créer Image Docker') {
            steps {
                echo 'Building Docker image...'
                sh 'docker build -t myproject:latest .'
            }
        }
        stage('Push vers DockerHub') {
            steps {
                withCredentials([string(credentialsId: 'dockerhub-token', variable: 'DOCKERHUB_TOKEN')]) {
                    sh 'echo $DOCKERHUB_TOKEN | docker login --username mydockerhubuser --password-stdin'
                    sh 'docker tag myproject:latest mydockerhubuser/myproject:latest'
                    sh 'docker push mydockerhubuser/myproject:latest'
                }
            }
        }
        stage('Déploiement sur Serveur Distant') {
            steps {
                echo 'Deploying to remote server...'
                sh 'scp docker-compose.yml user@remote-server:/path/to/deploy'
                sh 'ssh user@remote-server "docker-compose up -d"'
            }
        }
    }

    post {
        success {
            echo 'Pipeline terminé avec succès.'
        }
        failure {
            echo 'Pipeline échoué.'
        }
    }
}
