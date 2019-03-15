#!/bin/bash

#check if running CentOS
if [[ $(head -n 1 /etc/os-release) != *"CentOS Linux"* ]]
then
	echo "Please run this script on CentOS Linux"
	exit
fi

#installing necessary packages
sudo yum install -y git centos-release-scl
sudo yum install -y rh-python36 rh-python36-python-pip

scl enable rh-python36 bash

git clone https://github.com/samschmalz/OpenHPC-Setup.git
