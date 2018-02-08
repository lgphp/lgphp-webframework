#FROM php7-nginx-swoole2-lgphpweb-yaml:latest
#ADD . /var/www
#EXPOSE 3008
#CMD ["php","Main.php"]


docker run -d  -p 1999:80 -p 1308:3008 --restart=always  -v /Users/lgphp/myapp/php/demoswoole:/var/www -e EUREKA_IP=http://172.16.10.84:1111/eureka -e SERVER_IP=172.17.10.95 -e SERVER_PORT=1308 -e SERVICE_NAME=swoole  php72

docker run -d  -p 1999:80 -p 1308:3008 --restart=always  -v /Users/lgphp/myapp/php/demoswoole:/var/www -e EUREKA_IP=http://192.168.0.101:1111/eureka -e SERVER_IP=192.168.0.101 -e SERVER_PORT=1308 -e SERVICE_NAME=swoole  php72