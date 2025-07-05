@echo off
cd %~dp0
docker compose pull
docker compose up -d
start http://localhost:8080
```

## run.sh
```bash
#!/usr/bin/env bash
cd "$(dirname "$0")"
docker compose pull
docker compose up -d
xdg-open http://localhost:8080 || true