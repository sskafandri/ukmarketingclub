#!/bin/bash

LOG=/tmp/ubloclub_dashboard.log

VERSION=$(cat /home2/jamie/public_html/projects/ubloclub_dashboard/version.txt)

echo "UBLO Club Affiliate Network - Update Script v"$VERSION

# set git repo
# git remote set-url origin https://github.com/whittinghamj/slistream_cms_production.git

# bash git update script
cd /home2/jamie/public_html/projects/ubloclub_dashboard >> $LOG
git --git-dir=/home2/jamie/public_html/projects/ubloclub_dashboard/.git pull -q origin master >> $LOG

echo "Update Complete"
echo " "
