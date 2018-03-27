This is a basic web application without input filtering from the form.
Normally I would have input filters before populating the entities and more validation in the entities.

The Vagrant box should just initialise with a crude bash script to generate the database set up.
It's not how I would usually set a database up but for the purpose of this, its only to get a simple demo up and running.

The Vagrantconfig.yml is set up to listen to HTTP requests on 192.168.33.10. You can change this if required.

I couldn't get the composer install to work correctly in the vm on provision in time. It keeps getting 'Killed'.
You will need to run `composer.phar install` in the app directory.