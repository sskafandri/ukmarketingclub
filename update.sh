#!/bin/bash

LOG=/home/ukmarketingclub/public_html/ukmarketingclub.log

VERSION=$(cat /home/ukmarketingclub/public_html/version.txt)

echo "UBLO Club Affiliate Network - Update Script v"$VERSION

# bash git update script
cd /home/ukmarketingclub/public_html >> $LOG

git pull >> $LOG

echo "Update Complete"
echo " "
