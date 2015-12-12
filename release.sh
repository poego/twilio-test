#!/bin/sh

#tar czvf ../TwilioPoll.tar.gz --exclude-from tar-exclude.lst ./
tar zcvf ../TwilioPoll.tar.gz --exclude .git ./PluginManager.php ./config.yml ./ServiceProvider ./Controller ./Resource ./vendor
rm ../../ec-cube3/TwilioPoll.tar.gz
cp ../TwilioPoll.tar.gz ../../ec-cube3
