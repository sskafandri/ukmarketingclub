#!/bin/bash

LOG=/tmp/ubloclub_dashboard.log

VERSION=$(cat /home2/ukmarketingclub/public_html/version.txt)

echo "UBLO Club Affiliate Network - Update Script v"$VERSION

# set git repo
# git remote set-url origin https://github.com/whittinghamj/slistream_cms_production.git

# bash git update script
cd /home2/ukmarketingclub/public_html >> $LOG
git --git-dir=/home2/ukmarketingclub/public_html/.git pull -q origin master >> $LOG

echo "Update Complete"
echo " "
