FROM nginx:1.14.0-alpine

ADD vhosts.conf /etc/nginx/conf.d/default.conf