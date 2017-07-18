# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

# CHOOSE BOX  
#  config.vm.box = "web_dev"
  config.vm.box = "ubuntu/xenial64"
#  config.vm.box = "phalconphp/xenial64"

### NAME THE VM ###
  config.vm.provider "virtualbox" do |v|
    ### CHANGE NAME FOR MV ###
	v.name = "TWClone_VM"
  end

#  config.ssh.insert_key = false
  
#  config.vm.network "forwarded_port", guest: 6379, host: 6379
#  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.network "private_network", ip: "192.168.77.200"
#######################################
###----- PUBLIC NETWORK ACCESS -----###
### AT WORK ###
###############
#  config.vm.network "public_network", ip:"192.168.88.200"
  # bridge:“en0: Wi-Fi (AirPort)”,
###############
### AT HOME ###
###############
#  config.vm.network "public_network", ip:"192.168.7.77"
#-------------------------------------------------------------------#
  config.vm.synced_folder ".", "/vagrant/", :mount_options => ["dmode=777", "fmode=666"]
  config.vm.synced_folder "./www", "/vagrant/www/", :mount_options => ["dmode=775", "fmode=644"], :owner => 'ubuntu', :group => 'www-data'

#  config.ssh.private_key_path = "~/.vagrant.d/insecure_private_key"
  
end
