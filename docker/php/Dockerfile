FROM debian:9

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y apt-transport-https lsb-release ca-certificates wget
RUN cd /root && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

RUN apt-get update

RUN apt-get install -y php7.2-cli php7.2-zip php7.2-xml php7.2-mbstring git unzip
                   
RUN wget "https://getcomposer.org/download/1.6.5/composer.phar" -q -O /bin/composer && chmod +x /bin/composer

CMD if [ ! -d "/app/vendor" ] ; \
    then composer install -d /app ; \
    fi ; \
    tail -f /var/log/*
