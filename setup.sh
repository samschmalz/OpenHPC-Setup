#!/usr/bin/env bash

source hpc_settings

sudo echo $SMS_IP $SMS_NAME >> /etc/hosts
sudo systemctl disable firewalld
sudo systemctl stop firewalld

#installing required packages
sudo yum install http://build.openhpc.community/OpenHPC:/1.3/CentOS_7/aarch64/ohpc-release-1.3-1.el7.aarch64.rpm
sudo yum -y install ohpc-base
sudo yum -y install ohpc-warewulf
sudo yum -y install ohpc-slurm-server

#setting up Warewulf
perl -pi -e "s/device = eth1/device = ${SMS_ETH_INTERNAL}/" /etc/warewulf/provision.conf
perl -pi -e "s/^\s+disable\s+= yes/ disable = no/" /etc/xinetd.d/tftp
ifconfig ${SMS_ETH_INTERNAL} ${SMS_IP} netmask ${INTERNAL_NETMASK} up

systemctl restart xinetd
systemctl enable mariadb.service
systemctl restart mariadb
systemctl enable httpd.service
systemctl restart httpd
systemctl enable dhcpd.service

#defining compute image
export CHROOT=/opt/ohpc/admin/images/centos7.6
wwmkchroot centos-7 $CHROOT
yum -y --installroot=$CHROOT install ohpc-base-compute
cp -p /etc/resolv.conf $CHROOT/etc/resolv.conf
yum -y --installroot=$CHROOT install ohpc-slurm-client ntp kernel lmod-ohpc
