FROM nginx

RUN addgroup --system --gid 1000 sysusers
RUN adduser --system --uid 1000 --ingroup sysusers appuser

# Copy Nginx configuration
ADD ./config/nginx.conf   /etc/nginx/nginx.conf

# Save SSL Certificates
RUN mkdir /etc/nginx/ssl
ADD ./ssl/localhost.crt   /etc/nginx/ssl/localhost.crt
ADD ./ssl/localhost.key   /etc/nginx/ssl/localhost.key

# Copy the nginx configuration
RUN mkdir /etc/nginx/sites-available
ADD ./config/default.conf   /etc/nginx/sites-available/default.conf

# create root folder
RUN mkdir -p /var/www/html

RUN touch /var/run/nginx.pid \
 && chown -Rf appuser:sysusers \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx

USER appuser