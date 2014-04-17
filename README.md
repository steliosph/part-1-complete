##  JOBQUEUE README 


####Installing required applications-

```
sudo aptitude install apache2 git
sudo aptitude install php5
```
might not be required
```
sudo aptitude install php5-cli
sudo aptitude install daemon
```
#####Steps for installation

1 ) Get the source code
```
cd /var/www/
sudo clone https://github.com/steliosph/part-1-complete.git jobqueue
```
 
2 ) First we need to copy the jobqueue into the init.d folder
```
sudo cp jobqueue /etc/init.d/
sudo chmod +x /etc/init.d/jobqueue
```


#####Verification
1 ) You might need to enable the pcntl on your linux installation
```
php -m | grep pcntl
```
This should return : pcntl
You should edit your cli php.ini file
```
sudo vi /etc/php5/cli/php.ini
```
and find the 
```
disable_functions=
```
remove everything after the = to enable pcntl and restart apache
```
sudo service apache2 restart
```


After that you should be able to start the script by running 
```
sudo service jobqueue start
```
