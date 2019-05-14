#!/usr/bin/env bash

source hpc_settings

echo $SMS_IP $SMS_NAME >> /etc/hosts
systemctl disable firewalld
systemctl stop firewalld

#installing required packages
yum install http://build.openhpc.community/OpenHPC:/1.3/CentOS_7/aarch64/ohpc-release-1.3-1.el7.aarch64.rpm
yum -y install ohpc-base
yum -y install ohpc-warewulf
yum -y install ohpc-slurm-server

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

wwinit database
wwinit ssh_keys

echo "${SMS_IP}:/home /home nfs nfsvers=3,nodev,nosuid 0 0" >> $CHROOT/etc/fstab
echo "${SMS_IP}:/opt/ohpc/pub /opt/ohpc/pub nfs nfsvers=3,nodev 0 0" >> $CHROOT/etc/fstab

echo "/home *(rw,no_subtree_check,fsid=10,no_root_squash)" >> /etc/exports
echo "/opt/ohpc/pub *(ro,no_subtree_check,fsid=11)" >> /etc/exports
exportfs -a
systemctl restart nfs-server
systemctl enable nfs-server


wwbootstrap `uname -r`
wwvnfs --chroot $CHROOT
