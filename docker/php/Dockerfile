FROM php:7.4.2-fpm

RUN addgroup --system --gid 1000 sysusers
RUN adduser --system --uid 1000 --ingroup sysusers appuser

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
 
USER appuser
 
CMD ["php-fpm", "--nodaemonize"]