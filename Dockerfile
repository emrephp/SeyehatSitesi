FROM php:8.3-apache

# Apache mod_rewrite aktifleştir (ileride SaaS için URL routing gerekecek)
RUN a2enmod rewrite

# Apache'nin DocumentRoot'unu sayehat.com klasörüne yönlendir
ENV APACHE_DOCUMENT_ROOT=/var/www/html/sayehat.com

# Apache konfigürasyonunu güncelle
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# .htaccess dosyalarının çalışması için AllowOverride ayarla
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Proje dosyalarını kopyala
COPY . /var/www/html/

# Render, PORT ortam değişkenini dinamik olarak atar
# Apache'yi bu porta dinletmek için entrypoint script kullan
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Dosya izinlerini ayarla
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
