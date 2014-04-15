/**********
   README 
/**********/


-Installing required applications-

- sudo aptitude install apache
- sudo aptitude install php5
- sudo aptitude install php5-cli
- sudo aptitude install daemon


-Steps for installation-


1 ) First we need to copy the jobqueue into the init.d folder
 - sudo cp jobqueue /etc/init.d/jobqueue
 - sudo chmod +x /etc/init.d/jobqueue

2 ) Out scripts assumes that you will be running the jobqueue from a default place. So we will need to move this to the proper location
Assuming that /var/www directory is not created.
 - sudo mkdir /var
 - sudo mkdir /var/www
 - sudo mkdir /var/www/jobqueue
 - sudo cp * /var/www/jobqueue ( move all the directory content into the jobgueue directory )





