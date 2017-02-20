FROM centos:centos6

MAINTAINER carrola

RUN yum -y update

RUN yum -y install httpd gcc make git mysql-server mysql mysql-client python-setuptools

RUN rpm -Uvh http://ftp.iij.ad.jp/pub/linux/fedora/epel/6/x86_64/epel-release-6-8.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum -y install --enablerepo=remi --enablerepo=remi-php56 php php-opcache php-devel php-mbstring php-mcrypt php-mysqlnd php-pecl-xdebug php-pecl-xhprof pcre-devel php-gd php-gmp


RUN git clone --depth=1 git://github.com/phalcon/cphalcon.git /root/phalcon
RUN  cd /root/phalcon && git checkout phalcon-v2.0.9
RUN cd /root/phalcon/build && ./install 64bits
RUN echo extension=/usr/lib64/php/modules/phalcon.so >> /etc/php.d/phalcon.ini



ADD nginx.conf /etc/nginx/nginx.conf
ADD default /etc/nginx/sites-enabled/default

RUN yum -y install --enablerepo=remi --enablerepo=remi-php56 php-fpm

RUN yum -y install --enablerepo=remi --enablerepo=remi-php56 nginx




EXPOSE 80
RUN echo date.timezone = "Europe/Lisbon" >> /etc/php.ini

ADD nginx.conf /etc/nginx/nginx.conf
ADD default /etc/nginx/sites-enabled/default

RUN sed -i "s/short_open_tag = .*/short_open_tag = On/" /etc/php.ini
RUN sed -i "s/apache/nginx/" /etc/php-fpm.d/www.conf
RUN chown -R nginx:nginx /var/www/html
RUN usermod -G nginx nginx
RUN chmod -R 777 /var/www/html

# Installing supervisor

RUN yum install -y python-setuptools
RUN easy_install pip
RUN pip install supervisor

ADD supervisord.conf /etc/

#CMD ["supervisord", "-n"]
CMD service php-fpm start && nginx
