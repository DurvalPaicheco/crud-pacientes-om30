FROM wyveo/nginx-php-fpm:latest
COPY ./files/default.conf /etc/nginx/conf.d/default.conf

copy ./files/run.sh /tmp    
run chmod +x  /tmp/run.sh
#run bash /tmp/run.sh --rm=false
#ENTRYPOINT ["/tmp/run.sh"]

WORKDIR /usr/share/nginx/
RUN rm -rf /usr/share/nginx/html
RUN ln -s public html


# copy ./files/run.sh /tmp    
# run chmod +x  /tmp/run.sh
# run bash /tmp/run.sh
# ENTRYPOINT ["/tmp/run.sh"]

