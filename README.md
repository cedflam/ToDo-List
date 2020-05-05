# ToDo-List
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/88550bed395947ae88f2e8408110e13e)](https://www.codacy.com/manual/cedflam/ToDo-List?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=cedflam/ToDo-List&amp;utm_campaign=Badge_Grade)

## Context : 
You have just joined a startup whose core business is an application for managing its daily tasks. The company has just started up, and the application had to be developed at full speed to show potential investors that the concept is viable (we speak of Minimum Viable Product or MVP).

The choice of the previous developer was to use the PHP Symfony framework, a framework that you are starting to know well!

Good news ! ToDo & Co has finally succeeded in raising funds to allow the development of the company and especially the application.

So your role here is to improve the quality of the application. Quality is a concept that encompasses a number of subjects: we often talk about code quality, but there is also the quality perceived by the user of the application or the quality perceived by the company's employees, and finally the quality that you perceive when you need to work on the project.

So, for this last specialization project, you are in the shoes of an experienced developer in charge of the following tasks:

the implementation of new features;
the correction of some anomalies;
and the implementation of automated tests.
You are also asked to analyze the project using tools allowing you to have an overview of the quality of the code and the various performance axes of the application.

You are not asked to correct the points raised by the code quality and performance audit. That said, if time permits, ToDo & Co will be happy to reduce the technical debt for this application.

## Built With

|Backend                        |Frontend                     |Tests       |Library         |
|-------------------------------|-----------------------------|------------|----------------|
|Symfony 5                      |React                        |PHPUnit     |fzaninotto/faker|
|Doctrine                       |jQuery                       |Blackfire   |axios           |
|                               |Bootstrap                    |            |                |

## Install
  1. Clone or download the repository into your environment.   
  2. Run "composer install" in terminal
  3. Install the database (php bin/console doctrine:database:create) and load migrations (php bin/console make:migration and php              bin/console doctrine:migrations:migrate).
  4. Load fixtures (php bin/console doctrine:fixtures:load)

### Note :
###### parameters:
  ###### In .env file (DATABASE_URL): 'mysql://db_user:db_password@127.0.0.1:3306/db_name'
  ###### connexion with admin : email = admin@admin.fr pass = password
  ###### connexion with user  : email = user@user.fr   pass = password

