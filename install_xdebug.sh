
apt-get update &&  apt-get php7-xdebug \
    && echo "zend_extension=$(find /usr/lib/php7/modules/ -name xdebug.so)" > /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=10.254.254.254" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.remote_log=/tmp/xdebug.log" >> /etc/php7/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /etc/php7/conf.d/xdebug.ini
