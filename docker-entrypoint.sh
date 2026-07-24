#!/bin/bash
set -e

# Render PORT ortam değişkenini kullan, yoksa varsayılan 10000
PORT="${PORT:-10000}"

# Apache'yi doğru porta dinlet
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf

echo "Apache ${PORT} portunda başlatılıyor..."

# Orijinal CMD'yi çalıştır
exec "$@"
