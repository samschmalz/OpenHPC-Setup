#!/bin/bash

#check if running CentOS
if [[ $(head -n 1 /etc/os-release) != *"CentOS Linux"* ]]
then
	echo "Please run this script on CentOS Linux"
	exit
fi

#setting up php 7 repo and necessary utils
sudo yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum -y install epel-release yum-utils

sudo yum-config-manager --disable remi-php54
sudo yum-config-manager --enable remi-php73

sudo yum -y install php php-cli

#installing necessary packages
#sudo yum install -y git centos-release-scl
#sudo yum install -y rh-python36 rh-python36-python-pip

#enable python 3.6
#scl enable rh-python36 bash
#virtualenv -p python36 OpenHPC-web
#cd OpenHPC-web
#source bin/activate
#pip install --upgrade pip
#pip install flask

git clone https://github.com/samschmalz/OpenHPC-Setup.git

