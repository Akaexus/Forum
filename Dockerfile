FROM ubuntu:20.04
CMD apt update && apt-add-repository ppa:ondrej/php
CMD apt install apache2 mysql php8.0