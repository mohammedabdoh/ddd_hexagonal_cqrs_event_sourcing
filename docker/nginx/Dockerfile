ARG VERSION

FROM nginx:${VERSION}-alpine AS dev

COPY ./config/default.conf /etc/nginx/conf.d/default.conf

FROM dev AS prod