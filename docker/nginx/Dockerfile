ARG VERSION

FROM nginx:${VERSION}-alpine AS dev

COPY config/default-dev.conf /etc/nginx/conf.d/default.conf

FROM dev AS prod

COPY config/default-prod.conf /etc/nginx/conf.d/default.conf