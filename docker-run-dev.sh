SERVER_NAME=qumacode.localhost \
HTTP_PORT=80 \
HTTPS_PORT=443 \
POSTGRES_USER=qumacode_user \
POSTGRES_PASSWORD=qumacode_password \
POSTGRES_DB=qumacode_db \
POSTGRES_VERSION=16 \
POSTGRES_CHARSET=utf8 \
docker compose up -d --build

echo 'run click https://qumacode.localhost'
