FROM wyveo/nginx-php-fpm:latest
#RUN rm /etc/nginx/config.d/default.conf
COPY ./files/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /usr/share/nginx/
RUN rm -rf /usr/share/nginx/html
RUN ln -s public html

