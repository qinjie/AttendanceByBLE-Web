# Attendance Taking server
**Attendance Taking** provides an innovative way to take attendance based on **Bluetooth Low Energy**. The system contains 3 components:
- Android App for Student
- Android App for Lecturer
- PHP Server

**This repository** is **PHP Server** of the system.

## Server Description
* **Attendance Taking Server** uses [Yii2 framework](http://www.yiiframework.com/). It provides API services for Mobile Apps.
* **API URL**: ```188.166.247.154/atk-ble/api/web/index.php/v1/```
* **Backend URL**: ```188.166.247.154/atk-ble/backend/web/index.php/v1/```

## Resources
* [API Reference](API.md)
* [Helpful commands when working with server code](COMMANDS.md)
* [Database Reference](DATABASE.md)
* [Yii2 documentation](http://www.yiiframework.com/doc-2.0/guide-index.html)

## Rules of Attendance System
- Unique device for each student
- Newly registered device will be activated only on next day
- Student can only take attendance inside the classroom

## Set up server in Ubuntu
Instructions for setting up server

1. Install ```LAMP``` [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04)
2. Install ```Git``` [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-14-04)
3. Clone this repository
4. Install ```Composer``` [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
5. Go to repository directory. Run ```composer install```
6. Go to repository directory. Run ```php init```
7. Run this sql file ```docs/atk_ble.sql``` in repository directory
8. Edit database configuration in ```common/config/main-local.php```
9. Change permissions of these folders to be writable. Run ```chmod -R 777 api/runtime api/web/assets backend/runtime backend/web/assets frontend/runtime frontend/web/assets console/runtime``` in repository directory.

## Testing
Instructions for testing server code.
Database for testing is in ```tests/codeception/api/_data/dump.sql```

1. Install [codeception](http://codeception.com/install)
2. From repository directory, go to ```tests/codeception/api```
3. Run ```codecept build``` to init tests
4. Run ```codecept run functional``` to run tests
5. You can write tests in directory ```tests/codeception/api/functional```
6. Run ```codecept run functional AttendanceCest``` to run test file ```AttendanceCest.php```

## Server batch scripts
Server batch scripts are inside ```cronjobs``` folder.
- ```db.py``` contains configuration for database
- ```device_activation.py``` is run at the end of the day to activate all newly registered devices in that day.
- ```loop_device_activation.sh``` is used for testing. It runs ```device_activation.py``` every 10 seconds.
- ```past_attendance.py``` is used for testing. It generates all attendance records in previous days.
