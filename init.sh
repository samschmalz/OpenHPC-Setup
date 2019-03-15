#!/bin/bash

if [[ $(head -n 1 /etc/os-release) != *"CentOS Linux"* ]]
then
	echo "Please run this script on CentOS Linux"
	exit
fi

yum install -y git centos-release-scl
yum install -y rh-python36 rh-python36-python-pip
