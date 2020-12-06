ARG VERSION

FROM elasticsearch:${VERSION} as dev

ENV discovery.type=single-node

COPY permissions.sh bin/entrypoint.sh

USER root
CMD ["/bin/bash", "bin/entrypoint.sh"]

EXPOSE 9200 9300

ENTRYPOINT ["/tini", "--", "/usr/local/bin/docker-entrypoint.sh"]
CMD ["eswrapper"]

FROM dev as prod