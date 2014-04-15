/**********
   README 
/**********/


-Installing required applications-

- sudo aptitude install apache2 git
- sudo aptitude install php5
- sudo aptitude install php5-cli
- sudo aptitude install daemon


-Steps for installation-

1 ) Get the source code
 - cd /var/www/
 - sudo clone https://github.com/steliosph/part-1-complete.git
 - sudo mv part-1-complete jobqueue
 
2 ) First we need to copy the jobqueue into the init.d folder
 - sudo cp jobqueue /etc/init.d/
 - sudo chmod +x /etc/init.d/jobqueue



After that you should be able to start the script by running 

sudo service jobqueue start



