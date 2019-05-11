#!/bin/bash

#check if running CentOS
if [[ $(head -n 1 /etc/os-release) != *"CentOS Linux"* ]]
then
	echo "Please run this script on CentOS Linux"
	exit
fi

arch=`uname -p`
echo $arch

#setting up php 7 repo and necessary utils
sudo yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum -y install epel-release yum-utils

sudo yum-config-manager --disable remi-php54
sudo yum-config-manager --enable remi-php73

sudo yum -y install php php-cli php-json arp-scan nmap

#installing necessary packages
sudo yum install -y git
#sudo yum install -y rh-python36 rh-python36-python-pip

#enable python 3.6
#scl enable rh-python36 bash
#virtualenv -p python36 OpenHPC-web
#cd OpenHPC-web
#source bin/activate
#pip install --upgrade pip
#pip install flask

if [ ! -e OpenHPC-Setup ]
then
git clone https://github.com/samschmalz/OpenHPC-Setup.git
fi

sudo arp-scan --interface=enp0s3 10.0.2.0/24 | tail -n +3 | head -n -3 | awk '{print $1}' | sed "/`hostname -I`/ d" >> arp-results.txt

sudo nmap -sP -n 10.0.2.* | grep MAC | cut -d" " -f3 >> map-results.txt
