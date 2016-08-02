FROM fogcitymarathoner/dockerfile-php5.6.22-python2.7.11:latest

ENV PYTHONUNBUFFERED 1
ENV TERM=xterm

RUN apt-get update

RUN mkdir /mnt/src
RUN mkdir /rrg

ADD . /rrg
WORKDIR /rrg

RUN pwd
RUN /usr/local/bin/easy_install-2.7 pip

RUN /usr/local/bin/pip2.7 install -r requirements.txt