docker run -d --name datadog-agent \
           --cgroupns host \
           --pid host \
           -e DD_API_KEY=531c5f36ab7c5e72aefd7a27f11ff43a \
           -e DD_LOGS_ENABLED=true \
           -e DD_LOGS_CONFIG_CONTAINER_COLLECT_ALL=true \
           -e DD_CONTAINER_EXCLUDE="name:datadog-agent" \
           -e DD_SITE="datadoghq.eu" \
           -v \\.\pipe\docker_engine:\\.\pipe\docker_engine \
           -v c:\programdata\docker\containers:c:\programdata\docker\containers:ro
           gcr.io/datadoghq/agent:latest