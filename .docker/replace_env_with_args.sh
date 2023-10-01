#! /bin/bash

# APP

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

if [ ! -z "$APP_ENV" ]; then
  sed -i "s#APP_ENV=.*#APP_ENV=$APP_ENV#g" .env
fi

if [ ! -z "$APP_DEBUG" ]; then
  sed -i "s#APP_DEBUG=.*#APP_DEBUG=$APP_DEBUG#g" .env
fi

if [ ! -z "$APP_KEY" ]; then
  sed -i "s#APP_KEY=.*#APP_KEY=$APP_KEY#g" .env
fi

if [ ! -z "$APP_URL" ]; then
  sed -i "s#APP_URL=.*#APP_URL=$APP_URL#g" .env
fi

if [ ! -z "$LOG_CHANNEL" ]; then
  sed -i "s#LOG_CHANNEL=.*#LOG_CHANNEL=$LOG_CHANNEL#g" .env
fi

# DATABASE

if [ ! -z "$DB_CONNECTION" ]; then
  sed -i "s#DB_CONNECTION=.*#DB_CONNECTION=$DB_CONNECTION#g" .env
fi

if [ ! -z "$DB_HOST" ]; then
  sed -i "s#DB_HOST=.*#DB_HOST=$DB_HOST#g" .env
fi

if [ ! -z "$DB_PORT" ]; then
  sed -i "s#DB_PORT=.*#DB_PORT=$DB_PORT#g" .env
fi

if [ ! -z "$DB_DATABASE" ]; then
  sed -i "s#DB_DATABASE=.*#DB_DATABASE=$DB_DATABASE#g" .env
fi

if [ ! -z "$DB_USERNAME" ]; then
  sed -i "s#DB_USERNAME=.*#DB_USERNAME=$DB_USERNAME#g" .env
fi

if [ ! -z "$DB_PASSWORD" ]; then
  sed -i "s#DB_PASSWORD=.*#DB_PASSWORD=$DB_PASSWORD#g" .env
fi

# SMTP

if [ ! -z "$MAIL_HOST" ]; then
  sed -i "s#MAIL_HOST=.*#MAIL_HOST=$MAIL_HOST#g" .env
fi

if [ ! -z "$MAIL_PORT" ]; then
  sed -i "s#MAIL_PORT=.*#MAIL_PORT=$MAIL_PORT#g" .env
fi

if [ ! -z "$MAIL_USERNAME" ]; then
  sed -i "s#MAIL_USERNAME=.*#MAIL_USERNAME=$MAIL_USERNAME#g" .env
fi

if [ ! -z "$MAIL_PASSWORD" ]; then
  sed -i "s#MAIL_PASSWORD=.*#MAIL_PASSWORD=$MAIL_PASSWORD#g" .env
fi

if [ ! -z "$MAIL_ENCRYPTION" ]; then
  sed -i "s#MAIL_ENCRYPTION=.*#MAIL_ENCRYPTION=$MAIL_ENCRYPTION#g" .env
fi

if [ ! -z "$MAIL_FROM_ADDRESS" ]; then
  sed -i "s#MAIL_FROM_ADDRESS=.*#MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS#g" .env
fi

if [ ! -z "$MAIL_FROM_NAME" ]; then
  sed -i "s#MAIL_FROM_NAME=.*#MAIL_FROM_NAME=$MAIL_FROM_NAME#g" .env
fi
