ARG VERSION

FROM docker.elastic.co/elasticsearch/elasticsearch:${VERSION} as dev

ENV discovery.type=single-node

FROM dev as prod