FROM composer

RUN addgroup --system --gid 1000 sysusers
RUN adduser --system --uid 1000 --ingroup sysusers appuser

WORKDIR /app
USER appuser

ENTRYPOINT [ "sleep", "infinity" ]